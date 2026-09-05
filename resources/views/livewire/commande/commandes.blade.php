<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                    <div class="block-options">
                        @can('Créer Commande')
                            <button wire:click="$dispatch('openModal', { component: 'commande.modals.create-commande' })"
                                class="btn btn-sm btn-primary">
                                <i class="fa fa-plus"></i> Nouveau PO
                            </button>
                        @endcan
                    </div>
                </div>
                <!-- Quick Overview -->
                
                <div class="block-content block-content-full">
                    <div class="table-responsive">
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
                        <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Fournisseur</th>
                                    <th>Marchandise</th>
                                    <th>Quantité</th>
                                    <th>Emballage</th>
                                    <th>Dossier</th>
                                    <th>Date de création</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->numero }}</td>
                                    <td>{{ $commande->fournisseur}}</td>
                                    <td>{{ $commande->marchandise }}</td>
                                    <td>{{ $commande->quantite }}</td>
                                    <td>{{ $commande->description }}</td>
                                    <td>{{ $commande->dossier ? $commande->dossier->numero : 'N/A' }}</td>
                                    <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button wire:click="$dispatch('openModal', { component: 'commande.modals.view-commande', 
                                                arguments: { commande: {{ $commande }} } })" class="btn btn-sm btn-light" title="Voir">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Aucune commande trouvée.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $commandes->links() }}
                    </div>
                </div>
        </div>

    </div>
</div>
