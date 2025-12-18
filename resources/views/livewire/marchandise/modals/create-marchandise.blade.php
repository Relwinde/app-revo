<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouvelle Marchandise</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <div wire:loading class="spinner-border spinner-border-sm text-primary"></div>
                    <button type="reset" wire:click='$dispatch("closeModal")' class="btn btn-sm btn-alt-primary">
                        Annuler
                    </button>
                </div>
            </div>

            <div class="block-content">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Nom de la marchandise</label>
                            <input wire:model="name" type="text" class="form-control form-control-alt"
                                placeholder="Nom de la marchandise">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    
                </div>

                
            </div>
        </div>
    </form>
</div>