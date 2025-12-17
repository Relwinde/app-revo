<div>
    <div class="block-header block-header-default">
        <h3 class="block-title">Profile : <b>{{ $profile->name }}</b></h3>
    </div>
    <div class="block-content">
        <div class="justify-content-center">
            <div class="row">
                <div class="col">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Permissions accordées</h3>
                        </div>
                        <div class="block-content">
                            <table class="table table-vcenter">
                                <tbody>

                                    @foreach ($profile_permissions as $granted)
                                        <tr>
                                            <td class="font-w600 font-size-sm">
                                                <a href="#">{{$granted->name}}</a>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click="removePermission({{ $granted->id }})" type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit Client">
                                                        <i class="fa fa-fw fa-minus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Permissons non accordées</h3>
                        </div>
                        <div class="block-content">
                            <table class="table table-vcenter">
                                <tbody>

                                    @foreach ($ungiven_permissions as $ungiven)
                                        <tr>
                                            <td class="font-w600 font-size-sm">
                                                <a class="text-danger" href="#">{{$ungiven->name}}</a>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click="addPermission({{ $ungiven->id }})" type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit Client">
                                                        <i class="fa fa-fw fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
