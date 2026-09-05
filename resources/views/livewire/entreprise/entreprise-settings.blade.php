<div>

    @include('partials.pages.header')

    <div class="content">
        <form wire:submit.prevent="save">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Informations de l'entreprise</h3>
                    <div class="block-options">
                        @can('Modifier Entreprise')
                            <button type="submit" class="btn btn-sm btn-primary">
                                Enregistrer
                            </button>
                            <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="block-content">

                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="capital">Capital</label>
                                <input wire:model='capital' type="text" class="form-control form-control-alt"
                                    id="capital" placeholder="Capital social..">
                                @error('capital')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model='email' type="email" class="form-control form-control-alt"
                                    id="email" placeholder="Email de l'entreprise..">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <textarea wire:model='adresse' class="form-control form-control-alt" id="adresse"
                                    rows="3" placeholder="Adresse..."></textarea>
                                @error('adresse')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telephone">Téléphone</label>
                                <input wire:model='telephone' type="text" class="form-control form-control-alt"
                                    id="telephone" placeholder="Téléphone..">
                                @error('telephone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rccm">RCCM</label>
                                <input wire:model='rccm' type="text" class="form-control form-control-alt" id="rccm"
                                    placeholder="RCCM..">
                                @error('rccm')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ifu">IFU</label>
                                <input wire:model='ifu' type="text" class="form-control form-control-alt" id="ifu"
                                    placeholder="IFU..">
                                @error('ifu')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="regime_imposition">Régime d'imposition</label>
                                <input wire:model='regime_imposition' type="text"
                                    class="form-control form-control-alt" id="regime_imposition"
                                    placeholder="Régime d'imposition..">
                                @error('regime_imposition')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="division_fiscale">Division Fiscale</label>
                                <input wire:model='division_fiscale' type="text"
                                    class="form-control form-control-alt" id="division_fiscale"
                                    placeholder="Division Fiscale..">
                                @error('division_fiscale')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
