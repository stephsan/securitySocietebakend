<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'numero_contrat' => 'required|unique:contrats',
            'client_id' => 'required|exists:clients,id',
            'clause_particulieres' => 'nullable',
            // 'lignes' => 'required|array|min:1',
            // 'lignes.*.type_prestation' => 'required',
            // 'lignes.*.quantite' => 'required|integer|min:1',
            // 'lignes.*.montant' => 'required|numeric|min:0'
        ]);
    
        DB::beginTransaction();
    
        try {
            $contrat = Contrat::create([
                'numero_contrat' => $request->numero_contrat,
                'client_id' => $request->client_id,
                'clause_particulieres' => $request->clause_particulieres
            ]);
    
             foreach ($request->lignes as $ligne) {
                 $contrat->lignes()->create($ligne);
             }
    
             DB::commit();
    
            return response()->json([
                'message' => 'Contrat créé avec succès',
                'contrat' => $contrat->load('lignes')
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
