<div>
    @include('partials.pages.header')

    <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'caisse.modals.create-depot' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-hand-holding-usd"></i> Effectuer un dépôt
                    </button>
                </div>
            </div>
    </div>
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h3 font-w700">{{ number_format($caisse->solde, 2, '.', ' ') }}</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-piggy-bank font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Solde
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h3 font-w700">{{ number_format($sommeAttente, 2, '.', ' ') }}</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-th-list font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            En attente de paiement
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h3 font-w700">{{ number_format($sommeDepots, 2, '.', ' ') }}</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-hand-holding-usd font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Dépôts du jour
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h3 font-w700">{{ number_format($sommeDecaissements, 2, '.', ' ') }}</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-level-up-alt font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Décaissements du jour
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
                <div class="p-3">
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" wire:model.live="view" value="bons">
                        <span class="custom-control-label">Bons à la caisse</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" wire:model.live="view" value="mouvements">
                        <span class="custom-control-label">Mouvements de la caisse</span>
                    </label>
                </div>

                @if ($view === 'bons')
                    <div class="input-group px-3 pb-3">
                        @if ($search != null && $search != "")
                            <div class="input-group-prepend">
                                <button wire:click="clear_search" type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                            </div>
                        @endif
                        <input wire:model.live.debounce.500ms="search" type="text" class="form-control" placeholder="Recherche..." id="page-header-search-input" name="page-header-search-input">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Dépenses engagées</th>
                                    <th>Montant</th>
                                    <th>Dossier/Véhicule</th>
                                    <th>Emetteur</th>
                                    <th>Mode de paiement</th>
                                    <th>Etape</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bons as $bon)
                                    <tr>
                                        <td>{{ $bon->numero }}</td>
                                        <td>{{ $bon->description ?? $bon->depense }}</td>
                                        <td>{{ number_format($bon->montant_definitif, 2, '.', ' ') }}</td>
                                        <td>{{ $bon->camion ? $bon->camion->license_plate : ($bon->dossier ? $bon->dossier->numero : 'N/A') }}</td>
                                        <td>{{ $bon->user->name }}</td>
                                        <td>
                                            @if ($bon->type_paiement === 'ESPECE')
                                                Espèces
                                            @elseif ($bon->type_paiement === 'CHEQUE')
                                                Chèque
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge @if ($bon->etape == 'EMETTEUR') badge-primary @elseif ($bon->etape == 'MANAGER') badge-warning @elseif ($bon->etape == 'CAISSE') badge-danger @elseif ($bon->etape == 'PAYE') badge-warning @elseif ($bon->etape == 'CLOS') badge-dark @endif">{{ $bon->etape }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button wire:click="$dispatch('openModal', { component: 'bon_de_caisse.modals.view-bon', arguments: { bon: {{ $bon }} } })"
                                                    class="btn btn-sm btn-primary" title="Voir">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            Aucun bon de caisse trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($bons instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="px-3 pb-3">
                            {{ $bons->links() }}
                        </div>
                    @endif
                @else
                    <div class="row px-3 pb-3">
                        <div class="col-md-3">
                            <label class="font-w600">Du :</label>
                            <input type="date" wire:model.live="dateDu" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="font-w600">Au :</label>
                            <input type="date" wire:model.live="dateAu" class="form-control">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Libellé</th>
                                    <th>Montant</th>
                                    <th>Solde après opération</th>
                                    <th>Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mouvements as $mouvement)
                                    <tr>
                                        <td>
                                            @if ($mouvement->is_entree)
                                                <span class="text-primary font-w600">
                                                    <i class="fa fa-caret-down"></i> {{ $mouvement->type }}
                                                </span>
                                            @else
                                                <span class="text-danger font-w600">
                                                    <i class="fa fa-caret-up"></i> {{ $mouvement->type }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $mouvement->libelle }}</td>
                                        <td class="{{ $mouvement->is_entree ? 'text-primary' : 'text-danger' }} font-w600">
                                            {{ $mouvement->is_entree ? '+' : '-' }} {{ number_format($mouvement->montant, 2, '.', ' ') }}
                                        </td>
                                        <td>{{ number_format($mouvement->solde_after, 2, '.', ' ') }}</td>
                                        <td>{{ $mouvement->created_at->translatedFormat('j F Y') }} à {{ $mouvement->created_at->format('H:i') }}</td>
                                        <td class="text-center">
                                            @if ($mouvement->related_bon)
                                                <button wire:click="$dispatch('openModal', { component: 'bon_de_caisse.modals.view-bon', arguments: { bon: {{ $mouvement->related_bon }} } })"
                                                    class="btn btn-sm btn-primary" title="Voir">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </button>
                                            @elseif ($mouvement->depot_id)
                                                <a href="{{ route('print-depot', $mouvement->depot_id) }}" target="_blank"
                                                    class="btn btn-sm btn-primary" title="Voir">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Aucun mouvement trouvé.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($mouvements instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="px-3 pb-3">
                            {{ $mouvements->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>


@script
    <script>
        Livewire.on('print-depot', ({ url }) => {
            window.open(url, '_blank');
        });
    </script>

@endscript
