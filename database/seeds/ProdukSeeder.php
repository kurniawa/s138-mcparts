<?php

use App\Produk;
use App\ProdukHarga;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $produk = [
            ['tipe' => 'varia', 'properties' => '{"bahan_id":2,"variasi_id":1,"ukuran_id":1,"jahit_id":2}', 'nama' => 'BigDot(MC) Polos uk.JB 93x53 + jht.JB', 'nama_nota' => 'SJ BigDot(MC) Polos uk.JB + jht.JB'],
            ['tipe' => 'kombi', 'properties' => '{"kombi_id":6}', 'nama' => 'Motif Sixpack 2 Warna + jht.Univ', 'nama_nota' => 'SJ Motif Sixpack 2 Warna + jht.Univ'],
            ['tipe' => 'std', 'properties' => '{"standar_id":20}', 'nama' => 'Standar Supra Fit', 'nama_nota' => 'SJ Standar Supra Fit'],
            ['tipe' => 'tankpad', 'properties' => '{"tankpad_id":5}', 'nama' => 'TP Fox Dimensi', 'nama_nota' => 'TP Fox Dimensi'],
            ['tipe' => 'busastang', 'properties' => '{"busastang_id":1}', 'nama' => 'Busa-Stang', 'nama_nota' => 'Busa-Stang'],
            ['tipe' => 'spjap', 'properties' => '{"spjap_id":2, "tipe_bahan":"A"}', 'nama' => 'Bahan(A) T.Sixpack + Busa uk.JB + jht.JB', 'nama_nota' => 'SJ Bahan(A) T.Sixpack + Busa uk.JB + jht.JB'],
            ['tipe' => 'stiker', 'properties' => '{"stiker_id":1}', 'nama' => 'Stiker Api', 'nama_nota' => 'Stiker Api'],
        ];
        for ($i = 0; $i < count($produk); $i++) {
            Produk::create([
                'tipe' => $produk[$i]['tipe'],
                'properties' => $produk[$i]['properties'],
                'nama' => $produk[$i]['nama'],
                'nama_nota' => $produk[$i]['nama_nota'],
            ]);
        }

        $produk_harga = [
            ['produk_id' => 1, 'harga' => 18000],
            ['produk_id' => 2, 'harga' => 27500],
            ['produk_id' => 3, 'harga' => 12500],
            ['produk_id' => 4, 'harga' => 5500],
            ['produk_id' => 5, 'harga' => 9000],
            ['produk_id' => 6, 'harga' => 30000],
            ['produk_id' => 7, 'harga' => 4000],
        ];
        for ($i = 0; $i < count($produk_harga); $i++) {
            ProdukHarga::create([
                'produk_id' => $produk_harga[$i]['produk_id'],
                'harga' => $produk_harga[$i]['harga'],
            ]);
        }
    }
}
