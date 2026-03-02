<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratLigne extends Model
{
    // protected $table= 'contrat_lignes'
    protected $fillable = [
        'contrat_id',
        'prestation_id',
        'quantite',
        'montant'
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}
