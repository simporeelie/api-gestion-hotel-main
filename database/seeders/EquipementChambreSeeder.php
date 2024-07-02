<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\EquipementChambre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EquipementChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        static $libelles = [
            'téléphone international direct',
            'TV satellite',
            'un réfrigérateur',
            'réveil automatique',
            'lits jumeaux',
            'canapés convertibles',
            'bureau',
            'chaises',
            'tables',
            'micro-ondes'
        ];

        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            for ($i = 0; $i < rand(6, 10); $i++) {

                EquipementChambre::factory()->create(
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
