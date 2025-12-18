<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Nouveau Chauffeur</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <button type="reset" wire:click="$dispatch('closeModal')" class="btn btn-sm btn-alt-primary">
                        Annuler
                    </button>
                </div>
            </div>

            <div class="block-content">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input id="name" type="text" wire:model="name" class="form-control form-control-alt"
                                placeholder="Nom du chauffeur...">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" wire:model="email" class="form-control form-control-alt"
                                placeholder="Email du chauffeur...">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input id="phone" type="text" wire:model="phone" class="form-control form-control-alt"
                                placeholder="Téléphone...">
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-group">
                            <label for="address">Adresse</label>
                            <input id="address" type="text" wire:model="address" class="form-control form-control-alt"
                                placeholder="Adresse...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>