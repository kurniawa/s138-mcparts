<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $pelanggan = [
            ['nama' => 'Akong', 'alamat' => 'Pluit, Jakarta', 'daerah' => 'Pluit', 'no_kontak' => '', 'pulau' => 'Jawa'],
            ['nama' => '3 Putra Motor', 'alamat' => '']
        ];
        DB::table('pelanggans')->insert([
            'nama' => 'Akong',
            'alamat' => 'Pluit, Jakarta',
            'daerah' => 'Pluit',
            'no_kontak' => '',
            'pulau' => 'Jawa',
        ]);

        // BAHAN SEEDER
        // BAHAN_HARGA SEEDER

        $bahan = [[
            'nama' => 'Amplas(RY)',
            'id' => 1,
            'harga' => 15000
        ], [
            'nama' => 'BigDot(MC)',
            'id' => 2,
            'harga' => 13000
        ], [
            'nama' => 'C30(MC)',
            'id' => 3,
            'harga' => 13000
        ], [
            'nama' => 'C38(MC)',
            'id' => 4,
            'harga' => 13000
        ], [
            'nama' => 'Carbon',
            'id' => 5,
            'harga' => 17000
        ], [
            'nama' => 'Grafitti',
            'id' => 6,
            'harga' => 13000
        ], [
            'nama' => 'K-Jeruk',
            'id' => 7,
            'harga' => 11500
        ], [
            'nama' => 'L-Hole',
            'id' => 8,
            'harga' => 10000
        ], [
            'nama' => 'Navaro(MC)',
            'id' => 9,
            'harga' => 13000
        ], [
            'nama' => 'U-Tangan(MC)',
            'id' => 10,
            'harga' => 13000
        ], [
            'nama' => 'Vario(M)',
            'id' => 11,
            'harga' => 13000
        ], [
            'nama' => 'Vario(MC)',
            'id' => 12,
            'harga' => 13000
        ]];

        for ($i = 0; $i < count($bahan); $i++) {
            DB::table('bahans')->insert([
                'nama' => $bahan[$i]['nama'],
            ]);
            DB::table('bahan_harga')->insert([
                'bahan_id' => $bahan[$i]['id'],
                'harga' => $bahan[$i]['harga']
            ]);
        }

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

        // UKURAN SEEDER

        $ukuran = [
            [
                'id' => 1,
                'nama' => 'JB 93x53',
                'nama_nota' => 'JB',
                'harga' => 4000
            ],
            [
                'id' => 2,
                'nama' => 'S-JB 97x53',
                'nama_nota' => 'S-JB',
                'harga' => 5500
            ], [
                'id' => 3,
                'nama' => 'Aerox',
                'nama_nota' => 'Aerox',
                'harga' => 5500
            ]
        ];
        for ($i = 0; $i < count($ukuran); $i++) {
            DB::table('ukurans')->insert([
                'nama' => $ukuran[$i]['nama'],
                'nama_nota' => $ukuran[$i]['nama_nota']
            ]);
            DB::table('ukuran_harga')->insert([
                'ukuran_id' => $ukuran[$i]['id'],
                'harga' => $ukuran[$i]['harga']
            ]);
        }

        // JAHIT SEEDER

        $jahit = ['Univ', 'JB', 'ABS-RV'];

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
