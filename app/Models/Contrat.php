<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    protected $fillable = [
        'numero_contrat',
        'client_id',
        'clause_particulieres',
        'contract_file'
    ];

    public function lignes()
    {
        return $this->hasMany(ContratLigne::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

}
