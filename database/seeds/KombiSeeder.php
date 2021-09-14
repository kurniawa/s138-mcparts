<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KombiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kombi = [[
            'nama' => 'Kombinasi Sayap Warna(A) Motif + LG + jht.Kepala',
            'id' => 1,
            'harga' => 20500
        ], [
            'nama' => 'Kombinasi Warna Japstyle + jht.Kepala',
            'id' => 2,
            'harga' => 20000
        ], [
            'nama' => 'Kombinasi List Miring + LG',
            'id' => 3,
            'harga' => 17000
        ], [
            'nama' => 'Kombinasi Warna X-Ride(L) + Rotan Warna',
            'id' => 4,
            'harga' => 27500
        ], [
            'nama' => 'Kombinasi Warna X-Ride(L) + Benang Warna',
            'id' => 5,
            'harga' => 26500
        ], [
            'nama' => 'Motif Sixpack 2 Warna + jht.Univ',
            'id' => 6,
            'harga' => 27500
        ], [
            'nama' => 'Motif Sixpack 2 Warna uk.JB + jht.JB',
            'id' => 7,
            'harga' => 34500
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
