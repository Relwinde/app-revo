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
                    ORDRE DE MISSION
                </th>
                <th style=" width: 40%; text-align: left; color: red; font-family: roboto; font-size: 22px; font-weight: bold;" >
                    {{ $dossier->numero }}
                </th>
            </tr>
        </tbody>

    </table>


    <div style="margin-top: 20px; margin-right: 0px; margin-bottom: 20px; margin-left: 5px; font-family: roboto; font-size: 14px; font-style: italic;">Messieurs</div>

    <table style="font-size: 14px; width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b> {{ strtoupper("Conducteur :") }}</b>
                </td>
                <td style="color: blueviolet;">
                    {{$dossier->chauffeur->name}}
                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("CNIB :") }}</b>
                </td>
                <td style="color: blueviolet;">
                    {{$dossier->chauffeur->ref_identite}}
                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Telephone :") }}</b>
                </td>
                <td style="color: blueviolet;">
                    {{$dossier->chauffeur->phone}}
                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Accompagnant :") }}</b>
                </td>
                <td style="color: blueviolet;">

                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Service :") }}</b>
                </td>

                <td style="color: blueviolet;">

                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Escorte à organiser :") }}</b>
                </td>
                <td style="color: blueviolet;">

                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Lieu de la mission :") }}</b>
                </td>
                <td style="color: blueviolet;">

                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Motif de la mission :") }}</b>
                </td>

                <td style="color: blueviolet;">

                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Vehicule :") }}</b>
                </td>

                <td style="color: blueviolet;">

                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                    <b>{{ strtoupper("Date de depart :") }}</b>
                </td>

                <td style="color: blueviolet;">
                   
                </td>
            </tr>

            <tr>
                <td style="width: 35%; padding: 10px;">
                     <b>{{ strtoupper("Date de retour :") }}</b>
                </td>

                <td style="color: blueviolet;">

                </td>
            </tr>


        </thead>
    </table>
</div>