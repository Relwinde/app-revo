<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\Caisse;
use App\Models\Camion;
use App\Models\Dossier;
use App\Models\BonDeCaisse;
use App\Models\SuiviCaisse;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class ViewBon extends ModalComponent
{

    public BonDeCaisse $bon;
    public $depense; 
    public $montant;
    public $description;
    public $camion_id;
    public $dossier_id;

    public $comments = false;

    public $type_paiement;
    
    public $editMode = false;


    public function mount (){
        $this->depense = $this->bon->depense;
        $this->montant = $this->bon->montant_definitif;
        $this->description = $this->bon->description;
        $this->camion_id = $this->bon->camion_id;
        $this->dossier_id = $this->bon->dossier_id;
    }

    #[On('bon-updated')]
    #[On('documents-uploaded')]
    public function render()
    {
        $dossiers = Dossier::all();
        $camions = Camion::all();
        return view('livewire.bon-de-caisse.modals.view-bon', ['dossiers' => $dossiers, 'camions' => $camions]);
    }

    public function update (){
        $this->validate([
            'montant' => 'required|numeric',
            'depense' => 'required|string',
            'description' => 'nullable|string',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'depense.required' => 'La dépense est obligatoire.',
            'depense.string' => 'La dépense doit être une chaîne de caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
        ]);

        $this->bon->update([
            'montant' => $this->montant,
            'montant_definitif' => $this->montant,
            'depense' => $this->depense,
            'description' => $this->description,
            'camion_id' => $this->camion_id,
            'dossier_id' => $this->dossier_id,
        ]);

        $this->dispatch('bon-updated');
        $this->render();
        $this->editMode = false;
    }

    public function toggleEditMode ()
    {
        $this->editMode = ! $this->editMode;
    }

    public function nextStep (){
        switch ($this->bon->etape) {
            case 'EMETTEUR':
                try {
                    DB::beginTransaction();
                        $this->bon->etapeBons()->create([
                        'etape_precedente' => 'EMETTEUR',
                        'etape_actuelle' => 'MANAGER',
                        'montant' => $this->bon->montant_definitif,
                        'user_id' => auth()->id(),
                        ]);
                        $this->bon->update(['etape' => 'MANAGER']);
                    DB::commit();
                    $this->dispatch('bon-updated');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                    return;
                }
                break;


            case 'MANAGER':
                try {
                    DB::beginTransaction();
                        $this->bon->etapeBons()->create([
                        'etape_precedente' => 'MANAGER',
                        'etape_actuelle' => 'CAISSE',
                        'montant' => $this->bon->montant_definitif,
                        'user_id' => auth()->id(),
                        ]);
                        $this->bon->update(['etape' => 'CAISSE']);
                    DB::commit();
                    $this->dispatch('bon-updated');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                    return;
                }
                break;

            case 'CAISSE':
                $this->validate([
                    'type_paiement' => 'required|string|in:ESPECE,CHEQUE',
                ], [
                    'type_paiement.required' => 'Le type de paiement est obligatoire.',
                    'type_paiement.string' => 'Le type de paiement doit être une chaîne de caractères.',
                    'type_paiement.in' => 'Le type de paiement sélectionné est invalide.',
                ]);

                $caisse = Caisse::find(1);
                try {
                    DB::beginTransaction();
                        $this->bon->etapeBons()->create([
                        'etape_precedente' => 'CAISSE',
                        'etape_actuelle' => 'PAYE',
                        'montant' => $this->bon->montant_definitif,
                        'user_id' => auth()->id(),
                        ]);

                        if($this->type_paiement == 'CHEQUE'){
                            $this->bon->update(['type_paiement' => 'CHEQUE']);
                        }else{
                            if($caisse->solde < $this->bon->montant_definitif){
                                $this->dispatch('error', ['message' => 'Le solde de la caisse est insuffisant pour effectuer ce décaissement.']);
                                return;
                            }
                            $this->bon->update(['type_paiement' => 'ESPECE']);
                            $suiviCaisse = SuiviCaisse::make([
                                'bon_de_caisse_id' => $this->bon->id,
                                'solde_before' => $caisse->solde,
                                'solde_after' => $caisse->solde - $this->bon->montant_definitif,
                                'user_id' => auth()->id(),
                                'montant' => $this->bon->montant_definitif,
                            ]);
                            $suiviCaisse->save();
                            $caisse->decrement('solde', $this->bon->montant_definitif);
                        }

                        $this->bon->update(['etape' => 'PAYE']);       
                    DB::commit();
                    $this->dispatch('bon-updated');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                    return;
                }
                break;
            
            case 'PAYE':
                try {
                    DB::beginTransaction();
                        $this->bon->etapeBons()->create([
                        'etape_precedente' => 'PAYE',
                        'etape_actuelle' => 'CLOS',
                        'montant' => $this->bon->montant_definitif,
                        'user_id' => auth()->id(),
                        ]);
                    DB::commit();
                    $this->dispatch('bon-updated');
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                    return;
                }
                $this->bon->update(['etape' => 'CLOS']);
                break;
            default:
                break;
        }
    }


    public function printRecu (){
        $this->dispatch('print-recu-bon');
    }

}
