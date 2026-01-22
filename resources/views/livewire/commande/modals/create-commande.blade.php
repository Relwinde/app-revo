<div>
    <form wire:submit.prevent="create">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Nouveau bon de commande</h3>
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
                                <label for="numero">Numero</label>
                                <input required wire:model='numero' type="text" class="form-control form-control-alt" id="numero"
                                    placeholder="Numero du bon de commande..">
                                @error('numero')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="fournisseur">Fournisseur</label>
                                <input required wire:model='fournisseur' type="text" class="form-control form-control-alt" id="fournisseur"
                                    placeholder="Nom du fournisseur...">
                                @error('fournisseur')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="address">Nature de colis</label>
                                <select required wire:model='marchandise_id' class="custom-select" id="address" name="marchandise">
                                    <option value="0">Selextionnez la nature de colis</option>
                                    @foreach ($marchandises as $marchandise)
                                        <option value="{{ $marchandise->id }}">{{ $marchandise->name }}</option>
                                    @endforeach
                                </select>
                                @error('marchandise_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="quantite">Nombre de colis</label>
                                <input required wire:model='quantite' type="number" class="form-control form-control-alt" id="quantite"
                                    placeholder="Nombre de colis..">
                                @error('quantite')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                               <label for="example-textarea-input">Type d'emballage</label>
                                <textarea wire:model='description' class="form-control" id="example-textarea-input" name="description" rows="4" placeholder="Type d'emballage ..."></textarea>
                                @error('description')
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
