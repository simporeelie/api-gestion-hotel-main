<?php

namespace Database\Factories;

use App\Models\CategorieHotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategorieHotel>
 */
class CategorieHotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CategorieHotel::class;

    // Créez une propriété statique pour suivre les valeurs utilisées
    protected static $libelles = ['1', '2', '3', '4', '5'];


    public function definition(): array
    {
        // Sélectionner et retirer une valeur unique de la liste
        $libelle = array_pop(static::$libelles);
        return [
            'libelle' => $libelle,
            'admin_id' => 1
        ];
    }
}
