<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Facture;
use App\Models\Personne;
use Carbon\Carbon;
use Faker\Provider\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $today = Carbon::today();
    $age_18_30 = DB::table('personnes')
                    ->whereNotNull('date_de_naiss')
                    ->whereBetween('date_de_naiss', [$today->copy()->subYears(30), $today->copy()->subYears(18)])
                    ->count();
    $age_31_50 = DB::table('personnes')
                    ->whereNotNull('date_de_naiss')
                    ->whereBetween('date_de_naiss', [$today->copy()->subYears(50), $today->copy()->subYears(31)])
                    ->count();
    $plus_50 = DB::table('personnes')
                    ->where('date_de_naiss', '<', $today->copy()->subYears(50))
                    ->count();
    return response()->json([
        'personnel' => [
            'hommes' => DB::table('personnes')->where('sexe', 'M')->count(),
            'femmes' => DB::table('personnes')->where('sexe', 'F')->count(),
            'age_18_30' => $age_18_30,
            'age_31_50' =>$age_31_50,
            'age_50_plus' => $plus_50,
        ],
        'contrats' => [
            'clients' => DB::table('clients')->count(),
            'factures_validees' => DB::table('factures')->where('statut', 'validee')->count(),
            'factures_payees' => DB::table('factures')->where('statut', 'payee')->count(),
        ],

    ]);
}
}
