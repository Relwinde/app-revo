<div>
    @include('partials.pages.header')

    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">{{ $pageHeader['subtitle'] ?? 'Liste des chauffeurs' }}</h3>
            <div class="block-options">
                <button wire:click="$dispatch('openModal', { component: 'chauffeur.modals.create-chauffeur' })"
                    class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Ajouter un chauffeur
                </button>
            </div>
        </div>

        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
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
                                                <input wire:model="email" class="form-control form-control-sm" placeholder="Email">
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @else
                                                {{ $chauffeur->email ?? '-' }}
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
                                                <button wire:click.prevent="{{ $editMode && $chauffeurId === $chauffeur->id
                        ? 'update(' . $chauffeur->id . ')'
                        : 'toggleEditMode(' . $chauffeur->id . ')' }}" class="btn btn-sm btn-light"
                                                    title="Modifier">

                                                    <i
                                                        class="fa fa-fw {{ $editMode && $chauffeurId === $chauffeur->id ? 'fa-check' : 'fa-pencil-alt' }}"></i>
                                                </button>

                                                @if ($editMode && $chauffeurId === $chauffeur->id)
                                                    <button wire:click.prevent="toggleEditMode({{ $chauffeur->id }})"
                                                        class="btn btn-sm btn-light" title="Annuler">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                @else
                                                    <button wire:click.prevent="delete({{ $chauffeur->id }})" class="btn btn-sm btn-light"
                                                        title="Supprimer">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </button>
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