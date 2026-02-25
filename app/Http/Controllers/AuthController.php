<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create_use(Request $request){
        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|unique:users',
            'password'=>'required',
        ]);
        $user=User::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password)
                ]);
        return response()->json([
                            'status'=>true,
                            'message'=>"Enregistrement fait avec success ",
                            'data'=>$user
                        ]);
        // if($validator->fails())
        // {
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>"Corriger l'erreur ",
        //         'errors'=>$validator->errors()
        //     ]);
        // }
        
    }
    public function user_login(Request $request){
        $validator= $request->validate( [
            'email'=>'required',
            'password'=>'required',
        ]);
       
        $user = User::where('email', $request->email)->where('password', bcrypt($request->password))->first();
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            throw ValidationException::withMessages([
                'email' => ['Paramètres de connexion incorrects.'],
            ]);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'status' => true,
            'message' => "Authentification OK",
            'token' => $token,
            'user' => $user
        ]);
    }
}
