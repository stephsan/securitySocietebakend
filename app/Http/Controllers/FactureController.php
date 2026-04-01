<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Facture;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FactureController extends Controller
{
    public function facturer(Request $request, $id)
    {
        
        $contrat = Contrat::with('lignes')->findOrFail($id);
        
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // 🔹 Vérifier si période déjà facturée
        $existe = Facture::where('contrat_id', $contrat->id)
            ->where('date_debut', $request->date_debut)
            ->where('date_fin', $request->date_fin)
            ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Cette période est déjà facturée.'
            ], 400);
        }

        DB::transaction(function () use ($contrat, $request) {

            // 🔹 Génération numéro facture
            $seq = DB::table('sequences')
                    ->where('name', 'factures')
                    ->lockForUpdate()
                    ->first();
            $next = $seq->current + 1;
            $numero = now()->year . '-00' . $next;
            DB::table('sequences')
                ->where('name', 'factures')
                ->update(['current' => $next]);

            $facture = Facture::create([
                'client_id' => $contrat->client_id,
                'contrat_id' => $contrat->id,
                'numero_facture' => $numero,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'montant_total' => 0,
                'statut'=>'brouillon'
            ]);

            $total = 0;
            $lignes_envoyees_par_front= $request['lignes'];
            
            foreach ($lignes_envoyees_par_front as $ligne) {
               // dd($ligne);
                $montant_ligne= ($ligne['jours']==30)?($ligne['montant_unitaire']*$ligne['quantite']):($ligne['montant_unitaire']*$ligne['quantite']/30*$ligne['jours']);
                $facture->lignes()->create([
                    'contrat_ligne_id' => $ligne['contrat_ligne_id'],
                    'prestation_id' => $ligne['prestation_id'],
                    'quantite' => $ligne['quantite'],
                    'montant' => $ligne['montant_unitaire'],
                    'nombre_de_jour_facture'=>$ligne['jours'],
                    'montant_total' =>$montant_ligne,
                    
                ]);

                $total += $montant_ligne;
            }

            $facture->update([
                'montant_total' => $total
            ]);
        });

        return response()->json([
            'message' => 'Facture générée avec succès'
        ]);
    }
    
    // public function generatePdf(Facture $facture)
    // {
    //     $facture->load(['contrat.client', 'lignes']);

    //     $pdf = Pdf::loadView('pdf.facture', compact('facture'));

    //     return $pdf->download('facture_'.$facture->numero_facture.'.pdf');
    // }
    public function generatePdf(Facture $facture)
{
    $facture->load(['contrat.client', 'lignes']);

    // 🔹 Données QR Code
    $qrData = json_encode([
        'facture' => $facture->numero_facture,
        'client' => $facture->contrat->client->denomination,
        'montant' => $facture->montant_total,
        'periode' => $facture->date_debut . ' - ' . $facture->date_fin,
        'url' => url('/verification/facture/' . $facture->id)
    ]);

    // 🔹 Générer QR Code image base64
    $qrCode = base64_encode(
        QrCode::format('svg')
                ->size(150)
                ->errorCorrection('H')
                ->style('square')
                ->eye('square')
                ->generate($qrData)
    );
    // $qrcode =  base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate("Ceci est un recepissé généré par la plateforme de gestion des bénéficiaires du projet ECOTEC" . "Code didentification:" . " " . $promoteur->code_promoteur . "_" . $promoteur->id . "ECOTEC"));

    $pdf = Pdf::loadView('pdf.facture', [
        'facture' => $facture,
        'qrCode' => $qrCode
    ]);

    return $pdf->download('facture_'.$facture->numero_facture.'.pdf');
}
    public function changeStatus(Request $request, $id){
        $facture = Facture::findOrFail($id);

    switch ($request->action) {
        case 'valider':
            if ($facture->statut === 'brouillon') {
                $facture->statut = 'validee';
            }
            break;

        case 'payer':
            if ($facture->statut === 'validee') {
                $facture->statut = 'payee';
            }
            break;

        case 'rejeter':
            if ($facture->statut === 'validee') {
                $facture->statut = 'brouillon';
            }
            break;
    }

    $facture->save();

    return response()->json([
        'message' => 'Statut mis à jour',
        'data' => $facture
    ]);

    }
}
