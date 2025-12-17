<?php

namespace App\Livewire\Fournisseur\Modals;

use LivewireUI\Modal\ModalComponent;

class CreateFournisseur extends ModalComponent
{
    public function render()
    {
        return view('livewire.fournisseur.modals.create-fournisseur');
    }
}
