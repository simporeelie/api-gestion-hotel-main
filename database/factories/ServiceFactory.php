<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        static $libelles = [
            'Wi-Fi gratuit',
            'Petit-déjeuner inclus',
            'Piscine',
            'Service de navette',
            'Salle de sport',
            'Restaurant',
            'Bar',
            'Blanchisserie',
            'Service de chambre',
            'Parking gratuit'
        ];

        return [
            // 'libelle' => array_shift($libelles),
            'libelle' => $this->faker->randomElement($libelles),
            'prix' => $this->faker->numberBetween(0, 100), // Adjust the range as necessary
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }
}
