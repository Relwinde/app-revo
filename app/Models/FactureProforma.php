<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureProforma extends Model
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
}
