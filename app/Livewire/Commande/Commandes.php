<?php

namespace App\Livewire\Commande;

use Livewire\Component;
use App\Models\Commande;
use Livewire\Attributes\On;

class Commandes extends Component
{
    #[On('commande-created')]
    #[On('commande-updated')]
    public function render()
    {
        $pageHeader = [
            'title' => 'Manifestes',
            'subtitle' => 'Liste des bons de commande',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Bons de commande']
            ]
        ];

        $commandes = Commande::with(['marchandise'])->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.commande.commandes', ['pageHeader' => $pageHeader, 'commandes' => $commandes])->layout('components.layouts.app', ['title' => 'Bons de commande'] );
    }
}
