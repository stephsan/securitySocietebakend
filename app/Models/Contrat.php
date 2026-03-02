<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    protected $fillable = [
        'numero_contrat',
        'client_id',
        'clause_particulieres'
    ];

    public function lignes()
    {
        return $this->hasMany(ContratLigne::class);
    }
}
