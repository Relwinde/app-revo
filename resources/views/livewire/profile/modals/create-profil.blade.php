<div>
    <form action="" wire:submit.prevent="create">
        <div class="block-block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Créer un nouveau profil</h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-primary">
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
                <div class="form-group">
                    <label for="profile-name">Nom du profil</label>
                    <input wire:model='name' type="text" class="form-control form-control-alt" id="profile-name" name="profile-name" placeholder="Entrez le nom du profil">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>
