<?php

namespace App\Livewire\BonDeCaisse;

use Livewire\Component;
use App\Models\BonDeCaisse;
use Livewire\Attributes\On;

class BonDeCaisses extends Component
{
    
    #[On('bon-created')]
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

        $bons = BonDeCaisse::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.bon-de-caisse.bon-de-caisses', ['pageHeader' => $pageHeader, 'bons' => $bons])->layout('components.layouts.app', ['title' => 'Bons de caisse']);
    }
}
