<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = User::whereNull('role')->get();

        foreach ($clients as $client) {
            $agents = User::where('hotel_id', $client->hotel_id)->where('role', 'agent')->get();
            $agentCount = $agents->count();

            for ($i = 0; $i < rand(1, 5); $i++) {
                Reservation::factory()->sequence(
                    [
                        'type' => 'en_ligne',
                        'agent_reception_id' => null,
                    ],
                    [
                        'type' => 'presentiel',
                        'agent_reception_id' => $agentCount > 0 ? $agents->random()->id : null,
                    ],
                    [
                        'type' => 'presentiel',
                        'agent_reception_id' => $agentCount > 0 ? $agents->random()->id : null,
                    ]
                )->create([
                    'client_id' => $client->id,
                    'charger_suivie_id' => $agentCount > 0 ? $agents->random()->id : null,
                    'hotel_id' => $client->hotel_id,
                ]);
            }
        }
    }
}
