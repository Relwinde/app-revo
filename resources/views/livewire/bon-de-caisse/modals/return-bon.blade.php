<div>
    <form wire:submit.prevent="stepBack">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Retour de bon</h3>
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
                            <label for="commentaire">Commentaire de retour</label>
                            <textarea name="commentaire" id="commentaire" cols="30" rows="5" wire:model="commentaire" class="form-control" placeholder="Entrez votre commentaire"></textarea>
                            @error('commentaire') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>