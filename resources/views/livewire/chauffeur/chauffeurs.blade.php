<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] ?? 'Liste des chauffeurs' }}</h3>
                <div class="block-options">
                    @can('Créer Chauffeur')
                        <button wire:click="$dispatch('openModal', { component: 'chauffeur.modals.create-chauffeur' })"
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Ajouter un chauffeur
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
                            <th>Ref Identité</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Date</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($chauffeurs as $chauffeur)
                                        <tr>
                                            {{-- Nom --}}
                                            <td>
                                                @if ($editMode && $chauffeurId === $chauffeur->id)
                                                    <input wire:model="name" class="form-control form-control-sm"
                                                        placeholder="Nom du chauffeur">
                                                    @error('name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    {{ $chauffeur->name }}
                                                @endif
                                            </td>

                                            {{-- Email --}}
                                            <td>
                                                @if ($editMode && $chauffeurId === $chauffeur->id)
                                                    <input wire:model="ref_identite" class="form-control form-control-sm" placeholder="Référence d'identité">
                                                    @error('ref_identite')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    {{ $chauffeur->ref_identite ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- Téléphone --}}
                                            <td>
                                                @if ($editMode && $chauffeurId === $chauffeur->id)
                                                    <input wire:model="phone" class="form-control form-control-sm" placeholder="Téléphone">
                                                @else
                                                    {{ $chauffeur->phone ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- Adresse --}}
                                            <td>
                                                @if ($editMode && $chauffeurId === $chauffeur->id)
                                                    <input wire:model="address" class="form-control form-control-sm" placeholder="Adresse">
                                                @else
                                                    {{ $chauffeur->address ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- Date --}}
                                            <td>{{ $chauffeur->created_at->format('d/m/Y') }}</td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    @can('Modifier Chauffeur')
                                                        <button wire:click.prevent="{{ $editMode && $chauffeurId === $chauffeur->id
                            ? 'update(' . $chauffeur->id . ')'
                            : 'toggleEditMode(' . $chauffeur->id . ')' }}" class="btn btn-sm btn-light"
                                                            title="Modifier">

                                                            <i
                                                                class="fa fa-fw {{ $editMode && $chauffeurId === $chauffeur->id ? 'fa-check' : 'fa-pencil-alt' }}"></i>
                                                        </button>
                                                    @endcan

                                                    @if ($editMode && $chauffeurId === $chauffeur->id)
                                                        <button wire:click.prevent="toggleEditMode({{ $chauffeur->id }})"
                                                            class="btn btn-sm btn-light" title="Annuler">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    @else
                                                        @can('Supprimer Chauffeur')
                                                            <a wire:confirm="Êtes-vous sûr de vouloir supprimer ce chauffeur ?" wire:click.prevent="delete({{ $chauffeur->id }})" class="btn btn-sm btn-light"
                                                                title="Supprimer">
                                                                <i class="fa fa-fw fa-trash"></i>
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Aucun chauffeur enregistré
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $chauffeurs->links() }}
                </div>
            </div>
        </div>
    </div>
    
</div>