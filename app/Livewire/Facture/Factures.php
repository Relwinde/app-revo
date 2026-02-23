<?php

namespace App\Livewire\Facture;

use App\Models\Facture;
use Livewire\Component;

class Factures extends Component
{
    public $search;

    public function render()
    {


        $factures = Facture::with('client')
            ->when($this->search, function ($query) {
                $query->where('reference', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        $pageHeader = [
            'title' => 'Factures Définitives',
            'subtitle' => 'Liste des factures définitives',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Factures Définitives'],
                ],
                ];

        return view('livewire.facture.factures', ['pageHeader' => $pageHeader, 'factures' => $factures])->layout('components.layouts.app', ['title' => 'Factures Définitives']);
    }


    public function clear_search ()
    {
        $this->search = '';
    }

}
