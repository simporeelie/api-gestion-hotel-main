<?php

namespace App\Http\Resources\CategorieHotel;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieHotelResource extends JsonResource
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
            'admin' => new UserResource($this->admin),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
