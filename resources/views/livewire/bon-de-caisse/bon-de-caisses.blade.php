<div>
    @include('partials.pages.header')

    <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
                {{-- <div class="block-options">
                    <button wire:click="$dispatch('openModal', { component: 'client.modals.create-client' })"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-hand-holding-usd"></i> Effectuer un dépôt
                    </button>
                </div> --}}
            </div>
    </div>

    <div class="content">

    </div>
</div>
