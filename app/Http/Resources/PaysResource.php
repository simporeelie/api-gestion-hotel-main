<?php

namespace App\Http\Resources;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaysResource extends JsonResource
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
            'drapeau' => $this->drapeau,
            'indicatif' => $this->indicatif,
            'libelle' => $this->libelle,
            'admin_id' => new UserResource($this->creerPar),
            'updated_at' => $this->updated_at
        ];
    }
}
