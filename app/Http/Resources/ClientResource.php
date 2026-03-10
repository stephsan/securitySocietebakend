<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'denomination' => $this->denomination,
            'telephone' => $this->telephone,
            'detail_adresse' => $this->detail_adresse,
            'email' => $this->email,
            'code_client' => $this->code_client,
            'numero_rccm' => $this->numero_rccm,
            'numero_ifu' => $this->numero_ifu,
            'regime_fiscal' => $this->regime_fiscal,
            'division_fiscale' => $this->code_client,
            'adresse_siege' => $this->adresse_siege,
            'section' => $this->section,
            'telephone_fixe' => $this->telephone_fixe,
            'telephone_mobile' => $this->telephone_mobile,
            'contrats' => ContratResource::collection($this->contrats),
            'factures' => $this->factures->map(function ($facture) {
                return [
                    'facture_id' => $facture->id,
                    'numero_facture' => $facture->numero_facture,
                    'numero_contrat' => $facture->contrat->numero_contrat,
                    'date_debut'=>format_date($facture->date_debut),
                    'date_fin'=>format_date($facture->date_fin),
                    'montant_total' => $facture->montant_total,
                ];
            }),
        ];
    }
}
