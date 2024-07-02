<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Chambre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directeruHotels = User::where('role', 'directeur_hotel')->get();

        // dd($directeruHotels);

        foreach($directeruHotels as $directeruHotel){
            for ($i=0; $i < 10; $i++) {
                Chambre::factory()->create([
                    'numero' => $i,
                    'directeur_hotel_id' => $directeruHotel->id,
                    'hotel_id' => $directeruHotel->hotel_id
                ]);
            }
        }
    }
}
