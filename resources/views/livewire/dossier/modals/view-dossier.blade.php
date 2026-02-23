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
                            <button wire:click.prevent="printOrdreMission" type="submit" class="btn btn-sm btn-primary">
                                Ordre de mission
                            </button>
                            <button wire:click.prevent="printManifest" type="submit" class="btn btn-sm btn-primary">
                                Manifeste
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
                                <label for="type_operation">Type d'opération</label>
                                <select @if (!$editMode) disabled @endif class="custom-select" required wire:model='type_operation' name="type_operation" id="">
                                    <option value="">Selectionnez le type d'opération</option>
                                    <option value="MA">Transport</option>
                                    <option value="CO">Collecte</option>
                                    <option value="LOC">Location</option>
                                </select>
                                @error('type_operation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="avec_location">Avec location</label>
                                <div class="custom-control custom-switch mb-1">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom1" name="example-sw-custom1" wire:model.live="avec_location" @if (!$editMode) disabled @endif>
                                    <label class="custom-control-label" for="example-sw-custom1">Avec location</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($avec_location)

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="prix_location">Prix de location</label>
                                <input @if (!$editMode) disabled @endif type="number" step="0.01" wire:model='prix_location' class="form-control" id="prix_location" placeholder="Prix de location">
                                @error('prix_location')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="fournisseur">Fournisseur</label>
                                <select @if (!$editMode) disabled @endif required wire:model='fournisseur_id' class="custom-select" id="fournisseur" name="fournisseur">
                                    <option value="">Sélectionnez le fournisseur</option>
                                    @foreach ($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->name }}</option>
                                    @endforeach
                                </select>
                                @error('fournisseur_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div> 
                    @endif

                    <hr>
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

                    <hr>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="compagnon">Accompagnant</label>
                                <input @if (!$editMode) disabled @endif type="text" wire:model='compagnon' class="form-control" id="compagnon" placeholder="Nom de l'accompagnant">
                                @error('compagnon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="lieu">Lieu de la mission</label>
                                <input @if (!$editMode) disabled @endif type="text" wire:model='lieu' class="form-control" id="lieu" placeholder="Lieu de la mission">
                                @error('lieu')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date_depart">Date de départ</label>
                                <input @if (!$editMode) disabled @endif type="date" wire:model='date_depart' class="form-control" id="date_depart" placeholder="Date de départ">
                                @error('date_depart')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col">
                            <div class="form-group">
                                <label for="date_retour">Date de retour</label>
                                <input @if (!$editMode) disabled @endif type="date" wire:model='date_retour' class="form-control" id="date_retour" placeholder="Date de retour">
                                @error('date_retour')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="motif">Motif de la mission</label>
                                <input @if (!$editMode) disabled @endif type="text" wire:model='motif' class="form-control" id="motif" placeholder="Motif de la mission">
                                @error('motif')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">

                            <div class="form-group">
                                <div class="custom-control custom-switch mb-1">
                                    <input @if (!$editMode) disabled @endif type="checkbox" class="custom-control-input" id="example-sw-custom2" name="example-sw-custom2" wire:model.live="avec_escort">
                                    <label class="custom-control-label" for="example-sw-custom2">Avec Escorte</label>
                                </div>
                            </div>

                            @if ($avec_escort)
                                <div class="form-group">
                                    <label for="escort">Escorte à organiser</label>
                                    <input @if (!$editMode) disabled @endif type="text" wire:model='escort' class="form-control" id="escort" placeholder="Escorte à organiser">
                                    @error('escort')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="facture_proforma_id">Facture Pro-Forma</label>
                                <select @if (!$editMode) disabled @endif wire:model='facture_proforma_id' class="custom-select" id="facture_proforma_id" name="facture_proforma_id">
                                    <option value="">Sélectionnez une facture pro-forma</option>
                                    @foreach ($facturesProformas as $facture)
                                        <option value="{{ $facture->id }}">{{ $facture->reference }} - {{ $facture->client->name }}</option>
                                    @endforeach
                                </select>
                                @error('facture_proforma_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            
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
                                        <td>{{ $commande->fournisseur ? $commande->fournisseur : 'N/A' }}</td>
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

@script

    <script>
        $wire.on('print-ordre-mission', () => {
            (function () {
                window.open("{{route('print-ordre-mission', $dossier->id)}}", "_blank");
            }).call(this);
        });

        $wire.on('print-manifest', () => {
            (function () {
                window.open("{{route('print-manifest', $dossier->id)}}", "_blank");
            }).call(this);
        });

    </script>


@endscript
