<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasOne(Dossier::class);
    }

    
}
