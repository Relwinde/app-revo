<?php

namespace App\Livewire\Dossier;

use App\Models\Dossier;
use Livewire\Component;
use Livewire\Attributes\On;

class Dossiers extends Component
{
    public $search;

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

        $dossiers = Dossier::where('numero', 'like', "%{$this->search}%")
            ->orWhereHas('client', function($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orWhereHas('camion', function($query) {
                $query->where('license_plate', 'like', "%{$this->search}%");
            })
            ->orWhereHas('chauffeur', function($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.dossier.dossiers', ['pageHeader' => $pageHeader, 'dossiers' => $dossiers])->layout('components.layouts.app', ['title' => 'Opérations'] );
    }

    public function clear_search()
    {
        $this->search = '';
    }
}
