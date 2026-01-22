<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'numero',
        'user_id',
        'fournisseur_id',
        'marchandise_id',
        'quantite',
        'description',
        'fournisseur'
    ];


    public function marchandise()
    {
        return $this->belongsTo(Marchandise::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }


}
