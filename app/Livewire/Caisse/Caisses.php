<?php

namespace App\Livewire\Caisse;

use Carbon\Carbon;
use App\Models\Depot;
use App\Models\Caisse;
use Livewire\Component;
use App\Models\BonDeCaisse;
use App\Models\SuiviCaisse;
use Livewire\Attributes\On;
use App\Models\AjustementBon;

class Caisses extends Component
{
    public $search;

    #[On('depot-created')]
    #[On('bon-updated')]
    #[On('new-ajustement')]
    public function render()
    {
        $pageHeader = [
            'title' => 'Caisse',
            'subtitle' => 'Activités de la caisse',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Caisse']
            ]
        ];

        $sommeAttente= BonDeCaisse::where('bon_de_caisses.etape', 'CAISSE')->sum('montant');
        $caisse = Caisse::find(1);

        $sommeDepots = Depot::whereDate('depots.created_at', Carbon::today())->sum('montant') + AjustementBon::where('ajustement_bons.type', 'RESTITUTION')->whereDate('ajustement_bons.created_at', Carbon::today())
        ->sum('montant');

        $sommeDecaissements = SuiviCaisse::whereNotNull('suivi_caisses.bon_de_caisse_id')
        ->whereDate('suivi_caisses.created_at', Carbon::today())
        ->sum('montant') + AjustementBon::where('ajustement_bons.type', 'EXCEDANT')->whereDate('ajustement_bons.created_at', Carbon::today())
        ->sum('montant');

        $bons = BonDeCaisse::orderBy('created_at', 'desc')
        // 1. Group the statuses into one requirement
        ->whereIn('etape', ['CAISSE', 'PAYE', 'CLOS']) 
        
        // 2. Keep the search logic as a single grouped AND requirement
        ->where(function($query) {
            $query->where('numero', 'like', "%{$this->search}%")
                ->orWhereHas('dossier', function($q) {
                    $q->where('numero', 'like', "%{$this->search}%");
                })
                ->orWhereHas('user', function($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
        })
        ->paginate(10);
                


        return view('livewire.caisse.caisses', ['pageHeader' => $pageHeader, 'sommeAttente' => $sommeAttente, 'caisse' => $caisse, 'sommeDepots' => $sommeDepots, 'sommeDecaissements' => $sommeDecaissements, 'bons' => $bons])->layout('components.layouts.app', ['title' => 'Caisse']);
    }

    public function clear_search()
    {
        $this->search = '';
    }
}
