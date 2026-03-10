<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContratResource;
use App\Models\Contrat;
use App\Models\ContratLigne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratController extends Controller
{


    public function index(Request $request)
    {
        $contrats=Contrat::orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $contrats=$contrats->where('numero_contrat','like','%'.$request->keyword.'%');
        }
        $contrats=$contrats->get();
        return response([
            "status"=>true,
            "data"=>ContratResource::collection($contrats)
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'clause_particulieres' => 'nullable',
            // 'lignes' => 'required|array|min:1',
            // 'lignes.*.type_prestation' => 'required',
            // 'lignes.*.quantite' => 'required|integer|min:1',
            // 'lignes.*.montant' => 'required|numeric|min:0'
        ]);
    
            DB::beginTransaction();
    try{
            DB::transaction(function () use ($request) {
                $seq = DB::table('sequences')
                    ->where('name', 'contrat')
                    ->lockForUpdate()
                    ->first();
                $next = $seq->current + 1;
                $number = now()->year . '-00' . $next;
                DB::table('sequences')
                    ->where('name', 'contrat')
                    ->update(['current' => $next]);
                    $contrat = Contrat::create([
                        'numero_contrat' => $number,
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
            });
    
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
        public function show($id)
        {
            $contrat = Contrat::with('lignes.prestation')
                ->findOrFail($id);

            return response()->json($contrat);
        }
        public function update(Request $request, $id)
{
    $contrat = Contrat::findOrFail($id);

    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'lignes' => 'required|array|min:1',
        'lignes.*.prestation_id' => 'required|exists:prestations,id',
        'lignes.*.quantite' => 'required|numeric|min:1',
        'lignes.*.montant' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request, $contrat) {

        // 🔹 Mise à jour contrat
        $contrat->update([
            'client_id' => $request->client_id,
            'clause_particulieres' => $request->clause_particulieres,
        ]);

        $existingIds = [];

        foreach ($request->lignes as $ligne) {

            if (isset($ligne['id'])) {
                // 🔹 Mise à jour ligne existante
                $ligneModel = ContratLigne::find($ligne['id']);
                $ligneModel->update([
                    'prestation_id' => $ligne['prestation_id'],
                    'quantite' => $ligne['quantite'],
                    'montant' => $ligne['montant'],
                    'montant_prestation' => $ligne['quantite'] * $ligne['montant'],
                ]);
                $existingIds[] = $ligneModel->id;
            } else {
                // 🔹 Nouvelle ligne
                $newLigne = $contrat->lignes()->create([
                    'prestation_id' => $ligne['prestation_id'],
                    'quantite' => $ligne['quantite'],
                    'montant' => $ligne['montant'],
                    'montant_prestation' => $ligne['quantite'] * $ligne['montant'],
                ]);
                $existingIds[] = $newLigne->id;
            }
        }
        // 🔥 Supprimer les lignes supprimées côté frontend
            $contrat->lignes()
                ->whereNotIn('id', $existingIds)
                ->delete();
        });

    return response()->json(['message' => 'Contrat modifié avec succès']);
}
        
}
