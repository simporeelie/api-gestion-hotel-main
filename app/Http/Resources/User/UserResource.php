<?php

namespace App\Http\Resources\User;

use App\Http\Resources\PaysResource;
use App\Http\Resources\TypeClient\TypeClientResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        // dump($this->creerPar);
        return [
            'id' => $this->id,
            'supprimer_par' => new UserResource($this->supprimerPar),
            'admin' => $this->when($this->isAdmin() || $this->isDirecteurHotel(), $this->creerPar),
            'agent' => $this->when($this->isClient(), $this->creerPar),
            'directeur_hotel' => $this->when($this->isAgent(), $this->creerPar),
            'pays_naissance' => $this->whenLoaded('paysNaissance',  $this->paysNaissance),
            'pays_residence' => $this->whenLoaded('paysResidence',  $this->paysResidence),
            'type_client' => $this->whenLoaded('typeClient',  $this->typeClient),
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'genre' => $this->genre,
            'ref_piece' => $this->ref_piece,
            'dateNaissance' => $this->dateNaissance,
            'statut' => $this->statut,
            'role' => $this->role,
            'password' => $this->password,
            'ville' => $this->ville,
            'region' => $this->region,
            'rue' => $this->rue,
            'telephone' => $this->telephone,
            'code_postale' => $this->code_postale,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
