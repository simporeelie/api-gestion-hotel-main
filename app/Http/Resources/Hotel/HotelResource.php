<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'categorie_hotel' => $this->whenLoaded('categorieHotel', $this->categorieHotel),
            'directeur_hotel' => $this->whenLoaded('directeurHotel', $this->directeurHotel),
            'libelle' => $this->libelle,
            'photo' => $this->photo,
            'emplacement' => $this->emplacement,
            'email' => $this->email,
            'site_web' => $this->site_web,
            'ville' => $this->ville,
            'region' => $this->region,
            'rue' => $this->rue,
            'code_postale' => $this->code_postale,
            'telephone' => $this->telephone,
            'pays' => $this->whenLoaded('pays', $this->pays),
            'supprimer_par' => $this->whenLoaded('supprimerPar', $this->supprimerPar),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
