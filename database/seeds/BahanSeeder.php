<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kombinasi = ['Kombinasi Sayap Warna Motif A + LG + jht Univ'];
        $standar = ["RXK'95 Jet Darat"];
        $busastang = ["Busastang"];

        // BAHAN SEEDER
        // BAHAN_HARGA SEEDER

        $bahan = [[
            'nama' => 'Amplas(RY)',
            'id' => 1,
            'harga' => 15000
        ], [
            'nama' => 'BigDot(MC)',
            'id' => 2,
            'harga' => 13000
        ], [
            'nama' => 'C30(MC)',
            'id' => 3,
            'harga' => 13000
        ], [
            'nama' => 'C38(MC)',
            'id' => 4,
            'harga' => 13000
        ], [
            'nama' => 'Carbon',
            'id' => 5,
            'harga' => 17000
        ], [
            'nama' => 'Grafitti',
            'id' => 6,
            'harga' => 13000
        ], [
            'nama' => 'K-Jeruk',
            'id' => 7,
            'harga' => 11500
        ], [
            'nama' => 'L-Hole',
            'id' => 8,
            'harga' => 10000
        ], [
            'nama' => 'Navaro(MC)',
            'id' => 9,
            'harga' => 13000
        ], [
            'nama' => 'U-Tangan(MC)',
            'id' => 10,
            'harga' => 13000
        ], [
            'nama' => 'Vario(M)',
            'id' => 11,
            'harga' => 13000
        ], [
            'nama' => 'Vario(MC)',
            'id' => 12,
            'harga' => 13000
        ]];

        for ($i = 0; $i < count($bahan); $i++) {
            DB::table('bahans')->insert([
                'nama' => $bahan[$i]['nama'],
            ]);
            DB::table('bahan_harga')->insert([
                'bahan_id' => $bahan[$i]['id'],
                'harga' => $bahan[$i]['harga']
            ]);
        }
    }
}
