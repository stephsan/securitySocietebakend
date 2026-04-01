<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = [
        'client_id',
        'contrat_id',
        'numero_facture',
        'date_debut',
        'date_fin',
        'montant_total',
        'statut'
    ];
    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function lignes()
    {
        return $this->hasMany(FactureLigne::class);
    }
}
