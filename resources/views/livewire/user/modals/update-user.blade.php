<div>
    <form wire:submit.prevent="update">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Modifier l'utilisateur</h3>

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

                    <!-- Changement de mot de passe -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="changePassword"
                                    wire:model="changePassword">
                                <label class="form-check-label" for="changePassword">
                                    Modifier le mot de passe
                                </label>
                            </div>
                        </div>
                    </div>

                    @if($changePassword)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_password">Mot de passe actuel</label>
                                    <input wire:model.defer="current_password" type="password"
                                        class="form-control form-control-alt" id="current_password"
                                        placeholder="Mot de passe actuel">
                                    @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_password">Nouveau mot de passe</label>
                                    <input wire:model.defer="new_password" type="password"
                                        class="form-control form-control-alt" id="new_password"
                                        placeholder="Nouveau mot de passe">
                                    @error('new_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirmer le mot de passe</label>
                                    <input wire:model.defer="new_password_confirmation" type="password"
                                        class="form-control form-control-alt" id="new_password_confirmation"
                                        placeholder="Confirmer le mot de passe">
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </form>
</div>