<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonDeCaisseCommentaire extends Model
{

    protected $guarded = [];
    use HasFactory;

    public function bonDeCaisse()
    {
        return $this->belongsTo(BonDeCaisse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
