<div>
    <div class="block-header block-header-default">
        <h3 class="block-title">Ajouter un bon de commande au dossier : <b>{{ $dossier->numero }}</b></h3>

        <div class="block-options">
            <button type="reset" wire:click='$dispatch("closeModal")' class="btn btn-sm btn-alt-primary">
                Annuler
            </button>
        </div>
    </div>

    <div class="block-content">
        <div class="justify-content-center">
            <div class="row">
                <div class="col">
                    <div class="block">
                        <div class="block-content">
                            <table class="table table-vcenter">
                                <tbody>

                                    @foreach ($commandes as $commande)
                                        <tr>
                                            
                                            <td class="font-w600 font-size-sm">
                                                <a href="#">{{$commande->numero}}</a>
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                <a href="#">{{$commande->fournisseur}}</a>
                                            </td>
                                            <td class="font-w600 font-size-sm">
                                                <a href="#">{{$commande->marchandise->name ?? '-'}}</a>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click="addCommande({{ $commande->id }})" type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Ajouter le bon de commande au dossier">
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
