<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PrestationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestations=Prestation::orderBy('created_at','DESC');
        $prestations=$prestations->get();
        return response([
            "status"=>true,
            "data"=>$prestations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nature_prestation'=>'required',
            'montant_min_prestation'=>'required',
        ]);
        
        $prestation=Prestation::create([
            'nature_prestation'=>$request->nature_prestation,
            'description_prestation'=>$request->description_prestation,
            'montant_min_prestation'=>$request->montant_min_prestation,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>"Enregistrement fait avec success ",
            'data'=>$prestation
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prestation= Prestation::find($id);
        if($prestation){
            return response()->json([
                'status'=>true,
                'data'=>$prestation
            ]);
        }
       else{
            return response()->json([
                'status'=>false,
                'message'=>"Aucune prestation retouvée dans la base ",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $prestation = Prestation::find($id);
        if($prestation==null){
            return response()->json([
                'status'=>false,
                'message'=>"Accune prestation retrouvee dans la base de données",
            ]);
        }
        $request->validate([
            'nature_prestation'=>'required',
            'montant_min_prestation'=>'required',
        ]);
            $prestation->update([
               'nature_prestation'=>$request->nature_prestation,
                'description_prestation'=>$request->description_prestation,
                'montant_min_prestation'=>$request->montant_min_prestation,
            ]);
            return response()->json([
                'status'=>true,
                'message'=>"Modification faite avec success ",
                'data'=>$prestation
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prestation=Prestation::find($id);
        if($prestation==null){
            return response()->json([
                'status'=>false,
                'message'=>"Aucune prestation retouvée dans la base ",
            ]);
        }
        $prestation->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Suppression faite avec success ",
        ]);
    
    }
}
