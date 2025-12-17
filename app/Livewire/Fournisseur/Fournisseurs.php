<?php

namespace App\Livewire\Fournisseur;

use Livewire\Component;
use App\Models\Fournisseur;

class Fournisseurs extends Component
{
    public function render()
    {

        $fournisseurs = Fournisseur::orderBy('name', 'asc')->paginate(10);

        $pageHeader = [
            'title' => 'Fournisseurs',
            'subtitle' => 'Liste des fournisseurs',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Fournisseurs']
            ]
        ];

        return view('livewire.fournisseur.fournisseurs', [
            'fournisseurs' => $fournisseurs,
            'pageHeader' => $pageHeader,
        ])->layout('components.layouts.app', ['title' => 'Fournisseurs']);
    }
}
