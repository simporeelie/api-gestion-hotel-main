<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TypeClient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin
        $admin = User::factory()->create([
            'admin_id' => null,
            'directeur_hotel_id' => null,
            'type_client_id' => null,
            'statut' => null,
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ]);

        // Create 20 directeur hotels, ensuring the first one has a specific email
        $directeurHotel = User::factory()->create([
            'admin_id' => $admin->id,
            'type_client_id' => null,
            'statut' => null,
            'email' => 'directeur@gmail.com',
            'role' => 'directeur_hotel'
        ]);

        $directeurHotels = User::factory(19)->create([
            'admin_id' => $admin->id,
            'type_client_id' => null,
            'statut' => null,
            'role' => 'directeur_hotel'
        ])->prepend($directeurHotel);

        // Create 80 agents, ensuring the first one has a specific email
        $agent = User::factory()->create([
            'directeur_hotel_id' => $directeurHotel->id,
            'type_client_id' => null,
            'statut' => null,
            'email' => 'agent@gmail.com',
            'role' => 'agent'
        ]);

        $agents = User::factory(79)->create([
            'directeur_hotel_id' => $directeurHotels->random()->id,
            'type_client_id' => null,
            'statut' => null,
            'role' => 'agent'
        ])->prepend($agent);

        // Ensure each group of 10 agents is assigned to the same directeur_hotel
        $agentsPerDirector = 10;
        foreach ($directeurHotels as $super_key => $directeurHotel) {
            $agentsSubset = $agents->slice($super_key * $agentsPerDirector, $agentsPerDirector);
            foreach ($agentsSubset as $agent) {
                $agent->update(['directeur_hotel_id' => $directeurHotel->id]);
            }
        }

        // Create 200 clients, ensuring the first one has a specific email
        $client = User::factory()->sequence(
            ['password' => null],
            ['password' => Hash::make('password')]
        )->sequence(
            ['agent_id' => $agents->random()->id],
            ['agent_id' => null]
        )->create([
            'role' => null,
            'email' => 'client@gmail.com',
        ]);

        $clients = User::factory(199)->sequence(
            ['password' => null],
            ['password' => Hash::make('password')]
        )->sequence(
            ['agent_id' => $agents->random()->id],
            ['agent_id' => null]
        )->create([
            'admin_id' => null,
            'directeur_hotel_id' => null,
            'role' => null,
        ])->prepend($client);

        $clientsPerAgent = 10;
        foreach ($agents as $super_key => $agent) {
            $clientsSubset = $clients->slice($super_key * $clientsPerAgent, $clientsPerAgent);
            foreach ($clientsSubset as $client) {
                $client->update(['agent_id' => $agent->id]);
            }
        }

        // Update typeClients with random directeur_hotel_id
        $typeClients = TypeClient::all();

        foreach ($directeurHotels as $key => $directeurHotel) {
            $typeClients[$key]->update([
                'directeur_hotel_id' => $directeurHotels->random()->id,
            ]);
        }
    }
}
