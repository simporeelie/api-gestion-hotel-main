<?php

namespace App\Http\Resources\Sejour;

use App\Http\Resources\ModePaiement\ModePaiementResource;
use App\Http\Resources\Reservation\ReservationResource;
use App\Http\Resources\Service\ServiceResource;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SejourResource extends JsonResource
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
            'reservation' => new ReservationResource($this->reservation),
            'dateArrive' => $this->dateArrive,
            'dateDepart' => $this->dateDepart,
            'montantHT' => $this->montantHT,
            'montantTTC' => $this->montantTTC,
            'montantRecus' => $this->montantRecus,
            'mode_paiement' => new ModePaiementResource($this->modePaiement),
            'agent' => new UserResource($this->creerPar),
            'supprimer_par' => new UserResource($this->supprimerPar),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'services' =>  ServiceResource::collection($this->services)
        ];
    }
}
