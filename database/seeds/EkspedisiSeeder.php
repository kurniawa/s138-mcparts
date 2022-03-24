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
        // nanti ketika tabel pulau dan daerah sudah ready, maka bisa mulai di link
        DB::table('ekspedisis')->insert([
            [
                'bentuk' => 'CV',
                'nama' => 'Angkasa',
                'alamat' => 'Jl. Mangga Dua Raya[br]Ruko Mangga Dua Plaza[br]Blok B, No. 06',
                'no_kontak' => '(021)6120 705',
            ], [
                'bentuk' => null,
                'nama' => 'Wira Agung',
                'alamat' => 'Jl. Tubagus Angke Blok D 1/9,[br]Ruko Taman Duta Mas',
                'no_kontak' => '(021) 5678 067',
            ]
        ]);
    }
}
