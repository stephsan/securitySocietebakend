<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParametreController extends Controller
{
    public function index(Request $request){
        $parametres=Parametre::orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $parametres=$parametres->where('libelle','like','%'.$request->keyword.'%');
        }
        $parametres=$parametres->get();
        return response([
            "status"=>true,
            "data"=>$parametres
        ]);
        
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(), [
             'libelle'=>'required',
         ]);
         $parametre=Parametre::create([
            "libelle"=>$request->libelle,
            'parametre_id' => $request->parametre_id,
         ]);
         return response([
            "statut"=>true,
            "data"=>$parametre
         ]);
    }
    public function update($id,Request $request){
        $parametre = Parametre::find($id);
        //dd($request->all());
        if($parametre==null){
            return response()->json([
                'status'=>false,
                'message'=>"Accun parametre retrouve dans la base de données",
            ]);
        }
        $validator= Validator::make($request->all(), [
            'libelle'=>'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Corriger l'erreur ",
                'errors'=>$validator->errors()
            ]);
        }
            $parametre->update([
                'libelle' => $request->libelle,
                'parametre_id' => $request->parametre_id,
            ]);
            return response([
                "statut"=>true,
                "data"=>$parametre
             ]);
    }
    public function show($id){
        $parametre= Parametre::find($id);
        if($parametre){
            return response()->json([
                'status'=>true,
                'data'=>$parametre
            ]);
        }
       else{
            return response()->json([
                'status'=>false,
                'message'=>"Aucun parametre retouvé dans la base ",
            ]);
        }
    }
    public function destroy($id){
        $parametre=Parametre::find($id);
        if($parametre==null){
            return response()->json([
                'status'=>false,
                'message'=>"Aucun paramètre retouvé dans la base ",
            ]);
        }
        $parametre->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Suppression faite avec success ",
        ]);
    }
}
