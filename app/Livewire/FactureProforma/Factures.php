<?php

namespace App\Livewire\FactureProforma;

use Livewire\Component;
use App\Models\FactureProforma;

class Factures extends Component
{
    public $search;

    
    public function render()
    {

        $factureProformas = FactureProforma::with('client')
            ->when($this->search, function ($query) {
                $query->where('reference', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $pageHeader = [
            'title' => 'Factures Pro-Forma',
            'subtitle' => 'Liste des factures pro-forma',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Factures Pro-Forma'],
                ],
                ];
                
                
                
        return view('livewire.facture-proforma.factures', [
                    'pageHeader' => $pageHeader, 'factureProformas' => $factureProformas,
                    ])->layout('components.layouts.app', ['title' => 'Factures Pro-Forma']);
    }
                    
                    
    public function clear_search ()
    {
        $this->search = '';
    }

}
