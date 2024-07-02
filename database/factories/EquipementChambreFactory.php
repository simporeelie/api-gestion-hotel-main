<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\EquipementChambre;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipementChambreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EquipementChambre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $libelles = [
            'téléphone international direct',
            'TV satellite',
            'un réfrigérateur',
            'réveil automatique',
            'lits jumeaux',
            'canapés convertibles',
            'bureau',
            'chaises',
            'tables',
            'micro-ondes'
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
