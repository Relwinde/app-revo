<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'camion.modals.create-camion' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un camion
                    </button>
                </div>
            </div>

            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                    <thead>
                        <tr>
                            <th>Immatriculation</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Capacité</th>
                            <th>Date</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($camions as $camion)
                                        <tr>
                                            {{-- Immatriculation --}}
                                            <td>
                                                @if ($editMode && $camionId === $camion->id)
                                                    <input wire:model="license_plate" class="form-control form-control-sm">
                                                    @error('license_plate')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    {{ $camion->license_plate }}
                                                @endif
                                            </td>

                                            {{-- Marque --}}
                                            <td>
                                                @if ($editMode && $camionId === $camion->id)
                                                    <input wire:model="brand" class="form-control form-control-sm">
                                                @else
                                                    {{ $camion->brand ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- Modèle --}}
                                            <td>
                                                @if ($editMode && $camionId === $camion->id)
                                                    <input wire:model="model" class="form-control form-control-sm">
                                                @else
                                                    {{ $camion->model ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- Capacité --}}
                                            <td>
                                                @if ($editMode && $camionId === $camion->id)
                                                    <input wire:model="capacity" type="number" class="form-control form-control-sm">
                                                    @error('capacity')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    {{ $camion->capacity ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- Date --}}
                                            <td>{{ $camion->created_at->format('d/m/Y') }}</td>

                                            {{-- Actions --}}
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click.prevent="{{ $editMode && $camionId === $camion->id
                            ? 'update(' . $camion->id . ')'
                            : 'toggleEditMode(' . $camion->id . ')' }}" class="btn btn-sm btn-light"
                                                        title="Modifier">
                                                        <i
                                                            class="fa fa-fw {{ $editMode && $camionId === $camion->id ? 'fa-check' : 'fa-pencil-alt' }}"></i>
                                                    </button>

                                                    @if ($editMode && $camionId === $camion->id)
                                                        <button href="javascrip" wire:click.prevent="toggleEditMode({{ $camion->id }})"
                                                            class="btn btn-sm btn-light" title="Annuler">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    @else
                                                        <a wire:confirm="Êtes-vous sûr de vouloir supprimer ce camion ?" wire:click.prevent="delete({{ $camion->id }})" class="btn btn-sm btn-light"
                                                            title="Supprimer" type="button">
                                                            <i class="fa fa-fw fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Aucun camion enregistré
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $camions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>