<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PieceJointe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'personne_id' => 'required|exists:personnes,id',
            'type_document' => 'required',
            'fichier' => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048'
        ]);
    
        try {
    
            $file = $request->file('fichier');
    
            $path = $file->store('documents/personnes', 'public');
    
            $document = PieceJointe::create([
                'personne_id' => $request->personne_id,
                'type_document' => $request->type_document,
                'chemin_fichier' => $path,
                'nom_original' => $file->getClientOriginalName()
            ]);
    
            return response()->json([
                'status' => true,
                'data' => $document
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $document = PieceJointe::findOrFail($id);
        if ($request->hasFile('document')) {
            // supprimer ancien fichier
            // if (Storage::exists($document->path)) {
            //     Storage::delete($document->path);
            // }
            $file = $request->file('document');
            $path = $file->store('documents/personnes', 'public');
            $document->update([
                'url' => $path
            ]);
        }
        return response()->json([
            'message' => 'Document mis à jour avec succès'
        ]);
    }
}
