<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelanggan = [
            ['nama' => '3 Putra Motor', 'alamat' => 'Jl. Sutoyo 5 No. 140[br]Kel. Teluk Dalam, Kec. Banjar Barat[br]Banjarmasin', 'daerah' => 'Banjarmasin', 'no_kontak' => '0822 5363 3222', 'pulau' => 'Kalimantan','initial' => '3PM', 'reseller_id' => null],
            ['nama' => 'Akong', 'alamat' => 'Pluit, Jakarta', 'daerah' => 'Pluit', 'no_kontak' => '0812 9120 0168', 'pulau' => 'Jawa','initial' => 'AK', 'reseller_id' => null],
            ['nama' => 'Karya Motor', 'alamat' => 'Jl. Jurung No.6[br]Simpang Wahidin, Medan', 'daerah' => 'Medan', 'no_kontak' => '', 'pulau' => 'Sumatra','initial' => 'KAR', 'reseller_id' => 2],
            ['nama' => 'Karya Motor', 'alamat' => 'Jl. Jurung No.6[br]Simpang Wahidin, Medan', 'daerah' => 'Medan', 'no_kontak' => '', 'pulau' => 'Sumatra','initial' => 'KAR', 'reseller_id' => null]
        ];

        for ($i = 0; $i < count($pelanggan); $i++) {
            DB::table('pelanggans')->insert([
                'nama' => $pelanggan[$i]['nama'],
                'alamat' => $pelanggan[$i]['alamat'],
                'daerah' => $pelanggan[$i]['daerah'],
                'no_kontak' => $pelanggan[$i]['no_kontak'],
                'pulau' => $pelanggan[$i]['pulau'],
                'initial' => $pelanggan[$i]['initial'],
                'reseller_id' => $pelanggan[$i]['reseller_id'],
            ]);
        }

        // $pelanggan_reseller = [
        //     ['nama' => 'Akong - Karya Motor', 'reseller_id' => 2, 'pelanggan_id' => 3]
        // ];

        // for ($i = 0; $i < count($pelanggan_reseller); $i++) {
        //     DB::table('pelanggan_reseller')->insert([
        //         'reseller_id' => $pelanggan_reseller[$i]['reseller_id'],
        //         'pelanggan_id' => $pelanggan_reseller[$i]['pelanggan_id'],
        //     ]);
        // }
    }
}
