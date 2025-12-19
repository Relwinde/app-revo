<?php

namespace App\Livewire\Caisse\Modals;

use LivewireUI\Modal\ModalComponent;

class CreateDepot extends ModalComponent
{
    public function render()
    {
        return view('livewire.caisse.modals.create-depot');
    }
}
