<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TypeChambre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeChambreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directeursHotel = User::where('role', 'directeur_hotel')->get();

        foreach ($directeursHotel as $directeurHotel) {
            // Create 5 VIP rooms
            TypeChambre::factory()->vip()->count(5)->create([
                'directeur_hotel_id' => $directeurHotel->id,
                'hotel_id' => $directeurHotel->hotel_id
            ]);

            // Create 10 non-VIP rooms
            TypeChambre::factory()->nonVip()->count(10)->create([
                'directeur_hotel_id' => $directeurHotel->id,
                'hotel_id' => $directeurHotel->hotel_id
            ]);
        }
    }
}
