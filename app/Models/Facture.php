<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mpdf\Mpdf;

class Facture extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function camion (){
        return $this->belongsTo(Camion::class);
    }

    public function chauffeur (){
        return $this->belongsTo(Chauffeur::class);
    }

    public function items (){
        return $this->hasMany(FactureItem::class);
    }

    public function user (){
        return $this->belongsTo(User::class, 'created_by');
    }

     public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function print(){

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
        Veuillez libeller tous les chèques à l’ordre de REVO.LIMITED<br>
        <strong>Nous vous remercions de votre confiance!</strong><br>
        REVO.Ltd BURKINA FASO  l 11 BP 3105 Ouagadougou 01 l +226 25 48 11 12 l info@revo-limited.com
                   </div>';
        $mpdf->SetHTMLFooter($footer);

        // Page {PAGENO}/{nbpg}

        // Contenu principal
        $html = view('prints.facture-proforma', ['facture' => $this])->render();

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }
}
