<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                    <div class="block-options">
                        <button wire:click="$dispatch('openModal', { component: 'bon_de_caisse.modals.create-bon' })"
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Nouveau bon
                        </button>
                    </div>
                </div>

                <div class="block-content block-content-full">
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
</div>
