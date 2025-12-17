<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouvel utilisateur</h3>

                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary">
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
                        <!-- Nom -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input wire:model.defer="name" type="text" class="form-control form-control-alt"
                                    id="name" placeholder="Nom de l'utilisateur">

                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model.defer="email" type="email" class="form-control form-control-alt"
                                    id="email" placeholder="Email de l'utilisateur">

                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Mot de passe -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input wire:model.defer="password" type="password" class="form-control form-control-alt"
                                    id="password" placeholder="Mot de passe">

                                @error('password')
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