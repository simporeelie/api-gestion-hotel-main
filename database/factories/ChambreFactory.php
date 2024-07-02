<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Chambre;
use App\Models\TypeChambre;
use App\Models\OptionChambre;
use App\Models\ContenuChambre;
use App\Models\EquipementChambre;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChambreFactory extends Factory
{
    protected $model = Chambre::class;

    public function definition()
    {
        return [
            'type_chambre_id' => TypeChambre::inRandomOrder()->first()->id,
            'disponibilite' => $this->faker->boolean,
            'taille' => $this->faker->numberBetween(10, 100),
            'numero' => $this->faker->numberBetween(0, 100),
            'hotel_id' => Hotel::inRandomOrder()->first()->id,
            'directeur_hotel_id' => User::inRandomOrder()->where('role', 'directeur_hotel')->first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Chambre $chambre) {
            $chambre->equipements()->attach(
                EquipementChambre::all()->random(rand(1, 3))->pluck('id')->toArray()
            );
            $chambre->contenus()->attach(
                ContenuChambre::all()->random(rand(1, 3))->pluck('id')->toArray()
            );
            $chambre->options()->attach(
                OptionChambre::all()->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
