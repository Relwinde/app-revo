<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">{{ $pageHeader['subtitle'] ?? 'Liste des factures pro-forma' }}</h3>
                    <div class="block-options">
                        <a href="{{route('create-facture-proforma')}}" wire:navigate
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Nouvelle pro-forma
                    </a>
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

                <div class="table table-bordered table-striped table-vcenter table-responsive-md">
                    <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Chauffeur</th>
                                <th>Contact</th>
                                <th>Total</th>
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($factureProformas as $factureProforma)
                                <tr>
                                    <td>{{ $factureProforma->reference }}</td>
                                    <td>{{ $factureProforma->client->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($factureProforma->date)->format('d ') }}{{ __(\Carbon\Carbon::parse($factureProforma->date)->format('n')) }} {{ \Carbon\Carbon::parse($factureProforma->date)->format('Y') }}</td>
                                    <td>{{ $factureProforma->chauffeur ? $factureProforma->chauffeur->name : 'N/A' }}</td>
                                    <td>{{ $factureProforma->personne_contact ?? 'N/A' }}</td>
                                    <td>{{ number_format($factureProforma->items->sum(function($item) { return $item->unit_price * $item->quantity; }) ?? 0, 2, ',', ' ') }} FCFA</td>
                                    <td class="text-center">
                                         <div class="btn-group">
                                            <a href="{{route('view-facture-proforma', $factureProforma->id)}}" wire:navigate class="btn btn-sm btn-light" data-toggle="tooltip" title="View Proforma">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Remove Proforma">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucune facture pro-forma trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $factureProformas->links() }}

                </div>

            </div>
        </div>
    </div>
</div>
