<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratResource extends JsonResource
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
            'numero_contrat' => $this->numero_contrat,
            'clause_particulieres' => $this->clause_particulieres,
            'denom_client' => $this->client->denomination,
            'code_client' => $this->client->code_client,
            'montant_contrat' => $this->lignes->sum('montant_prestation'),
            'lignes' => $this->lignes->map(function ($ligne) {
                return [
                    'ligne_id' => $ligne->id,
                    'quantite' => $ligne->quantite,
                    'prestation_id' => $ligne->prestation->id,
                    'prestation' => $ligne->prestation->nature->libelle,
                    'montant_unitaire' => $ligne->montant,
                    'montant_prestation' => $ligne->montant_prestation,
                ];
            }),
        ];
    }
}
