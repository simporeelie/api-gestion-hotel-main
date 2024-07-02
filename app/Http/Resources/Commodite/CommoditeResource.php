<?php

namespace App\Http\Resources\Commodite;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommoditeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'directeur_hotel' => new UserResource($this->creerPar),
            'supprimer_par' => new UserResource($this->suprimerPar),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
