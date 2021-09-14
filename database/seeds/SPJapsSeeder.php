<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SPJapsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spjap = [[
            'nama' => 'T.Sixpack + Busa + jht.Univ',
            'id' => 1,
            'tipe_bahan' => 'A',
            'harga' => 25500
        ], [
            'nama' => 'T.Sixpack + Busa uk.JB + jht.JB',
            'id' => 2,
            'tipe_bahan' => 'A',
            'harga' => 30000
        ], [
            'nama' => 'T.Sixpack + Busa uk.JB + jht.NMAX',
            'id' => 3,
            'tipe_bahan' => 'A',
            'harga' => 33000
        ], [
            'nama' => 'Japstyle',
            'id' => 4,
            'tipe_bahan' => 'A',
            'harga' => 22000
        ], [
            'id' => 4,
            'tipe_bahan' => 'B',
            'harga' => 19000
        ]];

        for ($i = 0; $i < count($spjap); $i++) {
            if (isset($spjap[$i]['nama'])) {
                DB::table('spjaps')->insert([
                    'nama' => $spjap[$i]['nama'],
                ]);
            }
            DB::table('spjap_bhn_hrg')->insert([
                'spjap_id' => $spjap[$i]['id'],
                'tipe_bahan' => $spjap[$i]['tipe_bahan'],
                'harga' => $spjap[$i]['harga']
            ]);
        }
    }
}
