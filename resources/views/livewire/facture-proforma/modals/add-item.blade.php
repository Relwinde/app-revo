<div>
    <form wire:submit.prevent='addItem'>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Ajouter une nouvelle ligne</h3>
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
                <div class="justfy-content-center py-sm-3 pys-md-5">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="description">Désignation</label>
                                <input type="text" wire:model='description' class="form-control form-control" id="description" name="description">
                                @error("description")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="unit">Unité</label>
                                <input type="text" wire:model='unit' class="form-control form-control" id="unit" name="unit">
                                @error("unit")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="unit_price">Prix unitaire</label>
                                <input type="number" wire:model='unit_price' class="form-control form-control" id="unit_price" name="unit_price">
                                @error("unit_price")
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="quantity">Quantité</label>
                                <input type="number" name="quantity" id="quantity" class="form-control form-control" id="quantity" wire:model='quantity'>
                                @error("quantity")
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
