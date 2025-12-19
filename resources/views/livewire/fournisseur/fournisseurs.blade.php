<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'fournisseur.modals.create-fournisseur' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un fournisseur
                    </button>
                </div>
            </div>

            <div class="block-content block-content-full">
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
                                                @if ($editMode && $fournisseurId === $fournisseur->id)
                                                    <input wire:model="name" class="form-control form-control-sm">
                                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                                @else
                                                    {{ $fournisseur->name }}
                                                @endif
                                            </td>

                                            {{-- EMAIL --}}
                                            <td>
                                                @if ($editMode && $fournisseurId === $fournisseur->id)
                                                    <input wire:model="email" type="email" class="form-control form-control-sm">
                                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                                @else
                                                    {{ $fournisseur->email ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- PHONE --}}
                                            <td>
                                                @if ($editMode && $fournisseurId === $fournisseur->id)
                                                    <input wire:model="phone" class="form-control form-control-sm">
                                                @else
                                                    {{ $fournisseur->phone ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- ADDRESS --}}
                                            <td>
                                                @if ($editMode && $fournisseurId === $fournisseur->id)
                                                    <input wire:model="address" class="form-control form-control-sm">
                                                @else
                                                    {{ $fournisseur->address ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- RCCM --}}
                                            <td>
                                                @if ($editMode && $fournisseurId === $fournisseur->id)
                                                    <input wire:model="rccm" class="form-control form-control-sm">
                                                    @error('rccm') <div class="text-danger">{{ $message }}</div> @enderror
                                                @else
                                                    {{ $fournisseur->rccm ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- IFU --}}
                                            <td>
                                                @if ($editMode && $fournisseurId === $fournisseur->id)
                                                    <input wire:model="ifu" class="form-control form-control-sm">
                                                    @error('ifu') <div class="text-danger">{{ $message }}</div> @enderror
                                                @else
                                                    {{ $fournisseur->ifu ?? '-' }}
                                                @endif
                                            </td>

                                            {{-- DATE --}}
                                            <td>{{ $fournisseur->created_at->format('d/m/Y') }}</td>

                                            {{-- ACTIONS --}}
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click.prevent="{{ $editMode && $fournisseurId === $fournisseur->id
                            ? 'update(' . $fournisseur->id . ')'
                            : 'toggleEditMode(' . $fournisseur->id . ')' }}"
                                                        class="btn btn-sm btn-light" title="Modifier">
                                                        <i
                                                            class="fa fa-fw {{ $editMode && $fournisseurId === $fournisseur->id ? 'fa-check' : 'fa-pencil-alt' }}"></i>
                                                    </button>

                                                    @if ($editMode && $fournisseurId === $fournisseur->id)
                                                        <button wire:click.prevent="toggleEditMode({{ $fournisseur->id }})"
                                                            class="btn btn-sm btn-light" title="Annuler">
                                                            <i class="fa fa-fw fa-times"></i>
                                                        </button>
                                                    @else
                                                        <a wire:click.prevent="delete({{ $fournisseur->id }})" class="btn btn-sm btn-light"
                                                            title="Supprimer" wire:confirm="Êtes-vous sûr de vouloir supprimer ce fournisseur ?">
                                                            <i class="fa fa-fw fa-trash"></i>
                                                        </a>
                                                    @endif
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