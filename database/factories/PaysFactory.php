<?php

namespace Database\Factories;

use App\Models\Indicatif;
use App\Models\Pays;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pays>
 */
class PaysFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pays::class;

    /**
     * Static array of country data.
     *
     * @var array
     */


    public function definition(): array
    {
        return [
            'libelle' => $this->faker->unique()->country, // Génère un nom de pays
            'indicatif' => $this->faker->unique()->numberBetween(1, 999), // Génère un indicatif téléphonique aléatoire
            'drapeau' => $this->faker->unique()->imageUrl(640, 480, 'flags', true), // Génère une URL d'image aléatoire pour un drapeau
        ];
    }
}
