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
            [
                'nama' => 'CV Angkasa',
                'alamat' => 'Jl. Mangga Dua Raya[br]Ruko Mangga Dua Plaza[br]Blok B, No. 06',
                'no_kontak' => '(021)6120 705',
                'tujuan' => 'Banjarmasin',
            ], [
                'nama' => 'Wira Agung',
                'alamat' => 'Jl. Tubagus Angke Blok D 1/9,[br]Ruko Taman Duta Mas',
                'tujuan' => 'Banjarmasin',
                'no_kontak' => '(021) 5678 067',
            ]
        ]);
    }
}
