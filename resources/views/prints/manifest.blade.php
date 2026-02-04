<style>
    .location {
        text-align: right;
        margin: 15px 0;
        font-size: 11pt;
    }
</style>

<div style="font-family: roboto;">
     @include('prints.partials.entreprise-header')

    <hr>

    <div class="location" style="margin: 20px; width: 100%;">
        <span style="text-align: right; width:100%; font-family: roboto; font-size: 11pt;"> Ouagadougou, le {{ now()->format('d/m/Y') }}  </span>
    </div>

    <table style="width: 100%; margin-top: 25px;">
        <thead>

        </thead>

        <tbody style="text-align: center; width: 100%;">
            <tr>
                <th style="width: 60%, text-align: right; font-family: roboto; font-size: 22px; font-weight: bold;" >
                    MANIFESTE
                </th>
                <th style=" width: 40%; text-align: left; color: red; font-family: roboto; font-size: 22px; font-weight: bold;" >
                    {{ $dossier->numero }}
                </th>
            </tr>
        </tbody>

    </table>

    <table style="font-size: 12px; width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr style="width: 100%;">
                <td style="width: 15%; padding: 5px;">
                    <b> {{ strtoupper("Expediteur :") }}</b>
                </td>
                <td style="color: rgb(36, 29, 43); width: 65%; text-align: left;">
                    {{$dossier->client->name}}
                </td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 15%; padding: 5px;">
                    <b> {{ strtoupper("Destinataire :") }}</b>
                </td>
                <td style="color: rgb(36, 29, 43); width: 65%; text-align: left;">
                    {{$dossier->destinate->name}}
                </td>
            </tr>
            <tr>
                <td style="width: 15%; padding: 5px; padding-bottom: 5px;">
                    <b>{{ strtoupper("Vehicule :") }}</b>
                </td>

                <td style="color: rgb(36, 29, 43); width: 65%; text-align: left;">
                    {{$dossier->camion ? $dossier->camion->license_plate : "Aucun"}}
                </td>
            </tr>
            <tr style="width: 100%;">
                <td style="width: 15%; padding: 5px;">
                    <b> {{ strtoupper("Conducteur :") }}</b>
                </td>
                <td style="color: rgb(36, 29, 43); width: 65%; text-align: left;">
                    {{$dossier->chauffeur->name}}
                </td>
            </tr>

           
        </thead>
    </table>

    <style>
    .manifest-table{ width:100%; border-collapse:collapse; font-size:11pt; margin-top:20px; }
    .manifest-table th, .manifest-table td{ border:1px solid #000; padding:6px; text-align:center; }
    .manifest-table th{ background:#f3f3f3; font-weight:700; }
    .manifest-table td.left{ text-align:left; }
</style>

<table class="manifest-table">
    <thead>
        <tr>
            <th>POS</th>
            <th>N° de commande ou PO</th>
            <th>Nombre de colis</th>
            <th>Noms des fournisseurs</th>
            <th>Nature de colis</th>
            <th>Observations</th>
        </tr>
    </thead>
    <tbody>
        @foreach(($dossier->commandes ?? []) as $i => $ligne)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ligne->numero ?? '-' }}</td>
                <td>{{ $ligne->quantite ?? '-' }}</td>
                <td class="left">{{ $ligne->fournisseur ?? '-' }}</td>
                <td class="left">{{ $ligne->marchandise->name ?? '-' }}</td>
                <td class="left">{{ $ligne->description ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
