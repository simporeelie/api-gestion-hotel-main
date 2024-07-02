<?php

namespace Database\Factories;

use id;
use App\Models\User;
use App\Models\Hotel;
use App\Models\ContenuChambre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContenuChambreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContenuChambre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $libelles = [
            'salle de bain',
            'cuisine',
            'douche',
            'espace salon',
            'lit king-size',
            'balcon',
            'vue sur la mer',
            'mini-bar',
            'coffre-fort',
            'climatisation'
        ];

        return [
            'libelle' => $this->faker->randomElement($libelles),
            // 'libelle' => array_shift($libelles),
            'prix' => $this->faker->numberBetween(100, 1000),
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }
}
