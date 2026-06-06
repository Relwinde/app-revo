<?php

namespace App\Livewire\Commande;

use Livewire\Component;
use App\Models\Commande;
use Livewire\Attributes\On;

class Commandes extends Component
{
    public $search;

    #[On('commande-created')]
    #[On('commande-updated')]
    public function render()
    {
        $pageHeader = [
            'title' => 'Manifestes',
            'subtitle' => 'Liste des PO',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'PO']
            ]
        ];

        $commandes = Commande::where('numero', 'like', "%{$this->search}%")
            ->orWhere('fournisseur', 'like', "%{$this->search}%")
            ->orWhere('marchandise', 'like', "%{$this->search}%")
            ->orWhereHas('dossier', function($query) {
                $query->where('numero', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.commande.commandes', ['pageHeader' => $pageHeader, 'commandes' => $commandes])->layout('components.layouts.app', ['title' => 'PO'] );
    }

    public function clear_search()
    {
        $this->search = '';
    }
}
