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
        'marchandise',
        'quantite',
        'description',
        'fournisseur',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dossiers()
    {
        return $this->belongsToMany(Dossier::class, 'commande_dossier');
    }


}
