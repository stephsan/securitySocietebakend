<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valeur extends Model
{
    protected $fillable = [
        'libelle',
        'parametre_id',
        'valeur_id'
    ];

    /* =============================
       Relation Parametre
    ============================= */

    public function parametre()
    {
        return $this->belongsTo(Parametre::class);
    }

    /* =============================
       Parent (auto relation)
    ============================= */

    public function parent()
    {
        return $this->belongsTo(Valeur::class, 'valeur_id');
    }

    /* =============================
       Enfants
    ============================= */

    public function children()
    {
        return $this->hasMany(Valeur::class, 'valeur_id');
    }
}