<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\ModePaiement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModePaiement>
 */
class ModePaiementFactory extends Factory
{
    protected $model = ModePaiement::class;

    public function definition()
    {
        $modes = [
            'Carte de crédit',
            'Carte de débit',
            'Espèces',
            'Chèque',
            'Virement bancaire',
            'PayPal',
            'Apple Pay',
            'Google Pay'
        ];

        return [
            'libelle' => $this->faker->randomElement($modes),
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }
}

