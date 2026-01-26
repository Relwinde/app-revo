<div>
    <form wire:submit.prevent="save">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="block-title">Création d'un ajustement</div>
                <div class="block-options">
                    <button wire:confirm="Êtes-vous sûr de vouloir enregistrer cet ajustement ?" type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <div wire:loading class="spinner-border spinner-border-sm text-primary"></div>
                    <button type="reset" wire:click='$dispatch("closeModal")' class="btn btn-sm btn-alt-primary">
                        Annuler
                    </button>
                </div>
            </div>

            <div class="block-header block-header-default">
                <div class="block-title">
                    <h5>Montant actuel: {{number_format($bon->montant_definitif, 2, '.', ' ')}} CFA</h5>
                    <h5>Montant après ajustement: {{number_format($montantAfter, 2, '.', ' ')}} CFA</h5>
                </div>
            </div>

            <div class="block-content">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="d-block">Type d'ajustement</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input required wire:model.live='type' type="radio" class="custom-control-input" id="example-rd-custom-inline1" name="example-rd-custom-inline" value="1">
                                <label class="custom-control-label" for="example-rd-custom-inline1">Excédant</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input required wire:model.live='type' type="radio" class="custom-control-input" id="example-rd-custom-inline2" name="example-rd-custom-inline" value="2">
                                <label class="custom-control-label" for="example-rd-custom-inline2">Restitution</label>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="montant">Montant de l'ajustement</label>
                            <input type="number" class="form-control" id="montant" wire:model.live="montant" placeholder="Entrez le montant de l'ajustement">
                            @error('montant') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="libelle">Motif de l'ajustement</label>
                            <input required type="text" wire:model="libelle" class="form-control" placeholder="Entrez le motif de l'ajustement">
                            @error('libelle') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </form>
</div>
