<div>

    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
        <div class="w-100">
            <!-- Sign In Section -->
            <div class="bg-white">
                <div class="content content-full">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-4 py-4">
                            <!-- Header -->
                            <div class="text-center">
                                <p class="mb-2">
                                    <i class="fa fa-2x fa-circle-notch text-primary"></i>
                                </p>
                                <h1 class="h4 mb-1">
                                    Se connecter
                                </h1>
                                @error('loginFailed')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <h2 class="h6 font-w400 text-muted mb-3">
                                    Bienvenue, veuillez vous connecter
                                </h2>
                            </div>
                            <!-- END Header -->

                            <!-- Sign In Form -->
                            <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                            <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                            <form wire:submit="login">
                                <div class="py-3">
                                    <div class="form-group">
                                        <input wire:model='email' type="text"
                                            class="form-control form-control-lg form-control-alt" name="email"
                                            placeholder="Votre email">
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="form-group">
                                        <input wire:model='password' type="password"
                                            class="form-control form-control-lg form-control-alt" name="password"
                                            placeholder="Mot de passe">
                                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="d-md-flex align-items-md-center justify-content-md-between">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="login-remember"
                                                    name="login-remember">
                                                <label class="custom-control-label font-w400" for="login-remember">Se
                                                    rappeler de moi</label>
                                            </div>
                                            <div class="py-2">
                                                <a class="font-size-sm font-w500" href="op_auth_reminder2.html">Mot de
                                                    passe oublié?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row flex justify-content-center m-0">
                                    <div wire:loading class=" spinner-border text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div class="form-group row flex justify-content-center mb-0">
                                    <div class="col-md-6 col-xl-5">
                                        <button wire:click.prevent="login" type="submit"
                                            class="btn btn-block btn-primary">
                                            <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Se connecter
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- END Sign In Form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Sign In Section -->

            <!-- Footer -->
            <div class="font-size-sm text-center text-muted py-3">
                <strong>Clinique Naila 1.0</strong> &copy; <span data-toggle="year-copy"></span>
            </div>
            <!-- END Footer -->
        </div>
    </div>

</div>