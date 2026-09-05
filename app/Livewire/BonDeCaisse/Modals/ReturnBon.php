<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\BonDeCaisse;
use LivewireUI\Modal\ModalComponent;
use App\Models\BonDeCaisseCommentaire;
use Illuminate\Support\Facades\DB;

class ReturnBon extends ModalComponent
{

    public BonDeCaisse $bon;
    public $commentaire;

    
    public function render()
    {
        return view('livewire.bon-de-caisse.modals.return-bon');
    }

    public function stepBack (){
       abort_unless(auth()->user()->can('Retourner Bon de caisse'), 403);

       switch ($this->bon->etape) {
            case 'CAISSE':
                try{
                    DB::beginTransaction();
                        $this->bon->update([
                            'etape' => 'MANAGER',
                        ]);

                        
                        $this->bon->etapeBons()->create([
                            'etape_precedente' => 'CAISSE',
                            'etape_actuelle' => 'MANAGER',
                            'montant' => $this->bon->montant_definitif,
                            'user_id' => auth()->id(),
                        ]);

                        BonDeCaisseCommentaire::create([
                            'content' => $this->commentaire,
                            'etape' => 'CAISSE',
                            'bon_de_caisse_id' => $this->bon->id,
                            'user_id' => auth()->id(),
                        ]);
                    DB::commit();
                    $this->dispatch('bon-updated');
                    $this->closeModal();
                } catch (\Exception $e){
                    DB::rollBack();
                    throw $e;
                    return;
                }
                break;
            case 'MANAGER':
                try{
                    DB::beginTransaction();
                        $this->bon->update([
                            'etape' => 'EMETTEUR',
                        ]);

                        
                        $this->bon->etapeBons()->create([
                            'etape_precedente' => 'MANAGER',
                            'etape_actuelle' => 'EMETTEUR',
                            'montant' => $this->bon->montant_definitif,
                            'user_id' => auth()->id(),
                        ]);

                        BonDeCaisseCommentaire::create([
                            'content' => $this->commentaire,
                            'etape' => 'MANAGER',
                            'bon_de_caisse_id' => $this->bon->id,
                            'user_id' => auth()->id(),
                        ]);
                    DB::commit();
                    $this->dispatch('bon-updated');
                    $this->closeModal();
                } catch (\Exception $e){
                    DB::rollBack();
                    throw $e;
                    return;
                }
                break;
        }

    }
}
