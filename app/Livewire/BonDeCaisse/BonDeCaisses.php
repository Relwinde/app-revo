<?php

namespace App\Livewire\BonDeCaisse;

use Livewire\Component;

class BonDeCaisses extends Component
{
    public function render()
    {
        $pageHeader = [
            'title' => 'Bons de caisse',
            'subtitle' => 'Liste des bons de caisse',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Bons de caisse']
            ]
        ];

        return view('livewire.bon-de-caisse.bon-de-caisses', ['pageHeader' => $pageHeader])->layout('components.layouts.app', ['title' => 'Bons de caisse']);
    }
}
