<?php

namespace Database\Factories;

use App\Models\Tva;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Sejour;
use App\Models\Service;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\ModePaiement;
use Illuminate\Database\Eloquent\Factories\Factory;

class SejourFactory extends Factory
{
    protected $model = Sejour::class;


    public function definition()
    {
        // Sélectionnez aléatoirement une réservation existante
        $reservation = Reservation::inRandomOrder()->first();

        // Date d'arrivée doit être avant ou égale à la date d'arrivée de la réservation
        $dateArrive = $this->faker->dateTimeBetween('-1 year', $reservation->dateDepart);
        // Date de départ doit être après la date d'arrivée
        $dateDepart = $this->faker->dateTimeBetween($dateArrive, $reservation->dateDepart);

        return [
            'reservation_id' => $reservation->id,
            'dateArrive' => $dateArrive,
            'dateDepart' => $dateDepart,
            'agent_id' => User::inRandomOrder()->where('role', 'agent')->first()->id,
            'hotel_id' => Hotel::inRandomOrder()->first()->id
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Sejour $sejour) {
            // dump($sejour->reservation->chargerSuivie);
            // dump($sejour->reservation->chargerSuivie->creerPar);
            // services
            $sejour->services()->attach(
                Service::where('directeur_hotel_id', $sejour->reservation->chargerSuivie->creerPar->id)->get()->random(rand(0,5))->pluck('id')->toArray()
            );
            // montant service
            $montantHT = $sejour->services->sum('prix');
            $sejour->montantHt = $montantHT;
            $sejour->montantTTC = $montantHT * Tva::first()->taux;

            // paiement
            $sejour->montantRecus = $this->faker->numberBetween($sejour->montantTTC, $sejour->montantTTC + 1000);
            $sejour->mode_paiement_id = ModePaiement::inRandomOrder()->first()->id;
            $sejour->save();
        });
    }
}

