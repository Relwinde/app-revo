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
            'title' => 'Opérations',
            'subtitle' => 'Liste des opérations',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Opérations']
            ]
        ];

        $dossiers = Dossier::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.dossier.dossiers', ['pageHeader' => $pageHeader, 'dossiers' => $dossiers])->layout('components.layouts.app', ['title' => 'Opérations'] );
    }
}
