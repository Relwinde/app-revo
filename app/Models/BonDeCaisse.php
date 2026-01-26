<?php

namespace App\Models;

use Mpdf\Mpdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonDeCaisse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function camion()
    {
        return $this->belongsTo(Camion::class);
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function etapeBons()
    {
        return $this->hasMany(EtapeBon::class);
    }

    public function commentaires()
    {
        return $this->hasMany(BonDeCaisseCommentaire::class);
    }

    public function ajustements()
    {
        return $this->hasMany(AjustementBon::class);
    }

    public function print_recu()
    {
        // Logic to generate and return the receipt for this BonDeCaisse
        // This could involve generating a PDF or rendering a view

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
            'format' => 'A5',
            'orientation' => 'L',
            'margin_left' => 5,
            'margin_right' => 5,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'fontDir' => $fontDirs,
            'fontdata' => $fontData,
            'default_font' => 'roboto',
        ]);

        // Configuration des polices
        $mpdf->SetDefaultFont('roboto');
        $mpdf->SetFont('roboto', '', 11);

        // Pied de page
        $footer = '<div style="text-align: center; font-size: 10px;">
                    Page {PAGENO}/{nbpg}
                   </div>';
        $mpdf->SetHTMLFooter($footer);


        // Contenu principal
        $html = view('prints.bon-recu', ['bon' => $this])->render();

        $mpdf->WriteHTML($html);

        $mpdf->Output();

    }
    
}
