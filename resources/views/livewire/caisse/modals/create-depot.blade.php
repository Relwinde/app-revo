<div>
    <form wire:submit.prevent='save'>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Effectuer un dépôt</h3>

            <div class="block-options">
                <button wire:confirm="Souhaitez vous vraiment effectuer ce dépôt ? Cette action est irreversible" wire:click.prevent="save" type="submit" class="btn btn-sm btn-primary">
                    Enregistrer
                </button>
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
                            <label for="libelle">Libellé</label>
                            <input type="text" class="form-control" id="date_depot" wire:model="libelle" placeholder="Entrez le libellé du dépôt">
                            @error('libelle')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="montant">Montant du dépôt</label>
                            <input type="number" step="0.01" class="form-control" id="montant" wire:model="montant" placeholder="Entrez le montant du dépôt">
                            @error('montant')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="deposant">Déposant</label>
                            <input type="text" class="form-control" id="deposant" wire:model="deposant" placeholder="Entrez le nom du déposant">
                            @error('deposant')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="banque">Banque</label>
                            <input type="text" class="form-control" id="banque" wire:model="banque" placeholder="Entrez le nom de la banque">
                            @error('banque')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="ref_cheque">Référence du chèque</label>
                            <input type="text" class="form-control" id="ref_cheque" wire:model="ref_cheque" placeholder="Entrez la référence du chèque">
                            @error('ref_cheque')
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
