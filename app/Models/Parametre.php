<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $guarded = [];
    public function valeurs()
    {
        return $this->hasMany(Valeur::class);
    }

}
