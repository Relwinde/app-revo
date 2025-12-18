<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouveau Camion</h3>
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
                            <label>Immatriculation</label>
                            <input wire:model="license_plate" type="text" class="form-control form-control-alt"
                                placeholder="Immatriculation">
                            @error('license_plate') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Capacité</label>
                            <input wire:model="capacity" type="number" class="form-control form-control-alt"
                                placeholder="Capacité">
                            @error('capacity') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Marque</label>
                            <input wire:model="brand" type="text" class="form-control form-control-alt"
                                placeholder="Marque">
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label>Modèle</label>
                            <input wire:model="model" type="text" class="form-control form-control-alt"
                                placeholder="Modèle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>