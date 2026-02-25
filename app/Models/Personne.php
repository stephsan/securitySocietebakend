<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personne extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('uploads/image_personne/' . $this->image);
        }

        return url('uploads/image_personne/default.jpg');
    }
    public function documents()
    {
        return $this->hasMany(PieceJointe::class);
    }
    public function postes_occupees()
    {
        return $this->hasMany(PersonneFonction::class);
    }
    public function valeur()
    {
        return $this->belongsTo(Valeur::class,"valeur_id");
    }
}
