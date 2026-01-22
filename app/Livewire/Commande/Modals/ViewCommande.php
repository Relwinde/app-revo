<?php

namespace App\Livewire\Commande\Modals;

use Livewire\Component;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Marchandise;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class ViewCommande extends ModalComponent
{


    public Commande $commande;
    public $numero;
    public $fournisseur;
    public $marchandise_id;
    public $quantite;
    public $description;

    public $editMode = false;

    public function mount()
    {
        $this->numero = $this->commande->numero;
        $this->fournisseur = $this->commande->fournisseur;
        $this->marchandise_id = $this->commande->marchandise_id;
        $this->quantite = $this->commande->quantite;
        $this->description = $this->commande->description;
    }

    public function render()
    {
        $marchandises = Marchandise::all();

        return view('livewire.commande.modals.view-commande', ['marchandises' => $marchandises]);
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
    }

    public function update()
    {

        $this->validate([
            'fournisseur' => ['required', 'string'],
            'marchandise_id' => ['required', 'exists:marchandises,id'],
            'quantite' => ['required', 'integer', 'min:1'],
            'description' => ['required', 'string'],
            'numero' => ['required', 'string', 'unique:commandes,numero,'.$this->commande->id],
        ], [
            'fournisseur.required' => 'Le fournisseur est obligatoire.',
            'fournisseur.string' => 'Le fournisseur doit être une chaîne de caractères.',
            'marchandise_id.required' => 'La marchandise est obligatoire.',
            'marchandise_id.exists' => 'La marchandise sélectionnée est invalide.',
            'quantite.required' => 'La quantité est obligatoire.',
            'quantite.integer' => 'La quantité doit être un nombre entier.',
            'quantite.min' => 'La quantité doit être au moins de 1.',
            'numero.required' => 'Le numéro de commande est obligatoire.',
            'numero.unique' => 'Ce numéro de commande existe déjà.',
        ]);

        try {

            DB::beginTransaction();
             $this->commande->update([
                'fournisseur_id' => $this->fournisseur_id,
                'marchandise_id' => $this->marchandise_id,
                'quantite' => $this->quantite,
                'description' => $this->description,
                'numero' => $this->numero,
            ]);
            DB::commit();

            // $this->commande->save();
            

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
            return;
        }

       

        $this->dispatch('commande-updated');
        $this->editMode = false;
    }
}
