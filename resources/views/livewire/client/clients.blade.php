<div>
    
    @include('partials.pages.header')

    {{-- Tableau des clients --}}
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
            <div class="block-options">
                <button wire:click="$dispatch('openModal', { component: 'client.modals.create-client' })"
                    class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Ajouter un client
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
                                @if ($editMode && $clientId === $client->id)
                                    <input wire:model="name" type="text" class="form-control form-control-alt" />
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                @else
                                    {{ $client->name }}
                                @endif
                            </td>

                            {{-- EMAIL --}}
                            <td>
                                @if ($editMode && $clientId === $client->id)
                                    <input wire:model="email" type="email" class="form-control form-control-alt" />
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                @else
                                    {{ $client->email ?? '-' }}
                                @endif
                            </td>

                            {{-- TELEPHONE --}}
                            <td>
                                @if ($editMode && $clientId === $client->id)
                                    <input wire:model="phone" type="text" class="form-control form-control-alt" />
                                @else
                                    {{ $client->phone ?? '-' }}
                                @endif
                            </td>

                            {{-- ADRESSE  --}}

                            <td>
                                @if ($editMode && $clientId === $client->id)
                                    <input wire:model="address" type="text" class="form-control form-control-alt" />
                                @else
                                    {{ $client->address ?? '-' }}
                                @endif
                            </td>

                            {{-- RCCM --}}
                            <td>
                                @if ($editMode && $clientId === $client->id)
                                    <input wire:model="rccm" type="text" class="form-control form-control-alt" />
                                    @error('rccm') <div class="text-danger">{{ $message }}</div> @enderror
                                @else
                                    {{ $client->rccm ?? '-' }}
                                @endif
                            </td>

                            {{-- IFU --}}
                            <td>
                                @if ($editMode && $clientId === $client->id)
                                    <input wire:model="ifu" type="text" class="form-control form-control-alt" />
                                    @error('ifu') <div class="text-danger">{{ $message }}</div> @enderror
                                @else
                                    {{ $client->ifu ?? '-' }}
                                @endif
                            </td>

                            {{-- DATE --}}
                            <td>{{ $client->created_at->format('d/m/Y') }}</td>

                            {{-- ACTIONS --}}
                            <td class="text-center">
                                <div class="btn-group">
                                    <button @if ($editMode && $clientId === $client->id)
                                    wire:click.prevent="update({{ $client->id }})" @else
                                        wire:click.prevent="toggleEditMode({{ $client->id }})" @endif type="button"
                                        class="btn btn-sm btn-light" title="Modifier">
                                        @if ($editMode && $clientId === $client->id)
                                            <i class="fa fa-fw fa-check"></i>
                                        @else
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        @endif
                                    </button>

                                    @if ($editMode && $clientId === $client->id)
                                        <button wire:click.prevent="toggleEditMode({{ $client->id }})" type="button"
                                            class="btn btn-sm btn-light" title="Annuler">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    @else
                                        <a wire:click.prevent="delete({{ $client->id }})"
                                            wire:confirm="Êtes-vous sûr de vouloir supprimer ce client ?" type="button"
                                            class="btn btn-sm btn-light" title="Supprimer">
                                            <i class="fa fa-fw fa-times"></i>
                                        </a>
                                    @endif
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