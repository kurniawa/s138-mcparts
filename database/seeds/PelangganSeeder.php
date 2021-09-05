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
            ['nama' => '3 Putra Motor', 'alamat' => 'Jl. Sutoyo 5 No. 140, Kel. Teluk Dalam, Kec. Banjar Barat, Banjarmasin', 'daerah'=>'Banjarmasin', 'no_kontak'=>'0822 5363 3222', 'pulau'=>'Kalimantan'],
            ['nama' => 'Akong', 'alamat' => 'Pluit, Jakarta', 'daerah' => 'Pluit', 'no_kontak' => '0812 9120 0168', 'pulau' => 'Jawa'],
            ['nama' => 'Karya Motor', 'alamat' => 'Jl. Jurung No.6, Simpang Wahidin, Medan', 'daerah'=>'Medan', 'no_kontak' => '', 'pulau' => 'Sumatra']
        ];

        for ($i=0; $i < count($pelanggan); $i++) { 
            DB::table('pelanggans')->insert([
                'nama' => $pelanggan[$i]['nama'],
                'alamat' => $pelanggan[$i]['alamat'],
                'daerah' => $pelanggan[$i]['daerah'],
                'no_kontak' => $pelanggan[$i]['no_kontak'],
                'pulau' => $pelanggan[$i]['pulau'],
            ]);
        }

        $pelanggan_ekspedisi = [
            ['pelanggan_id'=>1, 'ekspedisi_id'=>1],
            ['pelanggan_id'=>3, 'ekspedisi_id'=>2]
        ];

        for ($i=0; $i < count($pelanggan_ekspedisi); $i++) { 
            DB::table('pelanggan_ekspedisi')->insert([
                'pelanggan_id' => $pelanggan_ekspedisi[$i]['pelanggan_id'],
                'ekspedisi_id' => $pelanggan_ekspedisi[$i]['ekspedisi_id'],
            ]);
        }
    }
}
