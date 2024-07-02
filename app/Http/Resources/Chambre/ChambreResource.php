<?php

namespace App\Http\Resources\Chambre;

use App\Http\Resources\ContenuChambre\ContenuChambreResource;
use App\Http\Resources\EquipementChambre\EquipementChambreResource;
use App\Http\Resources\Hotel\HotelResource;
use App\Http\Resources\OptionChambre\OptionChambreResource;
use App\Http\Resources\TypeChambre\TypeChambreResource;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChambreResource extends JsonResource
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
            'disponibilite' => $this->disponibilite,
            'taille' => $this->taille,
            'prix' => $this->prix(),
            'numero' => $this->numero,
            'type_chambre' => new TypeChambreResource($this->typeChambre),
            'equipements' => EquipementChambreResource::collection($this->equipements),
            'options' => OptionChambreResource::collection($this->options),
            'contenus' => ContenuChambreResource::collection($this->contenus),
            'directeur_hotel' => new UserResource($this->creerPar),
            'supprimer_par' => new UserResource($this->supprimerPar),
            "hotel" => new HotelResource($this->hotel),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
