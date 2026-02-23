<div>
    @if ($editMode)
    <form wire:submit.prevent="update">   
    @endif
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Bon N° {{ $bon->numero }}</h3>
                <div class="block-options">
                    @if ($editMode)
                        <button wire:click.prevent="update" type="submit" class="btn btn-sm btn-primary">
                            Enregistrer
                        </button>
                    @elseif(!$editMode && $bon->etape == 'EMETTEUR' && Auth::user()->id == $bon->user->id)
                        <button wire:click.prevent="toggleEditMode" type="submit" class="btn btn-sm btn-primary">
                            Modifier
                        </button>
                    @endif
                    <div wire:loading class=" spinner-border spinner-border-sm text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <button type="reset" wire:click='$dispatch("closeModal")' class="btn btn-sm btn-alt-primary">
                        Annuler
                    </button>
                </div>
            </div>
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    @if ($bon->etape == 'EMETTEUR')
                        <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-primary-light text-primary">En cours de saisie</span>
                    @elseif ($bon->etape == 'MANAGER')
                        <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-warning-light text-warning">En attente de validation</span>
                    @elseif ($bon->etape == 'CAISSE')
                        <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-info-light text-info">En attente de paiement</span>
                    @elseif ($bon->etape == 'PAYE')
                        <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-success-light text-success">Payé</span>
                    @elseif ($bon->etape == 'CLOS')
                        <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-dark-light text-dark">Clos</span>
                    @elseif ($bon->etape == 'ANNULE')
                        <span class="badge badge-danger">Annulé</span>
                    @endif
                </h3>

                <div class="block-options">
                    @if (!$editMode)
                        @if ($bon->etape == "EMETTEUR" && Auth::user()->id == $bon->user->id)
                            <button wire:click.prevent="cancelBon" type="submit" class="btn btn-sm btn-warning">
                                Annuler
                            </button>
                            <button wire:confirm="Êtes-vous sûr de vouloir envoyer ce bon pour validation ?" wire:click.prevent="nextStep" type="submit" class="btn btn-sm btn-danger">
                                Envoyer pour validation
                            </button>

                        @elseif ($bon->etape == "MANAGER" && Auth::user()->can('Envoyer bon de caisse à la caisse'))
                            <button wire:confirm="Êtes-vous sûr de vouloir envoyer ce bon pour paiement ?" wire:click.prevent="nextStep" type="submit" class="btn btn-sm btn-danger">
                                Envoyer pour paiement
                            </button>

                        @elseif ($bon->etape == "CAISSE" && Auth::user()->can('Payer bon de caisse'))
                            <form>
                                <div class="form-group">
                                    {{-- <label class="d-block">Mode de paiement</label> --}}
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="type_paiement" wire:model="type_paiement" value="ESPECE">

                                        <label class="custom-control-label" for="type_paiement">Espèce</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="type_paiement2" wire:model="type_paiement" value="CHEQUE">
                                        <label class="custom-control-label" for="type_paiement2">Chèque</label>
                                    </div>
                                    
                                    <button wire:confirm="Êtes-vous sûr de vouloir payer ce bon ? Cette action est irreversible." wire:click.prevent="nextStep" type="button" class="btn btn-sm btn-danger">
                                    Payer
                                    </button>
                                    
                                    @error('type_paiement')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </form>

                        @elseif ($bon->etape == "PAYE" && Auth::user()->can('Clore bon de caisse'))
                            <button wire:confirm="Êtes-vous sûr de vouloir clore ce bon" wire:click.prevent="nextStep" type="button" class="btn btn-sm btn-danger">
                                Clore le bon
                            </button>

                        @endif

                        @if ($bon->etape == "PAYE" && Auth::user()->can('Faire un ajustement sur bon de caisse'))
                            <button wire:click="$dispatch('openModal', {component: 'bon-de-caisse.modals.create-ajustement', arguments: { bon : {{ $bon->id }} }})" type="button" class="btn btn-sm btn-danger">
                                Ajustement
                            </button>

                        @endif

                        @if ($bon->etape == "PAYE" || $bon->etape == "CLOS" && Auth::user()->can('Imprimer reçu bon de caisse'))
                            <button wire:click.prevent="printRecu" type="button" class="btn btn-sm btn-primary">
                                Imprimer reçu
                            </button>
                        @endif
                        
                    @endif


                    
                </div>
            </div>
            @if ($bon->commentaires->count() > 0)
                <div class="block-header block-header-default">
                    <div class="block-title">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input  wire:model.live="comments" type="checkbox" class="custom-control-input" id="example-cb-custom-inline1" name="example-cb-custom-inline1">
                                <label class="custom-control-label" for="example-cb-custom-inline1">Commentaires</label>
                            </div>
                        </div>

                        @if ($comments)
                            <div class="block-content font-size-sm">
                                @foreach ($bon->commentaires as $comment)
                                    <div class="push">
                                        <a class="font-w600" href="be_pages_generic_profile.html">{{ $comment->user->name }}</a>; <a href="be_pages_blog_story.html">{{ $comment->created_at->format('d M Y H:i') }}</a>
                                        <p class="mt-1">
                                            {{ $comment->content }}
                                        </p>
                                    </div> 
                                @endforeach
                            </div> 
                        @endif

                    </div>
                   
                </div>
            @endif

            <div class="block-content">
                <div class="justify-content-center py-sm-3 py-md-5">
                    <div  class="row">
                        @if ($bon->dossier_id)
                            <div class="col">
                                <div class="form-group">
                                    <label for="dossier_id">Dossier</label>
                                    <select @if (!$editMode) disabled @endif wire:model='dossier_id' class="form-control form-control-alt" id="dossier_id" name="dossier_id">
                                        <option value="">Sélectionner un dossier</option>
                                        @foreach ($dossiers as $dossier)
                                            <option value="{{ $dossier->id }}">{{ $dossier->numero }}</option>
                                        @endforeach
                                    </select>
                                    @error('dossier_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @elseif ($bon->camion_id)
                            <div class="col">
                                <div class="form-group">
                                    <label for="camion_id">Camion</label>
                                    <select @if (!$editMode) disabled @endif wire:model='camion_id' class="form-control form-control-alt" id="camion_id" name="camion_id">
                                        <option value="">Sélectionner un camion</option>
                                        @foreach ($camions as $camion)
                                            <option value="{{ $camion->id }}">{{ $camion->license_plate }}</option>
                                        @endforeach
                                    </select>
                                    @error('camion_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="montant">Montant</label>
                                <input @if (!$editMode) disabled @endif wire:model='montant' type="number" class="form-control form-control-alt" id="montant" name="montant" placeholder="Montant du bon de caisse..">
                                @error('montant')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Dépense engagée</label>
                                <input @if (!$editMode) disabled  @endif  wire:model='depense' type="text" class="form-control form-control-alt" id="depense" name="depense" placeholder="Dépense engagée..">
                                @error('depense')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea @if (!$editMode) disabled @endif wire:model='description' class="form-control form-control-alt" id="description" name="description" rows="4" placeholder="Description du bon de caisse.."></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="block-header block-header-default">
                @if ($bon->etape != "EMETTEUR" && $bon->etape != "PAYE" && $bon->etape != "CLOS")
                    <div class="block-title">
                        <button class="btn btn-danger" wire:click="$dispatch('openModal', {component: 'bon-de-caisse.modals.return-bon', arguments: { bon : {{ $bon->id }} }})" wire:confirm="Êtes-vous sûr de vouloir retourner ce bon ?">Retourner le bon</button>
                    </div>    
                @endif

                @if (($bon->etape == "CLOS" || $bon->etape == "PAYE") && ($bon->documents->count() == 0 && Auth::user()->id == $bon->user->id) )
                    <div class="block-title">
                        <button class="btn btn-primary" wire:click="$dispatch('openModal', {component: 'bon-de-caisse.modals.upload-documents', arguments: { bon : {{ $bon->id }} }})">Joindre un document</button>
                    </div>
                    
                @endif

                @if ($bon->etape == "CLOS" || $bon->etape == "PAYE" && $bon->documents->count() > 0)
                    <div class="block-title">
                        <h3 class="block-title">
                            Documents joints ({{ $bon->documents->count() }})
                        </h3>
                        <table class="table table-borderless table-hover table-vcenter">
                            <tbody>

                                @foreach ($bon->documents as $document)
                                <tr>
                                    <td>
                                        <a class="h5" href="{{ route('download-document', $document) }}">{{$document->name}}</a>
                                        <div class="font-size-sm text-muted">Téléchargé le : {{ $document->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                @endif


            </div>

            @if ($bon->ajustements->count() > 0)
                <div class="block-content">
                    <h3 class="block-title">
                        Ajustements ({{ $bon->ajustements->count() }})
                    </h3>
                    <table class="table table-borderless table-hover table-vcenter">
                        <tbody>

                            @foreach ($bon->ajustements as $ajustement)
                            <tr>
                                <td>
                                    <a class="h5" href="be_pages_ecom_store_product.html">{{$ajustement->libelle}}</a>
                                    <div class="font-size-sm text-muted">Montant avant : {{ number_format($ajustement->montant_bon_before, 2, '.', ' ') }} FCFA</div>
                                </td>
                                <td class="text-right">
                                    <div class="font-w600 text-success">{{ number_format($ajustement->montant, 2, '.', ' ') }} FCFA</div>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @if ($editMode)
    </form>
    @endif
</div>


@script
    <script>
        $wire.on('print-recu-bon', () => {
            window.open('{{ route("print-recu-bon", ["bon" => $bon->id]) }}', '_blank');
        });

    </script>
@endscript
