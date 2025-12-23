<div>
    @include('partials.pages.header')

    <div class="content">
        <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                    <div class="block-options">
                        <button wire:click="$dispatch('openModal', { component: 'commande.modals.create-commande' })"
                            class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Nouveau bon de commande
                        </button>
                    </div>
                </div>
                <!-- Quick Overview -->
                
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter table-responsive-md">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Fournisseur</th>
                                    <th>Marchandise</th>
                                    <th>Quantité</th>
                                    <th>Description</th>
                                    <th>Dossier</th>
                                    <th>Date de création</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commandes as $commande)
                                <tr>
                                    <td>{{ $commande->numero }}</td>
                                    <td>{{ $commande->fournisseur ? $commande->fournisseur->name : 'N/A' }}</td>
                                    <td>{{ $commande->marchandise->name }}</td>
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
                                    <td colspan="6" class="text-center text-muted">
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
