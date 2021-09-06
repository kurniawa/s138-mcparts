<?php

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
            PelangganSeeder::class,
            EkspedisiSeeder::class,
            BahanSeeder::class,
            VariasiSeeder::class,
            UkuranSeeder::class,
            JahitSeeder::class
        ]);
    }
}
