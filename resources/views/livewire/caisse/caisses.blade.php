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
                            <dt class="font-size-h2 font-w700">{{ number_format($caisse->solde, 2, '.', ' ') }}</dt>
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
                            <dt class="font-size-h2 font-w700">{{ number_format($sommeAttente, 2, '.', ' ') }}</dt>
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
                            <dt class="font-size-h2 font-w700">{{ number_format($sommeDepots, 2, '.', ' ') }}</dt>
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
                            <dt class="font-size-h2 font-w700">{{ number_format($sommeDecaissements, 2, '.', ' ') }}</dt>
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
                <div class="block-header">
                    <h3 class="block-title">Bons à la caisse</h3>
                    <div class="block-options">
                        {{-- <button wire:click="$dispatch('openModal', { component: 'bon_de_caisse.modals.create-bon' })"
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Nouveau bon
                        </button> --}}
                    </div>
                </div>

                <div class="block-content block-content-full">
                    <div class="input-group p-3">
                        @if ($search != null && $search !="")
                            <div class="input-group-prepend">
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
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
                                    <th>Emétteur</th>
                                    <th>Motif</th>
                                    <th>Montant</th>
                                    <th>Item</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bons as $bon)
                                <tr>
                                    <td>{{ $bon->numero }}</td>
                                    <td>{{ $bon->user->name }}</td>
                                    <td>{{ $bon->depense }}</td>
                                    <td>{{ number_format($bon->montant_definitif, 2, '.', ' ') }}</td>
                                    <td>
                                        {{ $bon->camion ? $bon->camion->license_plate : ($bon->dossier ? $bon->dossier->numero : "NA")}}
                                    </td>
                                    <td>
                                        <span class="badge @if ($bon->etape == 'EMETTEUR') badge-primary @endif  @if ($bon->etape == 'MANAGER') badge-warning @endif @if ($bon->etape == 'CAISSE') badge-info @endif @if ($bon->etape == 'PAYE') badge-success @endif @if ($bon->etape == 'CLOS') badge-dark @endif ">{{ $bon->etape }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button wire:click="$dispatch('openModal', { component: 'bon_de_caisse.modals.view-bon', arguments: { bon: {{ $bon }} } })"
                                                class="btn btn-sm btn-light" title="Voir">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <td colspan="6" class="text-center text-muted">
                                        Aucun bon de caisse trouvé.
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>



    {{-- Nothing in the world is as soft and yielding as water. --}}
</div>


@script
    <script>
        Livewire.on('print-depot', ({ url }) => {
            window.open(url, '_blank');
        });
    </script>

@endscript