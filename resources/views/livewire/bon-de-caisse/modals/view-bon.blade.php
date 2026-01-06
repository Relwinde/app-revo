<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Bon de caisse N° {{ $bon->numero }}</h3>
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
                    <div  class="row">
                        @if ($bon->dossier_id)
                            <div class="col">
                                <div class="form-group">
                                    <label for="dossier_id">Dossier</label>
                                    <select @if (!$editMode) disabled @endif wire:model='dossier_id' class="form-control form-control-alt" id="dossier_id" name="dossier_id">
                                        <option value="">Sélectionner un dossier</option>
                                        @foreach ($dossiers as $dossier)
                                            <option value="{{ $dossier->id }}">{{ $dossier->numero }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif ($bon->camion_id)
                            <div class="col">
                                <div class="form-group">
                                    <label for="camion_id">Camion</label>
                                    <select @if (!$editMode) disabled @endif wire:model='camion_id' class="form-control form-control-alt" id="camion_id" name="camion_id">
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
                                <input @if (!$editMode) disabled @endif wire:model='montant' type="number" class="form-control form-control-alt" id="montant" name="montant" placeholder="Montant du bon de caisse..">
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
                                <input @if (!$editMode) @endif disabled  wire:model='depense' type="text" class="form-control form-control-alt" id="depense" name="depense" placeholder="Dépense engagée..">
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
                                <textarea @if (!$editMode) disabled @endif wire:model='description' class="form-control form-control-alt" id="description" name="description" rows="4" placeholder="Description du bon de caisse.."></textarea>
                                @error('description')
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

