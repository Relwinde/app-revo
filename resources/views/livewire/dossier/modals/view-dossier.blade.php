<div>
    @if ($editMode)
        <form wire:submit.prevent="update">
    @endif

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Dossier N°: {{ $numero }}</h3>
                <div class="block-options">
                   
                        @if ($editMode)
                            <button wire:click.prevent="update" type="submit" class="btn btn-sm btn-primary">
                                Enregistrer
                            </button>
                        @else
                            <button wire:click.prevent="print" type="submit" class="btn btn-sm btn-primary">
                                Imprimer le manifest
                            </button>
                            <button wire:click.prevent="toggleEditMode" type="submit" class="btn btn-sm btn-primary">
                                Modifier
                            </button>
                        @endif
                    <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="reset" wire:click='$dispatch("closeModal")' class="btn btn-sm btn-alt-primary">
                        Annuler
                    </button>
                </div>
            </div>

            <div class="block-content">
                <div class="justify-content-center py-sm-3 py-md-5">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="client">Expéditeur</label>
                                <select @if (!$editMode) disabled @endif required wire:model='client_id' class="custom-select" id="client" name="client">
                                    <option value="">Sélectionnez l'expéditeur</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="destinataire">Destinataire</label>
                                <select @if (!$editMode) disabled
                                    
                                @endif required wire:model='destinataire' class="custom-select" id="destinataire" name="destinataire">
                                    <option value="">Sélectionnez le destinataire</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('destinataire')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="camion">Camion</label>
                                <select @if (!$editMode) disabled

                                @endif required wire:model='camion_id' class="custom-select" id="camion" name="camion">
                                    <option value="">Sélectionnez le camion</option>
                                    @foreach ($camions as $camion)
                                        <option value="{{ $camion->id }}">{{ $camion->license_plate }}</option>
                                    @endforeach
                                </select>
                                @error('camion_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="chauffeur">Chauffeur</label>
                                <select @if (!$editMode) disabled

                                @endif required wire:model='chauffeur_id' class="custom-select" id="chauffeur" name="chauffeur">
                                    <option value="">Sélectionnez le chauffeur</option>
                                    @foreach ($chauffeurs as $chauffeur)
                                        <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                    @endforeach
                                </select>
                                @error('chauffeur_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block-footer">
                    <div class="table-responsive">
                        <div class="justify-content-left py-sm-1 py-md-1">
                            <button wire:click="$dispatch('openModal', { component: 'dossier.modals.add-commande', arguments: { dossier: {{ $dossier }} } })" class="btn btn-sm btn-primary">Ajouter un bon de commande</button>

                        </div>


                        
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>Fournisseur</th>
                                    <th>Nature de colis</th>
                                    <th>Quantité</th>
                                    <th class="text-center" style="width: 120px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dossier->commandes as $commande)
                                    <tr>
                                        <td>{{ $commande->numero }}</td>
                                        <td>{{ $commande->fournisseur ? $commande->fournisseur->name : 'N/A' }}</td>
                                        <td>{{ $commande->marchandise ? $commande->marchandise->name : 'N/A' }}</td>
                                        <td>{{ $commande->quantite }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button wire:click="removeCommande({{ $commande->id }})" class="btn btn-sm btn-light" title="Retirer le bon de commande"><i class="fa fa-fw fa-minus"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


    @if ($editMode)
        </form>
    @endif
</div>
