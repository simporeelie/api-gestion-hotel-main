<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Indicatif;
use App\Models\Telephone;
use Illuminate\Database\Seeder;
use App\Models\MotifReservation;
use Database\Seeders\PaysSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\HotelSeeder;
use Database\Seeders\ChambreSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\CommoditeSeeder;
use Database\Seeders\TypeClientSeeder;
use Database\Seeders\ReservationSeeder;
use Database\Seeders\TypeChambreSeeder;
use Database\Seeders\CategorieHotelSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TvaSeeder::class,
            PaysSeeder::class,
            TypeClientSeeder::class,
            UserSeeder::class,
            CategorieHotelSeeder::class,
            HotelSeeder::class,
            ServiceSeeder::class,
            CommoditeSeeder::class,
            TypeChambreSeeder::class,
            ContenuChambreSeeder::class,
            OptionChambreSeeder::class,
            EquipementChambreSeeder::class,
            ChambreSeeder::class,
            MotifReservationSeeder::class,
            ReservationSeeder::class,
            ModePaiementSeeder::class,
            SejourSeeder::class
        ]);
    }
}
