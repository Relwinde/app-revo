<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouvel utilisateur</h3>
                <div class="block-options">
                    <button wire:click.prevent="create" type="submit" class="btn btn-sm btn-primary">
                        Enregistrer
                    </button>
                    <div wire:loading class=" spinner-border spinner-border-sm text-primary" role="status">
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
                                <input wire:model='name' type="text" class="form-control form-control-alt" id="name" name="name" placeholder="Nom de l'utilisateur..">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="block-form1-password">Email</label>
                                <input wire:model='email' type="email" class="form-control form-control-alt" id="email" name="email" placeholder="Email de l'utilisateur..">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="profile">Profile</label>
                                <select class="form-control" id="profile" name="profile" wire:model='profile'>
                                    <option value="">Selectionnez un rôle</option>
                                    @foreach($profiles as $profile)
                                        <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                                    @endforeach
                                </select>
                                @error('profile')
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
