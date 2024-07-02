<?php

namespace Database\Seeders;

use App\Models\Pays;
use App\Models\User;
use App\Models\Hotel;
use App\Models\TypeClient;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HotelSeeder extends Seeder
{
    private $burkinaFasoAddresses = [
        ['region' => 'Centre', 'ville' => 'Ouagadougou', 'rue' => 'Rue de l\'Université', 'code_postale' => '01BP1234'],
        ['region' => 'Centre', 'ville' => 'Ouagadougou', 'rue' => 'Avenue de l\'Indépendance', 'code_postale' => '01BP5678'],
        ['region' => 'Hauts-Bassins', 'ville' => 'Bobo-Dioulasso', 'rue' => 'Boulevard de la Révolution', 'code_postale' => '02BP1234'],
        ['region' => 'Hauts-Bassins', 'ville' => 'Bobo-Dioulasso', 'rue' => 'Rue du Commerce', 'code_postale' => '02BP5678'],
        ['region' => 'Centre-Ouest', 'ville' => 'Koudougou', 'rue' => 'Rue de la Liberté', 'code_postale' => '03BP1234'],
        ['region' => 'Centre-Ouest', 'ville' => 'Koudougou', 'rue' => 'Avenue des Nations', 'code_postale' => '03BP5678'],
        ['region' => 'Cascades', 'ville' => 'Banfora', 'rue' => 'Rue de l\'Hôtel de Ville', 'code_postale' => '04BP1234'],
        ['region' => 'Cascades', 'ville' => 'Banfora', 'rue' => 'Avenue de la Cascade', 'code_postale' => '04BP5678'],
        ['region' => 'Nord', 'ville' => 'Ouahigouya', 'rue' => 'Rue de la Résidence', 'code_postale' => '05BP1234'],
        ['region' => 'Nord', 'ville' => 'Ouahigouya', 'rue' => 'Avenue de l\'Armée', 'code_postale' => '05BP5678'],
        ['region' => 'Centre-Sud', 'ville' => 'Pô', 'rue' => 'Rue de la Préfecture', 'code_postale' => '06BP1234'],
        ['region' => 'Centre-Sud', 'ville' => 'Pô', 'rue' => 'Avenue des Martyrs', 'code_postale' => '06BP5678'],
        ['region' => 'Centre-Est', 'ville' => 'Tenkodogo', 'rue' => 'Rue du Marché', 'code_postale' => '07BP1234'],
        ['region' => 'Centre-Est', 'ville' => 'Tenkodogo', 'rue' => 'Avenue de la Paix', 'code_postale' => '07BP5678'],
        ['region' => 'Sahel', 'ville' => 'Dori', 'rue' => 'Rue des Sables', 'code_postale' => '08BP1234'],
        ['region' => 'Sahel', 'ville' => 'Dori', 'rue' => 'Avenue du Désert', 'code_postale' => '08BP5678'],
        ['region' => 'Sud-Ouest', 'ville' => 'Gaoua', 'rue' => 'Rue des Guerriers', 'code_postale' => '09BP1234'],
        ['region' => 'Sud-Ouest', 'ville' => 'Gaoua', 'rue' => 'Avenue de la Victoire', 'code_postale' => '09BP5678'],
        ['region' => 'Est', 'ville' => 'Fada N\'Gourma', 'rue' => 'Rue de la Liberté', 'code_postale' => '10BP1234'],
        ['region' => 'Est', 'ville' => 'Fada N\'Gourma', 'rue' => 'Avenue de la Gare', 'code_postale' => '10BP5678'],
    ];
    /**
     * 01BP1234
     * Rue de l'Université
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Fetch directeur_hotel users and create hotels
        $directeursHotel = User::where('role', 'directeur_hotel')->get();
        $hotels = collect();


        foreach ($directeursHotel as $key => $directeurHotel) {
            $address = $this->burkinaFasoAddresses[$key];
            $hotels->push(Hotel::factory()->create([
                'emplacement' => "{$address['rue']}, {$address['code_postale']}, {$address['ville']}, {$address['region']}",
                'ville' => $address['ville'],
                'region' => $address['region'],
                'rue' => $address['rue'],
                'code_postale' => $address['code_postale'],
                'pays_id' => Pays::where('indicatif', '+226')->where('libelle', 'Burkina Faso')->get()->first()->id,
                'directeur_hotel_id' => $directeurHotel->id
            ]));
        }


        // Step 2: Assign directeur_hotel users to hotels
        $directeurHotelPerHotel = 1;
        foreach ($hotels as $super_key => $hotel) {
            $directeursHotelSubset = $directeursHotel->slice($super_key * $directeurHotelPerHotel, $directeurHotelPerHotel);
            foreach ($directeursHotelSubset as $directeurHotel) {
                $directeurHotel->update(['hotel_id' => $hotel->id]);
            }
        }

        // Step 3: Assign agent users to hotels
        $agents = User::where('role', 'agent')->get();
        $agentPerHotel = 4;
        foreach ($hotels as $super_key => $hotel) {
            $agentsSubset = $agents->slice($super_key * $agentPerHotel, $agentPerHotel);
            foreach ($agentsSubset as $agent) {
                $agent->update(['hotel_id' => $hotel->id]);
            }
        }

        // Step 4: Assign clients (users with no role) to hotels
        $clients = User::whereNull('role')->get();
        $clientPerHotel = 10;
        foreach ($hotels as $super_key => $hotel) {
            $clientsSubset = $clients->slice($super_key * $clientPerHotel, $clientPerHotel);
            foreach ($clientsSubset as $client) {
                $client->update(['hotel_id' => $hotel->id]);
            }
        }

        // Step 5: Assign typeClients to hotels
        $typeClients = TypeClient::all();
        foreach ($typeClients as $key => $typeClient) {
            if (isset($hotels[$key])) {
                $typeClient->update([
                    'hotel_id' => $hotels[$key]->id
                ]);
            }
        }
    }
}
