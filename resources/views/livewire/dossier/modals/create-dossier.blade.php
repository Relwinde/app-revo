<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Créer une nouvelle opération</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="button" wire:click='$dispatch("closeModal")' class="btn btn-sm btn-alt-primary">
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
                                <select class="custom-select" required wire:model='type_operation' name="type_operation" id="">
                                    <option value="">Selectionnez le type d'opération</option>
                                    <option value="MA">Manutention</option>
                                    <option value="AV">Location</option>
                                    <option value="AA">Transport</option>
                                </select>
                                @error('type_operation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="client">Expéditeur</label>
                                <select required wire:model='client_id' class="custom-select" id="client" name="client">
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
                                <select required wire:model='destinataire' class="custom-select" id="destinataire" name="destinataire">
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
                                <select required wire:model='camion_id' class="custom-select" id="camion" name="camion">
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
                                <select required wire:model='chauffeur_id' class="custom-select" id="chauffeur" name="chauffeur">
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

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="compagnon">Accompagnant</label>
                                <input placeholder="Accompagnant" type="text" class="form-control form-control" wire:model="compagnon">
                                @error("compagnon")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="lieu">Lieu de la mission</label>
                                <input type="text" class="form-control form-control" placeholder="Lieu de la mission" wire:model="lieu">
                                @error("lieu")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date_depart">Date de départ</label>
                                <input placeholder="Date de départ" type="date" class="form-control form-control" wire:model="date_depart">
                                @error('date_depart')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="date_retour">Date de retour</label>
                                <input placeholder="Date de retour" type="date" class="form-control form-control" wire:model="date_retour">
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
                                <input class="form-control form-control" placeholder="Motif de la mission" wire:model="motif">
                                @error("motif")
                                        <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="escort">Escorte à organiser</label>
                                <input placeholder="Escorte à organiser" type="text" class="form-control form-control" wire:model="escort">
                                @error("escort")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
            