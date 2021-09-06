<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JahitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // JAHIT SEEDER

        $jahit = [[
            'nama' => 'Univ',
            'id' => 1,
            'harga' => 1000
        ], [
            'nama' => 'JB',
            'id' => 2,
            'harga' => 1000
        ], [
            'nama' => 'ABS-RV',
            'id' => 3,
            'harga' => 1000
        ]];

        for ($i = 0; $i < count($jahit); $i++) {
            DB::table('jahits')->insert([
                'nama' => $jahit[$i]['nama'],
            ]);
            DB::table('jahit_harga')->insert([
                'jahit_id' => $jahit[$i]['id'],
                'harga' => $jahit[$i]['harga']
            ]);
        }
    }
}
