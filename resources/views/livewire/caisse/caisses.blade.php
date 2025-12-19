<div>
    @include('partials.pages.header')

    <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'client.modals.create-client' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-hand-holding-usd"></i> Effectuer un dépôt
                    </button>
                </div>
            </div>
    </div>
    <div class="content">
        <!-- Quick Overview -->
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h2 font-w700">32</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-piggy-bank font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Solde
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h2 font-w700">32</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-th-list font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            En attente de paiement
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h2 font-w700">32</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-hand-holding-usd font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Dépôts du jour
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="font-size-h2 font-w700">32</dt>
                        </dl>
                        <div class="item item-rounded bg-body">
                            <i class="fa fa-level-up-alt font-size-h3 text-primary"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Décaissements du jour
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Overview -->

    </div>



    {{-- Nothing in the world is as soft and yielding as water. --}}
</div>
