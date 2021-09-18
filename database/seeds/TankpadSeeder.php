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
        $tankpad = [[
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
        ], [
            'nama' => 'Garuda Hitam',
            'id' => 8,
            'harga' => 4500
        ], [
            'nama' => 'Harley Dimensi',
            'id' => 9,
            'harga' => 5500
        ], [
            'nama' => 'Harley Hitam',
            'id' => 10,
            'harga' => 4500
        ], [
            'nama' => 'Kitaco Dimensi',
            'id' => 11,
            'harga' => 5500
        ], [
            'nama' => 'Kitaco Hitam',
            'id' => 12,
            'harga' => 4500
        ], [
            'nama' => 'MC Dimensi',
            'id' => 13,
            'harga' => 5500
        ], [
            'nama' => 'MC Hitam',
            'id' => 14,
            'harga' => 4500
        ], [
            'nama' => 'MC Hitam Kecil',
            'id' => 15,
            'harga' => 4000
        ], [
            'nama' => 'MC Logo Timbul',
            'id' => 16,
            'harga' => 5500
        ], [
            'nama' => 'Monster Hitam',
            'id' => 17,
            'harga' => 4500
        ], [
            'nama' => 'Monster Mika/Sablon',
            'id' => 18,
            'harga' => 5500
        ], [
            'nama' => 'Racing JB Hitam',
            'id' => 19,
            'harga' => 4750
        ], [
            'nama' => 'Racing JB Mika/Sablon',
            'id' => 20,
            'harga' => 5750
        ], [
            'nama' => 'Racing Kecil Hitam',
            'id' => 21,
            'harga' => 4250
        ], [
            'nama' => 'Racing Kecil Mika/Sablon',
            'id' => 22,
            'harga' => 5250
        ], [
            'nama' => 'Yakuza Dimensi',
            'id' => 23,
            'harga' => 5500
        ], [
            'nama' => 'Yakuza Hitam',
            'id' => 24,
            'harga' => 4500
        ]];

        for ($i = 0; $i < count($tankpad); $i++) {
            DB::table('tankpads')->insert([
                'nama' => $tankpad[$i]['nama'],
            ]);
            DB::table('tankpad_harga')->insert([
                'tankpad_id' => $tankpad[$i]['id'],
                'harga' => $tankpad[$i]['harga']
            ]);
        }
    }
}
