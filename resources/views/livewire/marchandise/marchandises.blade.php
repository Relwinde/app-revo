<div>
    @include('partials.pages.header')

    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
            <div class="block-options">
                <button wire:click="$dispatch('openModal', { component: 'marchandise.modals.create-marchandise' })"
                    class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Ajouter une marchandise
                </button>
            </div>
        </div>

        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date</th>
                        <th class="text-center" style="width: 120px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($marchandises as $marchandise)
                                    <tr>
                                        {{-- Nom --}}
                                        <td>
                                            @if ($editMode && $marchandiseId === $marchandise->id)
                                                <input wire:model="name" class="form-control form-control-sm">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @else
                                                {{ $marchandise->name }}
                                            @endif
                                        </td>



                                        {{-- Date --}}
                                        <td>{{ $marchandise->created_at->format('d/m/Y') }}</td>

                                        {{-- Actions --}}
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button wire:click.prevent="{{ $editMode && $marchandiseId === $marchandise->id
                        ? 'update(' . $marchandise->id . ')'
                        : 'toggleEditMode(' . $marchandise->id . ')' }}" class="btn btn-sm btn-light" title="Modifier">
                                                    <i
                                                        class="fa fa-fw {{ $editMode && $marchandiseId === $marchandise->id ? 'fa-check' : 'fa-pencil-alt' }}"></i>
                                                </button>

                                                @if ($editMode && $marchandiseId === $marchandise->id)
                                                    <button wire:click.prevent="toggleEditMode({{ $marchandise->id }})"
                                                        class="btn btn-sm btn-light" title="Annuler">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                @else
                                                    <button wire:confirm="Êtes-vous sûr de vouloir supprimer cette marchandise ?"
                                                        wire:click.prevent="delete({{ $marchandise->id }})" class="btn btn-sm btn-light"
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
                                Aucune marchandise enregistrée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $marchandises->links() }}
            </div>
        </div>
    </div>
</div>