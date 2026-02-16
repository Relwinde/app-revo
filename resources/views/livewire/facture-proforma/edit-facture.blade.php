<div>
     <!-- Hero -->
    @include('partials.pages.header')
    <!-- END Hero -->

    {{-- Page Content  --}}

    <div class="content content-boxed">
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">{{ $numero }}</h3>
                <div class="block-options">
                    <!-- Print Page functionality is initialized in Helpers.print() -->

                    {{-- onclick="One.helpers('print');" --}}

                    @if ($factureProforma?->items->count() > 0)
                        <button wire:click='print' type="button" class="btn-block-option" >
                            <i class="si si-printer mr-1"></i> Imprimer
                        </button>    
                    @endif
                </div>
            </div>
            <div class="block-content">
                <div class="p-sm-4 p-xl-7">
                    <div class="row mb-4">
                        <!-- Date Info -->
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Date</p>
                            <input @if ($numero != null)
                               disabled inactive 
                            @endif type="date" wire:model="date" class="form-control form-control-alt" />
                        </div>
                        <!-- END Date Info -->

                        <!-- Client Info -->
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Client</p>
                            {{-- <address>
                                Street Address<br>
                                State, City<br>
                                Region, Postal Code<br>
                                ctr@example.com
                            </address> --}}

                                <select @if ($numero != null)
                               disabled inactive 
                            @endif wire:model="client_id" class="form-control form-control-alt">
                                    <option value="">Sélectionner un client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <!-- END Client Info -->

                        <!-- Company Info -->
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Personne Contact</p>
                            <input @if ($numero != null)
                               disabled inactive 
                            @endif type="text" wire:model="personne_contact" class="form-control form-control-alt" />
                        </div>
                        <!-- END Company Info -->

                        <!-- Validity Info -->
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Délai de validité (j)</p>
                            <input @if ($numero != null)
                               disabled inactive 
                            @endif type="number" wire:model="payment_terms" class="form-control form-control-alt" />
                        </div>
                        <!-- END Validity Info -->

                    </div>

                    <div class="row mb-4">
                        
                        {{-- Camion info --}}
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Camion</p>
                            <select @if ($numero != null)
                               disabled inactive 
                            @endif wire:model="camion_id" class="form-control form-control-alt">
                                <option value="">Sélectionner un camion</option>
                                @foreach ($camions as $camion)                                    <option value="{{ $camion->id }}">{{ $camion->license_plate }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Chauffeur info --}}
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Chauffeur</p>
                            <select @if ($numero != null)
                               disabled inactive 
                            @endif wire:model="chauffeur_id" class="form-control form-control-alt">
                                <option value="">Sélectionner un chauffeur</option>
                                @foreach ($chauffeurs as $chauffeur)
                                    <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Validity Info -->
                        <div class="col-3 text-center font-size-sm">
                            <p class="h6">Condition d'échéance</p>
                            <input @if ($numero != null)
                               disabled inactive 
                            @endif  type="text" wire:model="payment_conditions" class="form-control form-control-alt" />
                        </div>
                        <!-- END Validity Info -->

                    </div>

                    @if ($numero == null)
                        <div class="row mb-4">
                            <div class="col text-right">
                                <button wire:click="saveHeader" class="btn btn-primary">Enregistrer</button>

                            </div>
                        </div> 
                    @else
                        <div class="row mb-4">
                            <div class="col text-right">
                                <button wire:click="$dispatch('openModal', { component: 'facture-proforma.modals.add-item', arguments: { factureProforma: {{ $factureProforma }} } })" class="btn btn-primary">Nouvelle ligne</button>

                            </div>
                        </div>
                    @endif


                    <div class="row mb-4">
                        <div class="col text-right">
                        </div>
                    </div>
                    <!-- END Invoice Info -->

                    <!-- Table -->
                        <div class="table-responsive push">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 120px;">N° Ligne</th>
                                        <th>Description</th>
                                        <th class="text-center" style="width: 60px;">Unité Tarifaire</th>
                                        <th class="text-right" style="width: 60px;">Taux unitaire</th>
                                        <th class="text-right" style="width: 60px;">Quantité</th>
                                        <th class="text-right" style="width: 120px;">Montant</th>
                                        <th class="text-right" style="width: 60px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureProforma != null ? $factureProforma->items : [] as $item)
                                        <tr>
                                            <td class="text-center">{{$loop->iteration}}</td>
                                            <td>
                                                <p class="font-w600 mb-1">{{$item->description}}</p>
                                                {{-- <div class="text-muted">Design/Development of iOS and Android application</div> --}}
                                            </td>
                                            <td class="text-right">{{$item->unit}}</td>
                                            <td class="text-right">{{$item->unit_price}}</td>
                                            <td class="text-center">
                                                <span class="badge badge-pill badge-primary">{{$item->quantity}}</span>
                                            </td>
                                            <td class="text-right">{{ number_format($item->unit_price * $item->quantity, 2, '.', ' ') }} </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button wire:click="$dispatch('openModal', { component: 'facture-proforma.modals.edit-item', arguments: { item: {{ $item }} } })" type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Edit Item">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </button>
                                                    <button wire:confirm='Êtes vous sûr de vouloir supprimer cette ligne ?' wire:click='removeItem ({{$item->id}})' type="button" class="btn btn-sm btn-light" data-toggle="tooltip" title="Remove Item">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>             
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="font-w700 text-uppercase text-right bg-body-light">Montant Total</td>
                                        <td style="width: 120px;" class="font-w700 text-right bg-body-light">{{ number_format(
                                            $factureProforma?->items->sum(function($item) {
                                                return $item->unit_price * $item->quantity;
                                            }) ?? 0, 
                                            2, ',', ' '
                                        ) }} FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <!-- END Table -->


                    <div class="row">
                        <div class="col">
                            <label for="comments">Commentaires</label>
                        </div>

                        <div class="col">
                            <div class="row mb-4">
                                <div class="col text-right">
                                    <button wire:click="saveComments" class="btn btn-primary">Enregistrer Commentaires</button>
                                    <div wire:loading class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>

                                </div>
                            </div>    
                        </div>
                        <textarea wire:model='comments' class="form-control form-control-alt" name="comments" id="" cols="30" rows="10"></textarea>
                    </div>
    
                </div>
            </div>


        </div>


    </div>
</div>


@script
    <script>
        $wire.on('print-proforma', ({ url }) => {
            window.open(url, '_blank');
        });
    </script>
@endscript