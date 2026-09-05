<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\Caisse;
use App\Models\BonDeCaisse;
use App\Models\SuiviCaisse;
use App\Models\AjustementBon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;



class CreateAjustement extends ModalComponent
{

    public BonDeCaisse $bon;
    public $montant;
    public $libelle;
    public $type;
    public $montantAfter;
    

    public function render()
    {
        switch($this->type){
            case 1: 
                if ($this->montant != null && $this->montant >= 0){
                    $this->montantAfter = $this->bon->montant_definitif + $this->montant;
                }
                break;
                
            case 2: 
                if ($this->montant != null && $this->montant >= 0){
                    $this->montantAfter = $this->bon->montant_definitif - $this->montant;
                }
                break;
        }
        return view('livewire.bon-de-caisse.modals.create-ajustement');
    }

    public function save (){
        abort_unless(auth()->user()->can('Faire un ajustement sur bon de caisse'), 403);

        $this->validate([
            'montant' => 'required|numeric',
            'libelle' => 'required|string',
            'type' => 'required|in:1,2',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type sélectionné est invalide.',
        ]);

        try{
            DB::beginTransaction();
                switch($this->type){
                    case 1:
                        $montantBefore = $this->bon->montant_definitif;
                        $ajustement = AjustementBon::make([
                            'bon_de_caisse_id' => $this->bon->id,
                            'libelle' => $this->libelle,
                            'type' => 'EXCEDANT',
                            'montant'=>$this->montant,
                            'montant_bon_before' => $this->bon->montant_definitif,
                            'montant_bon_after' => $this->bon->montant_definitif + $this->montant,
                            'user_id' => Auth::user()->id,
                        ]);

                        $this->bon->montant_definitif = $this->bon->montant_definitif + $this->montant;

                        if ($this->bon->save()){

                            if ($ajustement->save()){

                                $caisse = Caisse::find(1);
                                $soldeBefore = $caisse->solde;
                                $caisse->solde = $caisse->solde - $this->montant;

                                if ($caisse->save()){
                                    SuiviCaisse::create([
                                        'ajustement_bon_id'=> $ajustement->id,
                                        'solde_before' => $soldeBefore,
                                        'montant' => $ajustement->montant,
                                        'solde_after'=>$caisse->solde,
                                        'user_id'=> Auth::user()->id
                                    ]);

                                    $this->dispatch('new-ajustement');
                                    $this->closeModal();
                                }

                            }

                        }
                    break;

                    case 2: 
                        if($this->montant > $this->bon->montant_definitif){
                            // $this->dispatch('insufficient-funds');
                            // $this->closeModal();
                            // $this->reset();

                            $this->addError('montant', 'Le montant de la restitution ne peut pas être supérieur au montant du bon de caisse.');
                            break;
                        }

                        $montantBefore = $this->bon->montant_definitif;
                        $ajustement = AjustementBon::make([
                            'bon_de_caisse_id' => $this->bon->id,
                            'libelle' => $this->libelle,
                            'type' => 'RESTITUTION',
                            'montant'=> $this->montant,
                            'montant_bon_before' => $this->bon->montant_definitif,
                            'montant_bon_after' => $this->bon->montant_definitif - $this->montant,
                            'user_id' => Auth::user()->id,
                        ]);

                        $this->bon->montant_definitif = $this->bon->montant_definitif - $this->montant;

                        if ($this->bon->save()){

                            if ($ajustement->save()){

                                $caisse = Caisse::find(1);
                                $soldeBefore = $caisse->solde;
                                $caisse->solde = $caisse->solde + $ajustement->montant;

                                if ($caisse->save()){
                                    SuiviCaisse::create([
                                        'ajustement_bon_id'=> $ajustement->id,
                                        'solde_before' => $soldeBefore,
                                        'montant' => $ajustement->montant,
                                        'solde_after'=>$caisse->solde,
                                        'user_id'=> Auth::user()->id
                                    ]);
                                    $this->dispatch('new-ajustement');
                                    $this->closeModal();
                                }

                            }

                        }
                    break;

                diefault:
                        break;

                }

            DB::commit();
            $this->dispatch('bon-updated');
        } catch (\Exception $e){
            DB::rollBack();
            throw $e;
            return;
        }

        $this->closeModal();
    }
}
