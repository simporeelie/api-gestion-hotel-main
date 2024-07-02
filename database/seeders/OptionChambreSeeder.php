<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\OptionChambre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OptionChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static $libelles = [
            'Vue sur la mer',
            'Située en rez-de-chaussée',
            'Télévision avec chaînes supplémentaires',
            'Accès Wi-Fi gratuit',
            'Petit-déjeuner inclus',
            'Service de chambre 24h/24',
            'Mini-bar approvisionné',
            'Coffre-fort personnel',
            'Balcon privé',
            'Jacuzzi privé'
        ];


        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            for ($i = 0; $i < rand(6, 10); $i++) {

                OptionChambre::factory()->create(
                    [
                        'libelle' => $libelles[$i],
                        'directeur_hotel_id' => $directeurHotel->id,
                        'hotel_id' =>  $directeurHotel->hotel_id
                    ]
                );
            }
        }
    }
}
