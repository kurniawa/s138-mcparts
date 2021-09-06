<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // VARIASI SEEDER

        $variasi = [[
            'nama' => 'Polos',
            'id' => 1,
            'harga' => 0
        ], [
            'nama' => 'LG.Bayang',
            'id' => 2,
            'harga' => 500
        ], [
            'nama' => 'LG.Bludru',
            'id' => 3,
            'harga' => 500
        ], [
            'nama' => 'LG.Sablon',
            'id' => 4,
            'harga' => 500
        ], [
            'nama' => 'T.Bayang',
            'id' => 5,
            'harga' => 3000
        ], [
            'nama' => 'T.Polimas',
            'id' => 6,
            'harga' => 4000
        ], [
            'nama' => 'T.Sablon',
            'id' => 7,
            'harga' => 4000
        ], [
            'nama' => 'T.Trisula',
            'id' => 8,
            'harga' => 4000
        ]];

        for ($i = 0; $i < count($variasi); $i++) {
            DB::table('variasis')->insert([
                'nama' => $variasi[$i]['nama'],
            ]);
            DB::table('variasi_harga')->insert([
                'variasi_id' => $variasi[$i]['id'],
                'harga' => $variasi[$i]['harga']
            ]);
        }
    }
}
