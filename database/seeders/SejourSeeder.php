<?php

namespace Database\Seeders;

use App\Models\Sejour;
use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SejourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Select all reservations randomly
        $reservations = Reservation::inRandomOrder()->get();

        foreach ($reservations as $reservation) {
            $dateArrive = Carbon::parse($reservation->dateArrive)->addDays(rand(0, 5));
            $dateDepart = Carbon::parse($dateArrive)->addDays(rand(1, 10));

            Sejour::factory()->create([
                'reservation_id' => $reservation->id,
                'dateArrive' => $dateArrive,
                'dateDepart' => $dateDepart,
                'hotel_id' => $reservation->hotel_id
            ]);
        }
    }
}
