<?php

namespace App\Livewire\Dossier\Modals;

use App\Models\Dossier;
use App\Models\Commande;
use LivewireUI\Modal\ModalComponent;

class AddCommande extends ModalComponent
{

    public Dossier $dossier;

    public function render()
    {
        $commandes = Commande::whereDoesntHave('dossiers', function($query) {
            $query->where('dossier_id', $this->dossier->id);
        })->get();

        return view('livewire.dossier.modals.add-commande', ['commandes' => $commandes]);
    }

    public function addCommande(Commande $commande)
    {
        $this->dossier->commandes()->attach($commande->id);
        $this->dispatch('commande-attached');
    }
}
