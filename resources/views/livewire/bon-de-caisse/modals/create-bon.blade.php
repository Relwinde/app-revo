<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouveau Bon de caisse</h3>
                <div class="block-options">
                    <button wire:click.prevent="create" type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <div wire:loading class=" spinner-border spinner-border-sm text-primary" role="status">
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
                                <label for="name">Type de bon de caisse : </label>
                                <div class="form-check form-check-inline">
                                    <input wire:model.live="bon_item" class="form-check-input" type="radio" id="dossier" name="bon_item" value="dossier">
                                    <label class="form-check-label" for="dossier">Dossier</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input wire:model.live="bon_item" class="form-check-input" type="radio" id="camion" name="bon_item" value="camion">
                                    <label class="form-check-label" for="camion">Camion</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input wire:model.live="bon_item" class="form-check-input" type="radio" id="autre" name="bon_item" value="autre">
                                    <label class="form-check-label" for="autre">Autre</label>
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if ($bon_item)
                        <div  class="row">
                            @if ($bon_item ==="dossier")
                                <div class="col">
                                    <div class="form-group">
                                        <label for="dossier_id">Dossier</label>
                                        <select wire:model='dossier_id' class="form-control form-control-alt" id="dossier_id" name="dossier_id">
                                            <option value="">Sélectionner un dossier</option>
                                            @foreach ($dossiers as $dossier)
                                                <option value="{{ $dossier->id }}">{{ $dossier->numero }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @elseif ($bon_item ==="camion")
                                <div class="col">
                                    <div class="form-group">
                                        <label for="camion_id">Camion</label>
                                        <select wire:model='camion_id' class="form-control form-control-alt" id="camion_id" name="camion_id">
                                            <option value="">Sélectionner un camion</option>
                                            @foreach ($camions as $camion)
                                                <option value="{{ $camion->id }}">{{ $camion->license_plate }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="montant">Montant</label>
                                    <input wire:model='montant' type="number" class="form-control form-control-alt" id="montant" name="montant" placeholder="Montant du bon de caisse..">
                                    @error('montant')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Dépense engagée</label>
                                    <input wire:model='depense' type="text" class="form-control form-control-alt" id="depense" name="depense" placeholder="Dépense engagée..">
                                    @error('depense')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea wire:model='description' class="form-control form-control-alt" id="description" name="description" rows="4" placeholder="Description du bon de caisse.."></textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </form>
</div>
