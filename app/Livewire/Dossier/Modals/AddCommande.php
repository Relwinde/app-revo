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
        $commandes = Commande::where('dossier_id', null)->get();

        return view('livewire.dossier.modals.add-commande', ['commandes' => $commandes]);
    }

    public function addCommande(Commande $commande)
    {
        $commande->dossier_id = $this->dossier->id;
        $commande->save();
        $this->dispatch('commande-attached');
    }
}
