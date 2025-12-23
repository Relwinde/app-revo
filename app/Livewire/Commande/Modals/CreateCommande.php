<?php

namespace App\Livewire\Commande\Modals;


use App\Models\Client;
use App\Models\Commande;
use App\Models\Fournisseur;
use App\Models\Marchandise;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateCommande extends ModalComponent
{

    public $fournisseur_id;
    public $marchandise_id;
    public $quantite;
    public $description;
    public $numero;

    public function render()
    {
        $fournisseurs = Fournisseur::all();
        $marchandises = Marchandise::all();

        
        return view('livewire.commande.modals.create-commande', [
            'fournisseurs' => $fournisseurs,
            'marchandises' => $marchandises
        ]);
    }

    public function create()
    {
        // Validation and creation logic here
        $this->validate(
            [
                'fournisseur_id' => ['required', 'exists:fournisseurs,id'],
                'marchandise_id' => ['required', 'exists:marchandises,id'],
                'quantite' => ['required', 'integer', 'min:1'],
                'description' => ['required', 'string'],
                'numero' => ['required', 'string', 'unique:commandes,numero'],
            ],
            [
                'fournisseur_id.exists' => 'Le fournisseur sélectionné est invalide.',
                'fournisseur_id.required' => 'Le fournisseur est obligatoire.',
                'marchandise_id.required' => 'La marchandise est obligatoire.',
                'marchandise_id.exists' => 'La marchandise sélectionnée est invalide.',
                'quantite.required' => 'La quantité est obligatoire.',
                'quantite.integer' => 'La quantité doit être un nombre entier.',
                'quantite.min' => 'La quantité doit être au moins de 1.',
                'numero.required' => 'Le numéro de commande est obligatoire.',
                'numero.unique' => 'Ce numéro de commande existe déjà.',
            ]
        );


        // Create the Commande
        $commande = Commande::make([
            'fournisseur_id' => $this->fournisseur_id,
            'marchandise_id' => $this->marchandise_id,
            'quantite' => $this->quantite,
            'description' => $this->description,
            'numero' => $this->numero,
            'user_id' => auth()->id(),
        ]);

        try {
            DB::beginTransaction();
            $commande->save();
            DB::commit();
        } catch (\Exception $e) {
            throw $e;
            DB::rollBack();
            $this->dispatch('error');
            return;
        }

        $this->dispatch('commande-created');
        $this->reset();
        $this->closeModal();
    }
}
