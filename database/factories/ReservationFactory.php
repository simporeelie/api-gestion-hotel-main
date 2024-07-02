<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Hotel;
use App\Models\Chambre;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use App\Models\MotifReservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['appel', 'en_ligne', 'presentiel'];

        $client = User::inRandomOrder()->where('role', null)->first();
        $agent = User::inRandomOrder()->where('role', 'agent')->first();
        $motifReservation = MotifReservation::inRandomOrder()->first();
        $hotel = Hotel::inRandomOrder()->first();

        return [
            'nb_adulte' => $this->faker->numberBetween(1, 3),
            'nb_enfant' => $this->faker->numberBetween(0, 4),
            'dateArrive' => Carbon::instance($this->faker->dateTimeBetween('now', '+1 year'))->format('Y-m-d'),
            'dateDepart' => Carbon::instance($this->faker->dateTimeBetween('+2 days', '+1 year'))->format('Y-m-d'),
            'numConfirmation' => $this->faker->unique()->numberBetween(1000, 99999),
            'demandes_particuliere' => $this->faker->optional()->text(),
            'client_id' => $client->id,
            'agent_reception_id' => $agent->id,
            'charger_suivie_id' => $agent->id,
            'motif_reservation_id' => $motifReservation->id,
            'type' => $this->faker->randomElement($types),
            'hotel_id' => $hotel->id,
        ];
    }

    private function setTypeState(string $type, ?int $agentId = null): array
    {
        return [
            'type' => $type,
            'agent_reception_id' => $agentId
        ];
    }

    public function appel()
    {
        return $this->state(fn (array $attributes) => $this->setTypeState('appel'));
    }

    public function enLigne()
    {
        return $this->state(fn (array $attributes) => $this->setTypeState('en_ligne', null));
    }

    public function presentiel()
    {
        return $this->state(fn (array $attributes) => $this->setTypeState('presentiel'));
    }

    public function configure()
    {
        return $this->afterCreating(function (Reservation $reservation) {
            $reservation->chambres()->attach(
                // Chambre::all()->random(rand(1, 3))->pluck('id')->toArray()
                $reservation->hotel->directeurHotel->chambres->random(rand(1, 3))->pluck('id')->toArray()
            );

            foreach ($reservation->chambres as $chambre) {
                $chambre->update(['disponibilite' => false]);
            }

            // Statut logique
            $dateDepart = Carbon::parse($reservation->dateDepart);
            if ($dateDepart < now()) {
                $reservation->statut = 'confirmee';
            }
        });
    }
}
