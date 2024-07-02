<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static $libelles = [
            'Wi-Fi gratuit',
            'Petit-déjeuner inclus',
            'Piscine',
            'Service de navette',
            'Salle de sport',
            'Restaurant',
            'Bar',
            'Blanchisserie',
            'Service de chambre',
            'Parking gratuit'
        ];

        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            for ($i = 0; $i < rand(6, 10); $i++) {

                Service::factory()->create(
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
