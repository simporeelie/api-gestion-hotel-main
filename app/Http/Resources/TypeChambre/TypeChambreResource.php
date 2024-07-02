<?php

namespace App\Http\Resources\TypeChambre;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeChambreResource extends JsonResource
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
            'prix' => $this->prix,
            'nb_enfant' => $this->nb_enfant,
            'nb_adulte' => $this->nb_adulte,
            'isVip' => $this->isVip,
            'directeur_hotel' => new UserResource($this->creerPar),
            'supprimer_par' => new UserResource($this->supprimerPar),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
