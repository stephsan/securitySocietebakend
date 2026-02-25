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
            'code_client' => $this->code_client
        ];
    }
}
