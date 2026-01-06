<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
