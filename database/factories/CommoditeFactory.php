<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Commodite;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommoditeFactory extends Factory
{
    protected $model = Commodite::class;

    public function definition()
    {
        $commodites = [
            'Wi-Fi gratuit',
            'Petit-déjeuner inclus',
            'Piscine',
            'Spa',
            'Salle de sport',
            'Service de navette',
            'Parking gratuit',
            'Restaurant',
            'Bar',
            'Service en chambre',
            'Réception ouverte 24h/24',
            'Animaux de compagnie acceptés',
            'Climatisation',
            'Chauffage',
            'Télévision',
            'Minibar',
            'Coffre-fort',
            'Bureau',
            'Vue sur la mer',
            'Vue sur la montagne',
            'Balcon',
            'Terrasse',
            'Jardin',
            'Chambres familiales',
            'Chambres non-fumeurs',
            'Accessible aux personnes à mobilité réduite',
        ];

        return [
            'libelle' => $this->faker->randomElement($commodites),
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }
}
