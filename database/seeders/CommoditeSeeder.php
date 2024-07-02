<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Commodite;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommoditeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static $commodite =  [
            'Wi-Fi gratuit',
            'Petit-déjeuner inclus',
            'Piscine',
            'Spa',
            'Salle de sport',
            'Service de navette',
            'Parking gratuit',
            'Restaurant',
            'Bar',
            'Service en chambre',
            'Réception ouverte 24h/24',
            'Animaux de compagnie acceptés',
            'Climatisation',
            'Chauffage',
            'Télévision',
            'Minibar',
            'Coffre-fort',
            'Bureau',
            'Vue sur la mer',
            'Vue sur la montagne',
            'Balcon',
            'Terrasse',
            'Jardin',
            'Chambres familiales',
            'Chambres non-fumeurs',
            'Accessible aux personnes à mobilité réduite',
        ];

        Commodite::factory()->count(10)->create();
        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            for ($i = 0; $i < rand(10, 20); $i++) {

                Commodite::factory()->create(
                    [
                        'libelle' => $commodite[$i],
                        'directeur_hotel_id' => $directeurHotel->id,
                        'hotel_id' =>  $directeurHotel->hotel_id
                    ]
                );
            }
        }
    }
}
