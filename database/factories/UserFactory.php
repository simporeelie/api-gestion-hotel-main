<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Indicatif;
use App\Models\Pays;
use App\Models\TypeClient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'admin_id' => null,
            'directeur_hotel_id' => null,
            'hotel_id' => null,
            'agent_id' => null,
            'type_client_id' => TypeClient::inRandomOrder()->first()->id,
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'genre' => $this->faker->randomElement(['M', 'F', 'A']),
            'ref_piece' => $this->faker->ean13,
            'dateNaissance' => $this->faker->date(),
            'statut' => $this->faker->randomElement(['standard', 'invite']),
            'role' => $this->faker->randomElement(['directeur_hotel', 'agent', 'admin']),
            'password' => Hash::make('password'),
            'ville' => $this->faker->city,
            'region' => $this->faker->state,
            'rue' => $this->faker->streetName,
            'pays_naissance_id' => Pays::inRandomOrder()->first()->id,
            'pays_residence_id' => Pays::inRandomOrder()->first()->id,
            'telephone' => $this->faker->phoneNumber,
            'code_postale' => $this->faker->postcode,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
