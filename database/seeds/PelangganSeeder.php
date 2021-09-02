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
            'nama' => 'Akong',
            'alamat' => 'Pluit, Jakarta',
            'daerah' => 'Pluit',
            'no_kontak' => '',
            'pulau' => 'Jawa',
        ]);
    }
}
