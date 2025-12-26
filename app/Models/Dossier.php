<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dossier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero',
        'description',
        'client_id',
        'camion_id',
        'chauffeur_id',
        'user_id',
        'destinataire',
    ];

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
}
