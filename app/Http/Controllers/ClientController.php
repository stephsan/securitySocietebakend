<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients=Client::orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $clients=$clients->where('denomination','like','%'.$request->keyword.'%');
        }
        $clients=$clients->get();
        return response([
            "status"=>true,
            "data"=>$clients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'denomination'=>'required',
            'telephone'=>'required',
        ]);
        

        $lastOne = DB::table('clients')->latest('id')->first();
        if($lastOne){
            $code_client= 'CLT-00'.$lastOne->id;
       
        }
        else{
            $code_client= 'CLT-00'.'0';
        }
        $client=Client::create([
            'code_client'=>$code_client,
            'denomination'=>$request->denomination,
            'telephone'=>$request->telephone,
            'email'=>$request->email,
            'detail_adresse'=>$request->detail_adresse,
            'numero_rccm' => $request->numeroRccm,
            'numero_ifu' => $request->numeroIfu,
            'regime_fiscal' => $request->regimeDimposition,
            'division_fiscale' => $request->divisionFiscale,
            'adresse_siege' => $request->detail_adresse,
            'section' => $request->section,
            'boite_postale' => $request->boitePostale,
            'telephone_mobile' => $request->telephoneMobile,
        ]);
        return response()->json([
            'status'=>true,
            'message'=>"Enregistrement fait avec success ",
            'data'=>$client
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $client= Client::find($id);
        if($client){
            return response()->json([
                'status'=>true,
                'data'=>new ClientResource($client)
            ]);
        }
       else{
            return response()->json([
                'status'=>false,
                'message'=>"Aucun client retouvée dans la base ",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $client = Client::find($id);
        if($client==null){
            return response()->json([
                'status'=>false,
                'message'=>"Accune client retrouvee dans la base de données",
            ]);
        }
        $validator= Validator::make($request->all(), [
            'denomination'=>'required|min:3',
            'telephone'=>'required|min:5'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Corriger l'erreur ",
                'errors'=>$validator->errors()
            ]);
        }
            $client->update([
                'denomination'=>$request->denomination,
                'telephone'=>$request->telephone,
                'email'=>$request->email,
                'detail_adresse'=>$request->detail_adresse,
                'numero_rccm' => $request->numeroRccm,
                'numero_ifu' => $request->numeroIfu,
                'regime_fiscal' => $request->regimeDimposition,
                'division_fiscale' => $request->divisionFiscale,
                'adresse_siege' => $request->detail_adresse,
                'section' => $request->section,
                'boite_postale' => $request->boitePostale,
                'telephone_mobile' => $request->telephoneMobile,
            ]);
            return response()->json([
                'status'=>true,
                'message'=>"Modification faite avec success ",
                'data'=>$client
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client=Client::find($id);
        if($client==null){
            return response()->json([
                'status'=>false,
                'message'=>"Aucun client retouvée dans la base ",
            ]);
        }
        $client->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Suppression faite avec success ",
        ]);
    }
}
