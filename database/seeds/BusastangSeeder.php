<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusastangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $busastang = [[
            'nama' => 'Busa-Stang',
            'id' => 1,
            'harga' => 8000
        ]];

        for ($i = 0; $i < count($busastang); $i++) {
            DB::table('busastangs')->insert([
                'nama' => $busastang[$i]['nama'],
            ]);
            DB::table('busastang_harga')->insert([
                'busastang_id' => $busastang[$i]['id'],
                'harga' => $busastang[$i]['harga']
            ]);
        }
    }
}
