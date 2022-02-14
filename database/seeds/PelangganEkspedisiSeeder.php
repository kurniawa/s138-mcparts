<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganEkspedisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pelanggan_ekspedisi = [
            ['pelanggan_id' => 1, 'ekspedisi_id' => 1],
            ['pelanggan_id' => 3, 'ekspedisi_id' => 2]
        ];

        for ($i = 0; $i < count($pelanggan_ekspedisi); $i++) {
            DB::table('pelanggan_ekspedisis')->insert([
                'pelanggan_id' => $pelanggan_ekspedisi[$i]['pelanggan_id'],
                'ekspedisi_id' => $pelanggan_ekspedisi[$i]['ekspedisi_id'],
            ]);
        }
    }
}
