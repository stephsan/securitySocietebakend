<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $guarded = [];
    public function nature()
    {
        return $this->belongsTo(Valeur::class,'nature_prestation');
    }

}

