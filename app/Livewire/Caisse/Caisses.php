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

        $bons = BonDeCaisse::orderBy('created_at', 'desc')->where('etape', 'CAISSE')->orWhere('etape', 'PAYE')->orWhere('etape', 'CLOS')->paginate(10);


        return view('livewire.caisse.caisses', ['pageHeader' => $pageHeader, 'sommeAttente' => $sommeAttente, 'caisse' => $caisse, 'sommeDepots' => $sommeDepots, 'sommeDecaissements' => $sommeDecaissements, 'bons' => $bons])->layout('components.layouts.app', ['title' => 'Caisse']);
    }
}
