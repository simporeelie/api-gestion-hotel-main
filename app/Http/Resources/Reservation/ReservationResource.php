<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Chambre\ChambreResource;
use App\Http\Resources\MotifReservation\MotifReservationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'nb_enfant' => $this->nb_enfant,
            'nb_adulte' => $this->nb_adulte,
            'dateArrive' => $this->dateArrive,
            'dateDepart' => $this->dateDepart,
            'numConfirmation' => $this->numConfirmation,
            'type' => $this->type,
            'statut' => $this->statut,
            'demandes_particuliere' => $this->demandes_particuliere,
            'client' => new UserResource( $this->client),
            'agent_reception' => new UserResource($this->creerPar),
            'charger_suivie' => new UserResource($this->chargerSuivie),
            'motif_reservation' => new MotifReservationResource($this->motifReservation),
            'supprimer_par' => $this->supprimerPar,
            'chambres' => ChambreResource::collection($this->chambres),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
