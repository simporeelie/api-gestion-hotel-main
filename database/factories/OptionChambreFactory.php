<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\OptionChambre;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionChambreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OptionChambre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $libelles = [
            'Vue sur la mer',
            'Située en rez-de-chaussée',
            'Télévision avec chaînes supplémentaires',
            'Accès Wi-Fi gratuit',
            'Petit-déjeuner inclus',
            'Service de chambre 24h/24',
            'Mini-bar approvisionné',
            'Coffre-fort personnel',
            'Balcon privé',
            'Jacuzzi privé'
        ];

        return [
            // 'libelle' => array_shift($libelles),
            'libelle' => $this->faker->randomElement($libelles),
            'prix' => $this->faker->numberBetween(50, 500),
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }
}
