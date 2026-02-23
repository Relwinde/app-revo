<?php

namespace App\Livewire\Commande\Modals;


use App\Models\Commande;
use App\Models\Dossier;
use App\Models\Fournisseur;
use App\Models\Marchandise;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateCommande extends ModalComponent
{

    // allow null and provide default to avoid uninitialized property error
    public ?Dossier $dossier = null;

    public $fournisseur; // Fournisseur doit être saisi 
    public $marchandise_id;
    public $quantite;
    public $description; // Type d'amballage ou autres détails
    public $numero;

    // accept an optional dossier when the component is mounted
    

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
                'fournisseur' => ['required'],
                'marchandise_id' => ['required', 'exists:marchandises,id'],
                'quantite' => ['required', 'integer', 'min:1'],
                'description' => ['string'],
                'numero' => ['required', 'string', 'unique:commandes,numero'],
            ],
            [
                'fournisseur.required' => 'Le fournisseur est obligatoire.',
                'marchandise_id.required' => 'La marchandise est obligatoire.',
                'marchandise_id.exists' => 'La marchandise sélectionnée est invalide.',
                'quantite.required' => 'La quantité est obligatoire.',
                'quantite.integer' => 'La quantité doit être un nombre entier.',
                'quantite.min' => 'La quantité doit être au moins de 1.',
                'numero.required' => 'Le numéro de commande est obligatoire.',
                'numero.unique' => 'Ce numéro de commande existe déjà.',
                'description.string' => 'La description doit être une chaîne de caractères.',
            ]
        );


        // Create the Commande
        $commande = Commande::make([
            'fournisseur' => $this->fournisseur,
            'marchandise_id' => $this->marchandise_id,
            'quantite' => $this->quantite,
            'description' => $this->description,
            'numero' => $this->numero,
            'user_id' => auth()->id(),
            'dossier_id' => $this?->dossier?->id,
        ]);

        try {
            DB::beginTransaction();
            $commande->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
            return;
        }

        $this->dispatch('commande-created');
        $this->reset();
        $this->closeModal();
    }
}
