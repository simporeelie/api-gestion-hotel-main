<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\MotifReservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MotifReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libelles = [
            'Vacances',
            'Voyage d\'affaires',
            'Week-end romantique',
            'Visite touristique',
            'Evénement spécial',
            'Séjour en famille',
            'Voyage de noces',
            'Détente et bien-être',
            'Aventure et découverte',
            'Autre'
        ];


        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            for ($i = 0; $i < rand(6, 10); $i++) {

                MotifReservation::factory()->create(
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
