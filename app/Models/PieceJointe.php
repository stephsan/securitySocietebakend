<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    protected $table = 'piecejointes';
    protected $guarded = [];
    public function valeur()
    {
        return $this->belongsTo(Valeur::class,"type_document");
    }
    public function personne()
    {
        return $this->belongsTo(Personne::class);
         
    }
}
