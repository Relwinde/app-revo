<?php

namespace App\Livewire\Caisse\Modals;

use App\Models\Depot;
use App\Models\Caisse;
use App\Models\SuiviCaisse;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateDepot extends ModalComponent
{

    public $montant;
    public $libelle;
    public $banque;
    public $ref_cheque;
    public $deposant;

    public function render()
    {
        return view('livewire.caisse.modals.create-depot');
    }

    public function save (){
        abort_unless(auth()->user()->can('Créer Dépôt caisse'), 403);

        $this->validate([
            'montant' => 'required|numeric',
            'libelle' => 'required|string',
            'banque' => 'nullable|string',
            'ref_cheque' => 'nullable|string',
            'deposant' => 'nullable|string',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'libelle.required' => 'Le libellé est obligatoire.',
            'libelle.string' => 'Le libellé doit être une chaîne de caractères.',
            'banque.string' => 'La banque doit être une chaîne de caractères.',
            'ref_cheque.string' => 'La référence du chèque doit être une chaîne de caractères.',
            'deposant.string' => 'Le déposant doit être une chaîne de caractères.',
        ]);

        $depot = Depot::make([
            'montant' => $this->montant,
            'libelle' => $this->libelle,
            'banque' => $this->banque,
            'ref_cheque' => $this->ref_cheque,
            'deposant' => $this->deposant,
            'user_id' => auth()->id(),
        ]);

        try {
            DB::beginTransaction();
                $caisse = Caisse::find(1);
                $depot->save();

                $suiviCaisse = SuiviCaisse::make([
                    'montant' => $this->montant,
                    'solde_before' => $caisse->solde,
                    'solde_after' => $caisse->solde + $this->montant,
                    'depot_id' => $depot->id,
                    'user_id' => auth()->id(),
                ]);

                $caisse->increment('solde', $this->montant);

                $suiviCaisse->save();

            DB::commit();
            $this->dispatch('depot-created');
            $url = route('print-depot', ['depot' => $depot->id]);
    
            $this->dispatch('print-depot', url: $url);

            $this->closeModal();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error', ['message' => "Une erreur est survenue lors de la création du dépôt : " . $e->getMessage()]);
            return;
        }
    }
}
