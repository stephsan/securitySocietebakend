<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'matricule' => $this->matricule,
            'date_de_naiss' => format_date($this->date_de_naiss),
            'date_embauche' => format_date($this->date_embauche),
             "image_url"=>$this->image_url,
            'documents' => $this->documents->map(function ($doc) {
                return [
                    'doc_id' => $doc->id,
                    'type_document' => $doc->valeur?->libelle,
                    'download_url' => $doc->url
                        ? asset('storage/' . $doc->url)
                        : null
                ];
            }),
            'fonctions_occupees' => $this->postes_occupees->map(function ($fonction) {
                return [
                    'fonction_occupee_id' => $fonction->id,
                    'fonction_occupee' => $fonction->valeur?->libelle,
                    'date_debut' => format_date($fonction->date_debut),
                    'date_fin' => $fonction->date_fin?format_date($fonction->date_fin):null,
                ];
            })

            
        ];
    }
}
