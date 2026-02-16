<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'rccm',
        'ifu',
        'code'
    ];
    use HasFactory, SoftDeletes;

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    
}
