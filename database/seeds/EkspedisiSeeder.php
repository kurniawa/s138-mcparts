<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EkspedisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // daerah tujuan, tabel many to many
        DB::table('ekspedisis')->insert([
            'nama' => 'CV Angkasa',
            'alamat' => 'Jl. Mangga Dua Raya, Ruko Mangga Dua Plaza, Blok B, No. 06',
            'no_kontak' => '(021)6120 705',
            'daerah' => 'Banjarmasin',
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
