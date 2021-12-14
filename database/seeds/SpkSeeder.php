<?php

use App\Spk;
use App\SpkProduk;
use Illuminate\Database\Seeder;

class SpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_spk_item = [
            [
                'bahan_id' => 2,
                'variasi_id' => 1,
                'ukuran_id' => 1,
                'jahit_id' => 2,
                'nama' => 'BigDot(MC) Polos uk.JB 93x53 + jht.JB',
                'nama_nota' => 'SJ BigDot(MC) Polos uk.JB + jht.JB',
                'jumlah' => 150,
                'harga' => 18000,
                'ktrg' => null,
                'spk_produk_id' => 1,
                'status' => 'PROSES',
            ], [
                'kombi_id' => 6,
                'nama' => 'Motif Sixpack 2 Warna + jht.Univ',
                'nama_nota' => 'SJ Motif Sixpack 2 Warna + jht.Univ',
                'harga' => 27500,
                'jumlah' => 150,
                'ktrg' => null,
                'spk_produk_id' => 2,
                'status' => 'PROSES',
            ], [
                'standar_id' => 20,
                'nama' => 'Standar Supra Fit',
                'nama_nota' => 'SJ Standar Supra Fit',
                'harga' => 12500,
                'jumlah' => 150,
                'ktrg' => null,
                'spk_produk_id' => 3,
                'status' => 'PROSES',
            ], [
                'tankpad_id' => 5,
                'nama' => 'TP Fox Dimensi',
                'nama_nota' => 'TP Fox Dimensi',
                'harga' => 5500,
                'jumlah' => 300,
                'ktrg' => null,
                'spk_produk_id' => 4,
                'status' => 'PROSES',
            ], [
                'busastang_id' => 1,
                'nama' => 'Busa-Stang',
                'nama_nota' => 'Busa-Stang',
                'harga' => 8000, 'jumlah' => 150,
                'ktrg' => null,
                'spk_produk_id' => 5,
                'status' => 'PROSES',
            ], [
                'spjap_id' => 2,
                'tipe_bahan' => 'A',
                'nama' => 'Bahan(A) T.Sixpack + Busa uk.JB + jht.JB',
                'nama_nota' => 'SJ Bahan(A) T.Sixpack + Busa uk.JB + jht.JB',
                'harga' => 30000,
                'jumlah' => 150,
                'ktrg' => null,
                'spk_produk_id' => 6,
                'status' => 'PROSES',
            ], [
                'stiker_id' => 1,
                'nama' => 'Stiker Api',
                'nama_nota' => 'Stiker Api',
                'harga' => 4000,
                'jumlah' => 300,
                'ktrg' => null,
                'spk_produk_id' => 7,
                'status' => 'PROSES',
            ]
        ];
        $string_data_spk_item = json_encode($data_spk_item);
        $spk = [
            ['no_spk' => 'SPK-1', 'pelanggan_id' => 3, 'reseller_id' => 2, 'status' => 'PROSES', 'data_spk_item' => $string_data_spk_item, 'jumlah_total' => 1350, 'harga_total' => 17400000]
        ];

        $spk_produk = [
            ['spk_id' => 1, 'produk_id' => 1, 'jumlah' => 150, 'harga' => 18000],
            ['spk_id' => 1, 'produk_id' => 2, 'jumlah' => 150, 'harga' => 27500],
            ['spk_id' => 1, 'produk_id' => 3, 'jumlah' => 150, 'harga' => 12500],
            ['spk_id' => 1, 'produk_id' => 4, 'jumlah' => 300, 'harga' => 5500],
            ['spk_id' => 1, 'produk_id' => 5, 'jumlah' => 150, 'harga' => 9000],
            ['spk_id' => 1, 'produk_id' => 6, 'jumlah' => 150, 'harga' => 30000],
            ['spk_id' => 1, 'produk_id' => 7, 'jumlah' => 300, 'harga' => 4000],
        ];

        for ($i = 0; $i < count($spk); $i++) {
            Spk::create([
                'no_spk' => $spk[$i]['no_spk'],
                'pelanggan_id' => $spk[$i]['pelanggan_id'],
                'reseller_id' => $spk[$i]['reseller_id'],
                'status' => $spk[$i]['status'],
                'data_spk_item' => $spk[$i]['data_spk_item'],
                'jumlah_total' => $spk[$i]['jumlah_total'],
                'harga_total' => $spk[$i]['harga_total'],
            ]);
        }
        for ($i = 0; $i < count($spk_produk); $i++) {
            SpkProduk::create([
                'spk_id' => $spk_produk[$i]['spk_id'],
                'produk_id' => $spk_produk[$i]['produk_id'],
                'jumlah' => $spk_produk[$i]['jumlah'],
                'harga' => $spk_produk[$i]['harga'],
            ]);
        }
    }
}
