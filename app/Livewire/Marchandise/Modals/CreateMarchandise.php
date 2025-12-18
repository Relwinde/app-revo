<?php

namespace App\Livewire\Marchandise\Modals;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CreateMarchandise extends ModalComponent
{
    public function render()
    {
        return view('livewire.marchandise.modals.create-marchandise');
    }
}
