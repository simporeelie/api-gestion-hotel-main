<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContenuChambre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContenuChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static $libelles = [
            'salle de bain',
            'cuisine',
            'douche',
            'espace salon',
            'lit king-size',
            'balcon',
            'vue sur la mer',
            'mini-bar',
            'coffre-fort',
            'climatisation'
        ];

        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            for ($i = 0; $i < rand(6, 10); $i++) {

                ContenuChambre::factory()->create(
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
