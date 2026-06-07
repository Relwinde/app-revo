<div>
    @include('prints.partials.entreprise-header')

    <hr  style="height:2px; color:#883905; margin :0px;">
    <center style="text-align: center;">
            <p style="font-size: 14; line-height: 0;">
                <b>
                    RECU DE DEPENSE
                </b>
            </p>
    </center>

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
                @if($bon->type_paiement === 'CHEQUE')
                <tr>
                    <td colspan="3">
                        <p><b>Détails du chèque:</b></p>
                        <p>Numéro: {{$bon->numero_cheque}}</p>
                        <p>Banque: {{$bon->banque_cheque}}</p>
                        <p>Date: {{ \Carbon\Carbon::parse($bon->date_cheque)->format('d/m/Y') }}</p>
                    </td>
                </tr>
                @endif
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