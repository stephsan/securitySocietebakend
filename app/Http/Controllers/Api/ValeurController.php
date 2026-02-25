<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ValeurResource;
use App\Models\Valeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValeurController extends Controller
{
    public function index(Request $request){
        $valeurs=Valeur::with(['parametre', 'parent'])->orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $valeurs=$valeurs->where('libelle','like','%'.$request->keyword.'%');
        }
        $valeurs=$valeurs->get();
        return response([
            "status"=>true,
            "data"=>ValeurResource::collection($valeurs)
        ]);
        
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(), [
             'libelle'=>'required',
         ]);
         $valeur=Valeur::create([
            "libelle"=>$request->libelle,
            'parametre_id' => $request->parametre_id,
            'valeur_id' => $request->valeur_id,
         ]);
         return response([
            "statut"=>true,
            "data"=>$valeur
         ]);
    }
    public function update($id,Request $request){
        $valeur = Valeur::find($id);
        if($valeur==null){
            return response()->json([
                'status'=>false,
                'message'=>"Accun valeur retrouve dans la base de données",
            ]);
        }
        $validator= Validator::make($request->all(), [
            'nom'=>'required|min:3',
            'prenom'=>'required|min:5'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Corriger l'erreur ",
                'errors'=>$validator->errors()
            ]);
        }
            $valeur->update([
                'libelle' => $request->libelle,
                'parametre_id' => $request->parametre_id,
                'valeur_id' => $request->valeur_id,
            ]);
            return response([
                "statut"=>true,
                "data"=>$valeur
             ]);
    }
    public function show($id){
        $valeur= Valeur::find($id);
        if($valeur){
            return response()->json([
                'status'=>true,
                'data'=>$valeur
            ]);
        }
       else{
            return response()->json([
                'status'=>false,
                'message'=>"Aucune valeur retouvée dans la base ",
            ]);
        }
    }
    public function destroy($id){
        $parametre=Valeur::find($id);
        if($parametre==null){
            return response()->json([
                'status'=>false,
                'message'=>"Aucune valeur retouvé dans la base ",
            ]);
        }
        $parametre->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Suppression faite avec success ",
        ]);
    }
//Fontion retourne des valeurs en fonction de l'id parametre
    public function return_valeurs($parametre_id)
    {
        $valeurs = Valeur::where('parametre_id',$parametre_id)->get();
        return response()->json([
            'data' => $valeurs
        ]);
    }
}
