<div>
    @include('partials.pages.header')
    <div class="content">
        {{-- Tableau des dossiers --}}
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'dossier.modals.create-dossier' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un dossier
                    </button>
                </div>
            </div>

            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Expéditeur</th>
                                <th>Destinataire</th>
                                <th>Camion</th>
                                <th>Chauffeur</th>
                                <th>Date de création</th>
                                <th class="text-center" style="width: 120px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($dossiers as $dossier)
                                <tr>
                                    {{-- Numéro --}}
                                    <td>{{ $dossier->numero }}</td>

                                    {{-- Client --}}
                                    <td>{{ $dossier->client ? $dossier->client->name : 'N/A' }}</td>
                                    
                                    {{-- Destinataire --}}  
                                    <td>{{ $dossier->destinate ? $dossier->destinate->name : 'N/A' }}</td>


                                    {{-- Camion --}}
                                    <td>{{ $dossier->camion ? $dossier->camion->license_plate : 'N/A' }}</td>

                                    {{-- Chauffeur --}}
                                    <td>{{ $dossier->chauffeur ? $dossier->chauffeur->name : 'N/A' }}</td>

                                    {{-- Date de création --}}
                                    <td>{{ $dossier->created_at->format('d/m/Y H:i') }}</td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button wire:click="$dispatch('openModal', { component: 'dossier.modals.view-dossier', arguments: { dossier: {{ $dossier }} } })"
                                                class="btn btn-sm btn-light" title="Voir">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun dossier trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $dossiers->links() }}
                </div>
            </div>
        
        </div>
</div>
