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
use Livewire\WithPagination;

class Caisses extends Component
{
    use WithPagination;

    public $search;
    public $view = 'bons';
    public $dateDu;
    public $dateAu;

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

        $sommeAttente = BonDeCaisse::where('bon_de_caisses.etape', 'CAISSE')->sum('montant');
        $caisse = Caisse::find(1);

        $sommeDepots = Depot::whereDate('depots.created_at', Carbon::today())->sum('montant') + AjustementBon::where('ajustement_bons.type', 'RESTITUTION')->whereDate('ajustement_bons.created_at', Carbon::today())
        ->sum('montant');

        $sommeDecaissements = SuiviCaisse::whereNotNull('suivi_caisses.bon_de_caisse_id')
        ->whereDate('suivi_caisses.created_at', Carbon::today())
        ->sum('montant') + AjustementBon::where('ajustement_bons.type', 'EXCEDANT')->whereDate('ajustement_bons.created_at', Carbon::today())
        ->sum('montant');

        $bons = collect();
        $mouvements = collect();

        if ($this->view === 'bons') {
            $bons = BonDeCaisse::with(['user', 'camion', 'dossier'])
                ->orderBy('created_at', 'desc')
                ->whereIn('etape', ['CAISSE', 'PAYE', 'CLOS'])
                ->when(filled($this->search), function ($query) {
                    $query->where(function ($q) {
                        $q->where('numero', 'like', "%{$this->search}%")
                            ->orWhere('depense', 'like', "%{$this->search}%")
                            ->orWhere('description', 'like', "%{$this->search}%")
                            ->orWhereHas('dossier', function ($sub) {
                                $sub->where('numero', 'like', "%{$this->search}%");
                            })
                            ->orWhereHas('user', function ($sub) {
                                $sub->where('name', 'like', "%{$this->search}%");
                            });
                    });
                })
                ->paginate(10);
        } else {
            $mouvements = SuiviCaisse::with(['bonDeCaisse', 'depot', 'ajustementBon.bon_de_caisse'])
                ->when(filled($this->dateDu), fn ($query) => $query->whereDate('created_at', '>=', $this->dateDu))
                ->when(filled($this->dateAu), fn ($query) => $query->whereDate('created_at', '<=', $this->dateAu))
                ->orderByDesc('created_at')
                ->paginate(10);
        }

        return view('livewire.caisse.caisses', [
            'pageHeader' => $pageHeader,
            'sommeAttente' => $sommeAttente,
            'caisse' => $caisse,
            'sommeDepots' => $sommeDepots,
            'sommeDecaissements' => $sommeDecaissements,
            'bons' => $bons,
            'mouvements' => $mouvements,
        ])->layout('components.layouts.app', ['title' => 'Caisse']);
    }

    public function updatedView()
    {
        $this->resetPage();
    }

    public function updatedDateDu()
    {
        $this->resetPage();
    }

    public function updatedDateAu()
    {
        $this->resetPage();
    }

    public function clear_search()
    {
        $this->search = '';
    }
}
