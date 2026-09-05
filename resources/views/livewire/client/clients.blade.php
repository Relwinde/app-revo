<div>
    
    @include('partials.pages.header')

    <div class="content">
        {{-- Tableau des clients --}}
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    @can('Créer Client')
                        <button wire:click="$dispatch('openModal', { component: 'client.modals.create-client' })"
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Ajouter un client
                        </button>
                    @endcan
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
                <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>RCCM</th>
                            <th>IFU</th>
                            <th>Date de création</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($clients as $client)
                            <tr>
                                {{-- NOM --}}
                                <td>
                                    {{ $client->name }}
                                </td>

                                {{-- EMAIL --}}
                                <td>
                                    {{ $client->email ?? '-' }}
                                </td>

                                {{-- TELEPHONE --}}
                                <td>
                                    {{ $client->phone ?? '-' }}
                                </td>

                                {{-- ADRESSE  --}}

                                <td>
                                    {{ $client->address ?? '-' }}
                                </td>

                                {{-- RCCM --}}
                                <td>
                                    {{ $client->rccm ?? '-' }}
                                </td>

                                {{-- IFU --}}
                                <td>
                                    {{ $client->ifu ?? '-' }}
                                </td>

                                {{-- DATE --}}
                                <td>{{ $client->created_at->format('d/m/Y') }}</td>

                                {{-- ACTIONS --}}
                                <td class="text-center">
                                    <div class="btn-group">
                                        @can('Modifier Client')
                                            <button wire:click="$dispatch('openModal', { component: 'client.modals.edit-client', arguments: { client: {{ $client }} } })" type="button" class="btn btn-sm btn-light" title="Modifier">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                        @endcan
                                        @can('Supprimer Client')
                                            <a wire:click.prevent="delete({{ $client->id }})"
                                                wire:confirm="Êtes-vous sûr de vouloir supprimer ce client ?" type="button"
                                                class="btn btn-sm btn-light" title="Supprimer">
                                                <i class="fa fa-fw fa-trash"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Aucun client enregistré
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div>
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>