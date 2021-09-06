<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UkuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // UKURAN SEEDER

        $ukuran = [
            [
                'id' => 1,
                'nama' => 'JB 93x53',
                'nama_nota' => 'JB',
                'harga' => 4000
            ],
            [
                'id' => 2,
                'nama' => 'S-JB 97x53',
                'nama_nota' => 'S-JB',
                'harga' => 5500
            ], [
                'id' => 3,
                'nama' => 'Aerox',
                'nama_nota' => 'Aerox',
                'harga' => 5500
            ]
        ];
        for ($i = 0; $i < count($ukuran); $i++) {
            DB::table('ukurans')->insert([
                'nama' => $ukuran[$i]['nama'],
                'nama_nota' => $ukuran[$i]['nama_nota']
            ]);
            DB::table('ukuran_harga')->insert([
                'ukuran_id' => $ukuran[$i]['id'],
                'harga' => $ukuran[$i]['harga']
            ]);
        }
    }
}
