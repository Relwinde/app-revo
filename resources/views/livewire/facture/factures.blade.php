<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">{{ $pageHeader['subtitle'] ?? 'Liste des factures définitive' }}</h3>
                    {{-- <div class="block-options">
                        <a href="{{route('create-facture-proforma')}}" wire:navigate
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Nouvelle définitive
                        </a>
                    </div> --}}
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

                <div class="table table-bordered table-striped table-vcenter table-responsive-md">
                    <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Client</th>
                                <th>Dossier</th>
                                <th>Date</th>
                                <th>Chauffeur</th>
                                <th>Contact</th>
                                <th>Total</th>
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($factures as $facture)
                                <tr>
                                    <td>{{ $facture->reference }}</td>
                                    <td>{{ $facture->client->name }}</td>
                                    <td>{{ $facture->dossier->numero ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($facture->date)->format('d ') }}{{ __(\Carbon\Carbon::parse($facture->date)->format('n')) }} {{ \Carbon\Carbon::parse($facture->date)->format('Y') }}</td>
                                    <td>{{ $facture->chauffeur ? $facture->chauffeur->name : 'N/A' }}</td>
                                    <td>{{ $facture->personne_contact ?? 'N/A' }}</td>
                                    <td>{{ number_format($facture->items->sum(function($item) { return $item->unit_price * $item->quantity; }) ?? 0, 2, ',', ' ') }} FCFA</td>
                                    <td class="text-center">
                                         <div class="btn-group">
                                            <a href="{{route('view-facture', $facture->id)}}" wire:navigate class="btn btn-sm btn-light" data-toggle="tooltip" title="View Facture">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Remove Facture">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucune facture définitive trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $factures->links() }}

                </div>

            </div>
        </div>
    </div>
</div>
