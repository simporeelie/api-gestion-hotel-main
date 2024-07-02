<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\MotifReservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class MotifReservationFactory extends Factory
{
    protected $model = MotifReservation::class;

    public function definition()
    {
        $libelles = [
            'Vacances',
            'Voyage d\'affaires',
            'Week-end romantique',
            'Visite touristique',
            'Evénement spécial',
            'Séjour en famille',
            'Voyage de noces',
            'Détente et bien-être',
            'Aventure et découverte',
            'Autre'
        ];

        return [
            'libelle' => $this->faker->randomElement($libelles),
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }
}
