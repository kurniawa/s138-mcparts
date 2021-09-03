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
        DB::table('pelanggans')->insert([
            'nama' => '3 Putra Motor',
            'alamat' => 'Jl. Sutoyo 5 No. 140, Kel. Teluk Dalam, Kec. Banjar Barat, Banjarmasin',
            'daerah' => 'Banjarmasin',
            'no_kontak' => '0822 5363 3222',
            'pulau' => 'Kalimantan',
        ], [
            'nama' => 'Akong',
            'alamat' => 'Pluit, Jakarta',
            'daerah' => 'Pluit',
            'no_kontak' => '',
            'pulau' => 'Jawa',
        ]);
    }
}
