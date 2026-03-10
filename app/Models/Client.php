<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];
    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
    
}
