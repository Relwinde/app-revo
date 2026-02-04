@php
    use Carbon\Carbon;

    setlocale(LC_TIME, 'fr_FR.UTF-8');

    $date = Carbon::now();

    setlocale(LC_TIME, 'fr_FR.UTF-8');

    $formattedDate = $date->translatedFormat('l d F Y \à H\h i\m s\s');

@endphp


<style>
    td{
        padding: 10px;
    }
</style>
@include('prints.partials.entreprise-header')

<hr  style="height:2px; color:#883905; margin :0px;">
<center style="text-align: center;">
        <p style="font-size: 14; line-height: 0;">
            <b>
                RECU DE DEPOT
            </b>
        </p>
</center>

<div>
    <table width="100%">
        <tbody >
            <tr>
                <td>
                    <p>Motif : <b>{{$depot->libelle}}</b></p>
                </td>
                <td>
                    <p>Déposant : <b>{{$depot->deposant}}</b></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Montant : <b>{{number_format($depot->montant, 2, '.', ' ')}} CFA</b></p>
                </td>
                <td>
                    <p>Date de dépot : <b>{{ strftime("%e %B %Y", strtotime($depot->created_at)); }}</b></p>
                </td>
            </tr>
            <tr>
                <td>
                    La caisse
                </td>
                <td>
                    Le déposant
                </td>
            </tr>
        </tbody>
    </table>


</div>

<center style="text-align: center;">
    <p style="font-size: 10; margin-top:20px;">
            Reçu imprimé le {{$formattedDate}}
     </p>
</center>

