<?php

namespace App\Models;

use Mpdf\Mpdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Dossier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function camion()
    {
        return $this->belongsTo(Camion::class);
    }

    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    public function destinate()
    {
        return $this->belongsTo(Client::class, 'destinataire');
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

     public function factureProforma()
    {
        return $this->belongsTo(FactureProforma::class);
    }

    public function generateFactureDefinitive() : Facture
    {
        $facture = new Facture();
        $factureProforma = $this->factureProforma;


        $facture->reference = 'REVO'.substr(date('Y'), -2)."-FAD". str_pad(Facture::max('id') + 1, 3, '0', STR_PAD_LEFT);
        $facture->date = now();
        $facture->client_id = $factureProforma->client_id;
        $facture->camion_id = $factureProforma->camion_id;
        $facture->chauffeur_id = $factureProforma->chauffeur_id;
        $facture->facture_proforma_id = $factureProforma->id;
        $facture->payment_terms = $factureProforma->payment_terms;
        $facture->payment_conditions = $factureProforma->payment_conditions;
        $facture->personne_contact = $factureProforma->personne_contact;
        $facture->total_amount = $factureProforma->total_amount;
        $facture->dossier_id = $this->id;
        $facture->created_by = auth()->id();
        $facture->avance = 0;

        try{
            DB::beginTransaction();
            $facture->save();
    
            foreach ($factureProforma->items as $item) {
                $factureItem = new FactureItem();
                $factureItem->type = "DEF";
                $factureItem->facture_id = $facture->id;
                $factureItem->description = $item->description;
                $factureItem->quantity = $item->quantity;
                $factureItem->unit = $item->unit;
                $factureItem->unit_price = $item->unit_price;
                $factureItem->save();
            }

            DB::commit();

        }

        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $facture;
    }

    public function print_ordre_mission()
    {

         ini_set('memory_limit', '440M');
        
        // Configuration des polices Roboto
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $fontDirs[] = base_path('assets/fonts/roboto');
        
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $fontData['roboto'] = [
            'R' => 'Roboto-Regular.ttf',
            'B' => 'Roboto-Bold.ttf',
            'I' => 'Roboto-Italic.ttf',
            'BI' => 'Roboto-BoldItalic.ttf',
        ];
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 0,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'fontDir' => $fontDirs,
            'fontdata' => $fontData,
            'default_font' => 'roboto',
        ]);

        // Configuration des polices
        $mpdf->SetDefaultFont('roboto');
        $mpdf->SetFont('roboto', '', 11);

        // Pied de page
        $footer = '<div style="text-align: center; font-size: 10px;">
        <hr>
        Société à Responsabilité au Capital de 1 000 000 francs CFA <br>
        Immatriculée au Registre de Commerce et du Crédit Mobilier sous le numéro BFOUA2021 B11588 <br>
        N°IFU : 00167673T – Régime Fiscal RSI
                   </div>';
        $mpdf->SetHTMLFooter($footer);

        // Page {PAGENO}/{nbpg}

        // Contenu principal
        $html = view('prints.ordre-mission', ['dossier' => $this])->render();

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }

    public function print_manifest()
    {

        ini_set('memory_limit', '440M');
        
        // Configuration des polices Roboto
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $fontDirs[] = base_path('assets/fonts/roboto');
        
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $fontData['roboto'] = [
            'R' => 'Roboto-Regular.ttf',
            'B' => 'Roboto-Bold.ttf',
            'I' => 'Roboto-Italic.ttf',
            'BI' => 'Roboto-BoldItalic.ttf',
        ];
        
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 0,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'fontDir' => $fontDirs,
            'fontdata' => $fontData,
            'default_font' => 'roboto',
        ]);

        // Configuration des polices
        $mpdf->SetDefaultFont('roboto');
        $mpdf->SetFont('roboto', '', 11);

        // Pied de page
        $footer = '<div style="text-align: center; font-size: 10px;">
        <hr>
        Société à Responsabilité au Capital de 1 000 000 francs CFA <br>
        Immatriculée au Registre de Commerce et du Crédit Mobilier sous le numéro BFOUA2021 B11588 <br>
        N°IFU : 00167673T – Régime Fiscal RSI
                   </div>';
        $mpdf->SetHTMLFooter($footer);

        // Page {PAGENO}/{nbpg}

        // Contenu principal
        $html = view('prints.manifest', ['dossier' => $this])->render();

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }
}
