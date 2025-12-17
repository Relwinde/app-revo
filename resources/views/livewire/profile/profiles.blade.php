<div>  
    @include('partials.pages.header')

    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">{{ $pageHeader['subtitle'] }}</h3>
            <div class="block-options">
                @can('Ajouter Profil')
                    <button wire:click="$dispatch('openModal', { component: 'profile.modals.create-profil' })" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus"></i> Ajouter un profil
                    </button>
                @endcan
            </div>
        </div>


        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-responsive-md">
                <thead>
                    <tr>
                        <th>Nom du profil</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profils as $profile)
                    <tr wire:key="profile-{{ $profile->id }}">
                        <td class="font-w600 font-size-sm">
                            {{ $profile->name }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                @can('Voir Profil')
                                    <button wire:click="$dispatch('openModal', {component: 'profile.modals.view-profil', arguments: { profile : {{ $profile->id }} }})" class="btn btn-sm btn-alt-secondary" type="button" data-toggle="tooltip" title="Voir">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucun profil trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div>
                {{ $profils->links() }}
            </div>
        </div>
    </div>

</div>