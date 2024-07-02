<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\TypeClient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeClient>
 */
class TypeClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TypeClient::class;

    public function definition(): array
    {
        return [
            'libelle' => $this->faker->randomElement(['occasionnels', 'fideles', 'VIP']),
            'nbReservation' => $this->faker->numberBetween(0, 100),
            'operateur' => $this->faker->randomElement(['>=', '<=', '<', '>', '=']),
            'frequense' => $this->faker->numberBetween(0, 12),
            'periode' => $this->faker->randomElement(['jour', 'semaine', 'mois', 'annee']),
            'directeur_hotel_id' => null,
            'hotel_id' => null
        ];
    }
}
