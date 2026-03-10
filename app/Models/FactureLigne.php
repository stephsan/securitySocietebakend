<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FactureLigne extends Model
{
    protected $fillable = [
        'facture_id',
        'contrat_ligne_id',
        'prestation_id',
        'quantite',
        'montant',
        'montant_total',
        'nombre_de_jour_facture'
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
    public function prestation()
    {
        return $this->belongsTo(Prestation::class);
    }
}
