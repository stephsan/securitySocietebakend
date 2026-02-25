<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValeurResource extends JsonResource
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
            'libelle' => $this->libelle,

            'parametre' => [
                'id' => $this->parametre?->id,
                'libelle' => $this->parametre?->libelle,
            ],

            'parent' => $this->parent ? [
                'id' => $this->parent->id,
                'libelle' => $this->parent->libelle,
            ] : null,
        ];
    }
}
