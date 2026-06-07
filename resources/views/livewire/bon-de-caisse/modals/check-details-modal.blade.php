<div>
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Détails du chèque</h3>
            <div class="block-options">
                <button type="reset" wire:click='annuler' class="btn btn-sm btn-alt-primary">
                    Annuler
                </button>
            </div>
        </div>

        <div class="block-content">
            <form wire:submit.prevent="confirmerPaiement">
                <div class="form-group">
                    <label for="numeroChecque">Numéro de chèque <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control @error('numeroChecque') is-invalid @enderror"
                        id="numeroChecque"
                        placeholder="Entrez le numéro du chèque"
                        wire:model="numeroChecque"
                    >
                    @error('numeroChecque')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="banqueChecque">Banque <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control @error('banqueChecque') is-invalid @enderror"
                        id="banqueChecque"
                        placeholder="Entrez le nom de la banque"
                        wire:model="banqueChecque"
                    >
                    @error('banqueChecque')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dateChecque">Date du chèque <span class="text-danger">*</span></label>
                    <input
                        type="date"
                        class="form-control @error('dateChecque') is-invalid @enderror"
                        id="dateChecque"
                        wire:model="dateChecque"
                    >
                    @error('dateChecque')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Confirmer paiement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
