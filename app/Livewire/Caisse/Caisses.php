<?php

namespace App\Livewire\Caisse;

use Livewire\Component;

class Caisses extends Component
{

    
    public function render()
    {
        $pageHeader = [
            'title' => 'Caisse',
            'subtitle' => 'Activités de la caisse',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Caisse']
            ]
        ];


        return view('livewire.caisse.caisses', ['pageHeader' => $pageHeader])->layout('components.layouts.app', ['title' => 'Caisse']);
    }
}
