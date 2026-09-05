<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'capital',
        'adresse',
        'telephone',
        'email',
        'rccm',
        'ifu',
        'regime_imposition',
        'division_fiscale',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create();
    }
}
