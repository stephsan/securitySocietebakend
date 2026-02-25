<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonneFonction extends Model
{
    protected $table = "personne_fonctions";
    protected $guarded = [];
    public function valeur()
    {
        return $this->belongsTo(Valeur::class,"valeur_id");
    }
}
