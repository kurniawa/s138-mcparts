<?php

use App\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            PelangganSeeder::class,
            EkspedisiSeeder::class,
            PelangganEkspedisiSeeder::class,
            BahanSeeder::class,
            VariasiSeeder::class,
            UkuranSeeder::class,
            JahitSeeder::class,
            KombiSeeder::class,
            SPJapsSeeder::class,
            StandarSeeder::class,
            TankpadSeeder::class,
            BusastangSeeder::class,
            StikerSeeder::class,
            SiteSettingSeeder::class,
            ProdukSeeder::class,
            SpkSeeder::class,
        ]);
    }
}
