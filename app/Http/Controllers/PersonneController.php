<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonneResource;
use App\Models\Personne;
use App\Models\PieceJointe;
use App\Models\TempImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
class PersonneController extends Controller
{
    public function index(Request $request){
        $personnes=Personne::orderBy('created_at','DESC');
        if(!empty($request->keyword)){
            $personnes=$personnes->where('prenom','like','%'.$request->keyword.'%');
        }
        $personnes=$personnes->get();
        return response([
            "status"=>true,
            "data"=>$personnes
        ]);

    }
    public function store(Request $request){
       $validator= Validator::make($request->all(), [
            'nom'=>'required|min:3',
            'prenom'=>'required|min:5'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Corriger l'erreur ",
                'errors'=>$validator->errors()
            ]);
        }
            $personne=Personne::create([
                'matricule' => $request->matricule,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_de_naiss' => $request->date_de_naiss,
                'date_embauche' => $request->date_embauche,
            ]);
            //Stocker image 
        $tempImage=TempImage::find($request->image_id);
        if($tempImage!= null){
            //creer un tableau a partir de .
            $imageExtArray= explode('.',$tempImage->name);
            $ext = last($imageExtArray);
            $imageName=time().'-'.$personne->id.'.'.$ext;
            $personne->image=$imageName;
            $personne->save();
            //copier image dans le repertoire personne
            $sourcePath= public_path('uploads/temp/'.$tempImage->name);
            $destPath= public_path('uploads/image_personne/'.$imageName);
            File::copy($sourcePath,$destPath);
        }
        if ($request->has('documents')) {

            foreach ($request->documents as $valeurId => $file) {
    
                $path = $file->store('documents', 'public');
                PieceJointe::create([
                    'personne_id'=>$personne->id,
                    'type_document'=>$valeurId,
                    'url'=>$path
                 ]);
            }
        }
    //     foreach ($request->documents as $doc) {

    //         $path = $doc['file']->store('documents','public');
         
    //         PieceJointe::create([
    //            'personne_id'=>$personne->id,
    //            'type_document'=>$doc['type'],
    //            'url'=>$path
    //         ]);


        
    // }

    return response()->json([
        'status'=>true,
        'message'=>"Enregistrement fait avec success ",
        'data'=>$personne
    ]);
}
    public function show($id){
        $personne= Personne::find($id);
        if($personne){
            return response()->json([
                'status'=>true,
                'data'=>new PersonneResource($personne)
            ]);
        }
       else{
            return response()->json([
                'status'=>false,
                'message'=>"Aucune personne retouvée dans la base ",
            ]);
        }
    }
    public function update($id,Request $request){
        $personne = Personne::find($id);
        if($personne==null){
            return response()->json([
                'status'=>false,
                'message'=>"Accune personne retrouvee dans la base de données",
            ]);
        }
        $validator= Validator::make($request->all(), [
            'nom'=>'required|min:3',
            'prenom'=>'required|min:5'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>false,
                'message'=>"Corriger l'erreur ",
                'errors'=>$validator->errors()
            ]);
        }
            $personne->update([
                'matricule' => $request->matricule,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_de_naiss' => $request->date_de_naiss,
                'date_embauche' => $request->date_embauche,
            ]);
            $tempImage=TempImage::find($request->image_id);
            if($tempImage!= null){
                //Supprimer l'ancien fichier 
                File::delete(public_path('uploads/image_personne/'.$personne->image));
                //creer un tableau a partir de .
                $imageExtArray= explode('.',$tempImage->name);
                $ext = last($imageExtArray);
                $imageName=time().'-'.$personne->id.'.'.$ext;
                $personne->image=$imageName;
                $personne->save();
                //copier image dans le repertoire personne
                $sourcePath= public_path('uploads/temp/'.$tempImage->name);
                $destPath= public_path('uploads/image_personne/'.$imageName);
                File::copy($sourcePath,$destPath);
            }
            return response()->json([
                'status'=>true,
                'message'=>"Modification faite avec success ",
                'data'=>$personne
            ]);
    }
    public function destroy($id){
        $personne=Personne::find($id);
        if($personne==null){
            return response()->json([
                'status'=>false,
                'message'=>"Aucune personne retouvée dans la base ",
            ]);
        }
        //Supprimer le image d'abord
        File::delete(public_path('upload/image_personne/'.$personne->image));
        $personne->delete();
        return response()->json([
            'status'=>true,
            'message'=>"Suppression faite avec success ",
        ]);

    }
    public function generateCard($id)
    {
        $person = Personne::findOrFail($id);
        $pdf = Pdf::loadView('pdf.carte_professionelle', compact('person'))
            ->setPaper([0, 0, 242.65, 153.5]); 
        return $pdf->download('carte_professionnelle_'.$person->matricule.'.pdf');
       
    }
}
