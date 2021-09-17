<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TankpadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kombi = [[
            'nama' => 'Bull Dimensi',
            'id' => 1,
            'harga' => 5500
        ], [
            'nama' => 'Bull Hitam',
            'id' => 2,
            'harga' => 4500
        ], [
            'nama' => 'Dainese Dimensi',
            'id' => 3,
            'harga' => 5500
        ], [
            'nama' => 'Dainese Hitam',
            'id' => 4,
            'harga' => 4500
        ], [
            'nama' => 'Fox Dimensi',
            'id' => 5,
            'harga' => 5500
        ], [
            'nama' => 'Fox Hitam',
            'id' => 6,
            'harga' => 4500
        ], [
            'nama' => 'Garuda Dimensi',
            'id' => 7,
            'harga' => 5500
        ]];

        for ($i = 0; $i < count($kombi); $i++) {
            DB::table('kombis')->insert([
                'nama' => $kombi[$i]['nama'],
            ]);
            DB::table('kombi_harga')->insert([
                'kombi_id' => $kombi[$i]['id'],
                'harga' => $kombi[$i]['harga']
            ]);
        }
    }
}
