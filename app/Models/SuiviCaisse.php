<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviCaisse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bonDeCaisse()
    {
        return $this->belongsTo(BonDeCaisse::class);
    }

    public function depot()
    {
        return $this->belongsTo(Depot::class);
    }

    public function ajustementBon()
    {
        return $this->belongsTo(AjustementBon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function type(): Attribute
    {
        return Attribute::get(function () {
            if ($this->depot_id) {
                return 'DEPOT';
            }

            if ($this->bon_de_caisse_id) {
                return 'DEPENSE';
            }

            if ($this->ajustement_bon_id) {
                return $this->ajustementBon?->type ?? 'AJUSTEMENT';
            }

            return 'INCONNU';
        });
    }

    protected function libelle(): Attribute
    {
        return Attribute::get(function () {
            if ($this->depot_id) {
                return $this->depot?->libelle ?? '-';
            }

            if ($this->bon_de_caisse_id) {
                $bon = $this->bonDeCaisse;

                return $bon?->description ?? $bon?->depense ?? '-';
            }

            if ($this->ajustement_bon_id) {
                return $this->ajustementBon?->libelle ?? '-';
            }

            return '-';
        });
    }

    protected function isEntree(): Attribute
    {
        return Attribute::get(fn () => in_array($this->type, ['RESTITUTION', 'DEPOT']));
    }

    protected function relatedBon(): Attribute
    {
        return Attribute::get(function () {
            if ($this->bon_de_caisse_id) {
                return $this->bonDeCaisse;
            }

            if ($this->ajustement_bon_id) {
                return $this->ajustementBon?->bon_de_caisse;
            }

            return null;
        });
    }
}
