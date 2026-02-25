<?php

namespace App\Http\Controllers;

use App\Models\TempImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TempImageControler extends Controller
{
   public function store(Request $request){
    $validator= Validator::make($request->all(), [
        'image'=>'required|image',
    ]);
    if($validator->fails())
    {
        return response()->json([
            'status'=>false,
            'message'=>"Corriger l'erreur ",
            'errors'=>$validator->errors()
        ]);
    }
     $image=$request->image;
     $ext=$image->getClientOriginalExtension();
     $imageName= time().'.'.$ext;
    $imageTemp= TempImage::create([
        'name'=>$imageName
     ]);
     //Deplacer l'image 
     $image->move(public_path('uploads/temp'),$imageName);
     return response()->json([
        'status'=>true,
        'message'=>"Enregistrement fait avec success ",
        'image'=>$imageTemp
    ]);
   }
   
}
