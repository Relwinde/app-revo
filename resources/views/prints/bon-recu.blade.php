<div>
    @include('prints.partials.entreprise-header')

    <style>
        td{
            padding: 20px;
        }
    </style>

    <hr>

    <div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <p>Emétteur: <b>{{$bon->user->name}}</b></p>
                    </td>
                    <td>
                        <p>Dossier: <b>{{$bon->dossier->numero ?? $bon->transport->numero ?? "AUTRES"}}</b></p>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Intitullé de la dépense: <b>{{$bon->depense}}</b></p>
                    </td>
                    <td>
                        <p>Montant: <b>{{number_format($bon->montant_definitif, 2, '.', ' ')}} CFA</b></p>
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Emis le: <b>{{ strftime("%e %B %Y", strtotime($bon->etapeBons()->where('etape_actuelle', 'MANAGER')->first()->created_at)); }}</b></p>
                    </td>
                    <td>
                        <p>Payé le: <b>{{ strftime("%e %B %Y", strtotime($bon->etapeBons()->where('etape_actuelle', 'PAYE')->first()->created_at)); }}</b></p>
                    </td>
                    <td>
                        <p>Mode: <b>{{$bon->type_paiement}}</b></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        La caisse
                    </td>
                    <td>
                        Le recepteur
                    </td>
                    <td>

                    </td>
                </tr>
            </tbody>
        </table>


    </div>

</div>