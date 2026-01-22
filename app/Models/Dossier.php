<?php

namespace App\Models;

use Mpdf\Mpdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function print_ordre_mission()
    {

         ini_set('memory_limit', '440M');
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        // Configuration des polices
        $mpdf->SetDefaultFont('Roboto');
        $mpdf->SetFont('Roboto', '', 11);

        // Pied de page
        $footer = '<div style="text-align: center; font-size: 10px;">
                    Page {PAGENO}/{nbpg}
                   </div>';
        $mpdf->SetHTMLFooter($footer);


        // Contenu principal
        $html = view('prints.ordre-mission', ['dossier' => $this])->render();

        $mpdf->WriteHTML($html);

        $mpdf->Output();
    }
}
