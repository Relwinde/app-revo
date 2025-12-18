<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouveau Fournisseur</h3>
                <div class="block-options">
                    <button wire:click.prevent="create" type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
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
                                <label for="name">Nom</label>
                                <input wire:model="name" type="text" class="form-control form-control-alt" id="name"
                                    placeholder="Nom du fournisseur..">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model="email" type="email" class="form-control form-control-alt" id="email"
                                    placeholder="Email du fournisseur..">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="phone">Téléphone</label>
                                <input wire:model="phone" type="text" class="form-control form-control-alt" id="phone"
                                    placeholder="Téléphone..">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="address">Adresse</label>
                                <input wire:model="address" type="text" class="form-control form-control-alt"
                                    id="address" placeholder="Adresse..">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="rccm">RCCM</label>
                                <input wire:model="rccm" type="text" class="form-control form-control-alt" id="rccm"
                                    placeholder="RCCM..">
                                @error('rccm')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="ifu">IFU</label>
                                <input wire:model="ifu" type="text" class="form-control form-control-alt" id="ifu"
                                    placeholder="IFU..">
                                @error('ifu')
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