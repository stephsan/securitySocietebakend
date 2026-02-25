<?php

use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\api\ParametreController;
use App\Http\Controllers\api\ValeurController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmploiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\TempImageControler;
use App\Models\Prestation;

// Route protégée par Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('personnes',[PersonneController::class, 'store']);
Route::get('personnes',[PersonneController::class, 'index']);
Route::get('personnes/{id}',[PersonneController::class, 'show']);
Route::put('personnes/{id}',[PersonneController::class, 'update']);
Route::post('save-temp-image',[TempImageControler::class, 'store']);

Route::post('parametres',[ParametreController::class, 'store']);
Route::get('parametres',[ParametreController::class, 'index']);
Route::get('parametres/{id}',[ParametreController::class, 'show']);
Route::put('parametres/{id}',[ParametreController::class, 'update']);

Route::post('valeurs',[ValeurController::class, 'store']);
Route::get('valeurs',[ValeurController::class, 'index']);
Route::get('valeurs/{id}',[ValeurController::class, 'show']);
Route::put('valeurs/{id}',[ValeurController::class, 'update']);

Route::post('clients',[ClientController::class, 'store']);
Route::get('clients',[ClientController::class, 'index']);
Route::get('clients/{id}',[ClientController::class, 'show']);
Route::put('clients/{id}',[ClientController::class, 'update']);

Route::post('prestations',[PrestationController::class, 'store']);
Route::get('prestations',[PrestationController::class, 'index']);
Route::get('prestations/{id}',[PrestationController::class, 'show']);
Route::put('prestations/{id}',[PrestationController::class, 'update']);


Route::post("users", [AuthController::class,'create_use']);
Route::post("login", [AuthController::class,'user_login']);
Route::post('/documents', [DocumentController::class,'store']);
Route::delete('personnes/{id}',[PersonneController::class, 'destroy']);




Route::get('/return-valeur/{parametre_id}', [ValeurController::class, 'return_valeurs']);
Route::get('personne/{id}/carte', [PersonneController::class, 'generateCard']);
Route::post('/documents/{id}', [DocumentController::class, 'update']);

// Route::get('/personne/{id}/fonctions',
// [PersonneFonctionController::class,'index']);

Route::post('/personne-fonction',
[EmploiController::class,'store_fonction_personne']);

Route::delete('/personne-fonction/{id}',
[EmploiController::class,'destroy_fonction_personne']);
// // Login API
// Route::post('/login', function (Request $request) {
//     $user = User::where('email', $request->email)->first();

//     if (! $user || ! Hash::check($request->password, $user->password)) {
//         return response()->json(['message' => 'Invalid credentials'], 401);
//     }

//     $token = $user->createToken('api-token')->plainTextToken;

//     return response()->json(['token' => $token]);
// });

// Logout
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out']);
});
