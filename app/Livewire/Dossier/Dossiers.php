<?php

namespace App\Livewire\Dossier;

use App\Models\Dossier;
use Livewire\Component;
use Livewire\Attributes\On;

class Dossiers extends Component
{
    #[On('dossier-created')]
    #[On('dossier-updated')]
    public function render()
    {

         $pageHeader = [
            'title' => 'Bons de commande',
            'subtitle' => 'Liste des bons de commande',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Bons de commande']
            ]
        ];

        $dossiers = Dossier::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.dossier.dossiers', ['pageHeader' => $pageHeader, 'dossiers' => $dossiers])->layout('components.layouts.app', ['title' => 'Bons de commande'] );
    }
}
