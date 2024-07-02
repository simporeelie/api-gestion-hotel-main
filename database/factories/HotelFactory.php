<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\CategorieHotel;
use App\Models\Indicatif;
use App\Models\User;
use App\Models\Pays;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'categorie_hotel_id' => CategorieHotel::inRandomOrder()->first()->id,
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
            'libelle' => $this->faker->company,
            'photo' => $this->faker->imageUrl(640, 480, 'hotels'),
            'emplacement' => $this->faker->unique()->address,
            'email' => $this->faker->unique()->safeEmail,
            'site_web' => $this->faker->unique()->url,
            'ville' => $this->faker->city,
            'region' => $this->faker->state,
            'rue' => $this->faker->streetName,
            'code_postale' => $this->faker->unique()->postcode,
            'telephone' => $this->faker->unique()->randomNumber(8, true),
            'pays_id' => Pays::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

