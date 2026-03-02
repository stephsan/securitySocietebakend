<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrestationResource extends JsonResource
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
            'description_prestation' => $this->description_prestation,
            'detail_adresse' => $this->detail_adresse,
            'montant_min_prestation' => $this->montant_min_prestation,
            'nature' => $this->nature->libelle
        ];
    }
}
