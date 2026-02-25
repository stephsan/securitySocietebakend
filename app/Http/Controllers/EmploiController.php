<?php

namespace App\Http\Controllers;

use App\Models\PersonneFonction;
use Illuminate\Http\Request;

class EmploiController extends Controller
{
    public function store_fonction_personne(Request $request)
{
    $request->validate([
        'personne_id'=>'required',
        'valeur_id'=>'required',
        'date_debut'=>'required|date'
    ]);
    // Vérifier chevauchement période
    $exists = PersonneFonction::where('personne_id',$request->personne_id)
        ->where(function($q) use ($request){
            $q->whereNull('date_fin')
              ->orWhere('date_fin','>=',$request->date_debut);
        })->exists();
    if($exists){
        return response()->json([
            'message'=>'Période déjà occupée'
        ],422);
    }
    PersonneFonction::create($request->all());
    return response()->json([
        'status'=>true
    ]);
}
public function destroy_fonction_personne($id){
    $personneFonction=PersonneFonction::find($id);
    
    if($personneFonction==null){
        return response()->json([
            'status'=>false,
            'message'=>"Aucune fonction retouvée dans la base ",
        ]);
    }
    $personneFonction->delete();
    return response()->json([
        'status'=>true,
        'message'=>"Suppression faite avec success ",
    ]);

}
}
