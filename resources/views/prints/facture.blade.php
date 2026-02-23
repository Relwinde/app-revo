<style>
    body {
        font-family: roboto, sans-serif;
        margin: 0;
        padding: 10px;
        font-size: 10pt;
    }
    .header-info {
        margin-bottom: 20px;
    }
    .company-name {
        font-weight: bold;
        font-size: 14pt;
        margin-bottom: 5px;
    }
    .company-details {
        font-size: 9pt;
        line-height: 1.4;
        color: #333;
    }
    .date-location {
        text-align: right;
        margin-bottom: 20px;
        font-size: 10pt;
    }
    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .invoice-title {
        font-size: 18pt;
        font-weight: bold;
        color: #333;
    }
    .invoice-number {
        font-size: 16pt;
        font-weight: bold;
        color: #cc0000;
    }
    .client-info-box {
        margin-bottom: 20px;
    }
    .info-row {
        display: flex;
        margin-bottom: 8px;
        font-size: 10pt;
    }
    .info-label {
        font-weight: bold;
        width: 150px;
    }
    .info-value {
        flex: 1;
    }
    .table-header {
        background-color: #cc0000;
        color: white;
        font-weight: bold;
        padding: 10px;
        text-align: center;
    }
    .table-subheader {
        background-color: #f0f0f0;
        font-weight: bold;
        padding: 8px;
        text-align: center;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .items-table td {
        padding: 8px;
        border: 1px solid #ddd;
        font-size: 9pt;
    }
    .items-table th {
        padding: 8px;
        border: 1px solid #ddd;
        background-color: #e8e8e8;
        font-weight: bold;
        text-align: center;
        font-size: 9pt;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .text-left {
        text-align: left;
    }
    .line-number {
        width: 8%;
    }
    .description {
        width: 35%;
    }
    .unit {
        width: 12%;
    }
    .unit-price {
        width: 15%;
    }
    .quantity {
        width: 10%;
    }
    .amount {
        width: 20%;
    }
    .total-row {
        background-color: #f0f0f0;
        font-weight: bold;
        text-align: right;
        padding: 10px;
    }
    .footer-info {
        margin-top: 20px;
        font-size: 9pt;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }
</style>

<div style="font-family: roboto;">
    @include('prints.partials.entreprise-header')

    <hr style="margin: 15px 0; border: none; border-top: 1px solid #ccc;">

    <!-- Date et Lieu -->
    <div class="date-location">
        <strong>Date:</strong> {{ \Carbon\Carbon::parse($facture->date)->format('d ') }}{{ __(\Carbon\Carbon::parse($facture->date)->format('n')) }} {{ \Carbon\Carbon::parse($facture->date)->format('Y') }}
    </div>

    <!-- Titre et Numéro de Facture -->
    <div class="invoice-header date-location">
        <div class="invoice-title">Facture Définitive</div>
        <div>
            <div class="invoice-number">{{ $facture->reference }}</div>
        </div>
    </div>

 <!-- Informations Client -->
    <div style="width: 100%; margin-bottom: 20px;">
        <table style="width: 100%;">
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: left; vertical-align: top;">
                    <strong>Facture À :</strong><br>
                    {{$facture->client->name}} <br>
                    {{$facture->client->address}} <br>
                    Tel: {{$facture->client->phone}} <br>
                    RCCM: {{$facture->client->rccm}} <br>
                    IFU: {{$facture->client->ifu}} <br>
                    DIVISION FISCALE: {{$facture->client->div_fisc}}
                </td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: right; vertical-align: top;">
                    <span>Date :</span> {{ \Carbon\Carbon::parse($facture->date)->format('d ') }}{{ __(\Carbon\Carbon::parse($facture->date)->format('n')) }} {{ \Carbon\Carbon::parse($facture->date)->format('Y') }} <br>
                    <span>N° de facture :</span> {{$facture->reference}} <br>
                    <span>Référence client :</span> {{$facture->client->code}} <br>
                    <span>Emis :</span> {{$facture->user->name}} <br>
                    <span>Email :</span> {{$facture->user->email}} <br>
                    <span>Téléphone :</span>  <br>
                </td>
            </tr>
        </table>
    </div>

    
    




    <!-- Informations Client -->
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <th class="table-header" style="text-align: left;">Code Client</th>
            <th class="table-header" style="text-align: left;">Personne Contact</th>
            <th class="table-header">Délai de validité</th>
            <th class="table-header">Condition d'échéance</th>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $facture->client->code ?? 'N/A' }}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $facture->personne_contact ?? 'N/A' }}</td>
            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $facture->payment_terms ?? 'N/A' }} jours</td>
            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $facture->payment_conditions ?? '0%' }}</td>
        </tr>
    </table>

    <!-- Tableau des Lignes -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="line-number">No Ligne</th>
                <th class="description">Description</th>
                <th class="unit">Unité Tarifaire</th>
                <th class="unit-price">Taux unitaire</th>
                <th class="quantity">Quantité</th>
                <th class="amount">Montant HT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facture->items ?? [] as $item)
                <tr>
                    <td class="line-number text-center">{{ $loop->iteration }}</td>
                    <td class="description text-left">{{ $item->description }}</td>
                    <td class="unit text-center">{{ $item->unit }}</td>
                    <td class="unit-price text-right">{{ number_format($item->unit_price, 2, ',', ' ') }} FCFA</td>
                    <td class="quantity text-center">{{ $item->quantity }}</td>
                    <td class="amount text-right">{{ number_format($item->unit_price * $item->quantity, 2, ',', ' ') }} FCFA</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 15px;">Aucun élément</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="total-row">MONTANT HT</td>
                <td class="total-row">{{ number_format($facture->items->sum(function($item) { return $item->unit_price * $item->quantity; }) ?? 0, 2, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td colspan="5" class="total-row">TVA 18%</td>
                <td class="total-row">{{ number_format($facture->items->sum(function($item) { return $item->unit_price * $item->quantity; }) * 0.18 ?? 0, 2, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td colspan="5" class="total-row">Acompte perçu</td>
                <td class="total-row">{{ number_format($facture->avance ?? 0, 2, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td colspan="5" class="total-row">Reste à payer</td>
                <td class="total-row">{{ number_format(($facture->items->sum(function($item) { return $item->unit_price * $item->quantity; }) ?? 0) * 1.18 - ($facture->avance ?? 0), 2, ',', ' ') }} FCFA</td>
        </tfoot>
    </table>

    <div class="date-location">
        <strong>La Comptabilité</strong>
    </div>

    <!-- Pied de page -->
    <div class="footer-info">
        <p style="margin: 5px 0; color: #666;">{!! nl2br(e($facture->comments)) !!}</p>
    </div>

</div>