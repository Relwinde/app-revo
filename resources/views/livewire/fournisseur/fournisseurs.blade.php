<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'fournisseur.modals.create-fournisseur' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un prestataire
                    </button>
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
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>RCCM</th>
                            <th>IFU</th>
                            <th>Date</th>
                            <th class="text-center" style="width: 110px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($fournisseurs as $fournisseur)
                                        <tr>
                                            {{-- NOM --}}
                                            <td>
                                                {{ $fournisseur->name }}
                                            </td>

                                            {{-- EMAIL --}}
                                            <td>
                                                {{ $fournisseur->email ?? '-' }}
                                            </td>

                                            {{-- PHONE --}}
                                            <td>
                                                {{ $fournisseur->phone ?? '-' }}
                                            </td>

                                            {{-- ADDRESS --}}
                                            <td>
                                                {{ $fournisseur->address ?? '-' }}
                                            </td>

                                            {{-- RCCM --}}
                                            <td>
                                                {{ $fournisseur->rccm ?? '-' }}
                                            </td>

                                            {{-- IFU --}}
                                            <td>
                                                {{ $fournisseur->ifu ?? '-' }}
                                            </td>

                                            {{-- DATE --}}
                                            <td>{{ $fournisseur->created_at->format('d/m/Y') }}</td>

                                            {{-- ACTIONS --}}
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click="$dispatch('openModal', { component: 'fournisseur.modals.edit-fournisseur', arguments: { fournisseur: {{ $fournisseur }} } })"
                                                        class="btn btn-sm btn-light" title="Modifier">
                                                        <i
                                                            class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                    <a wire:click.prevent="delete({{ $fournisseur->id }})" class="btn btn-sm btn-light"
                                                        title="Supprimer" wire:confirm="Êtes-vous sûr de vouloir supprimer ce fournisseur ?">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Aucun fournisseur enregistré
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $fournisseurs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>