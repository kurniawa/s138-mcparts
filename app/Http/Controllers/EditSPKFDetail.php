<?php

namespace App\Http\Controllers;

use App\Produk;
use App\ProdukHarga;
use App\Spk;
use App\SpkProduk;
use Illuminate\Http\Request;

class EditSPKFDetail extends Controller
{
    public function index(Request $request)
    {
        /**
         * Untuk edit salah satu item SPK, maka kita perlu untuk mengolah data dari awal terlebih dahulu.
         * Pertama2 kita akan ambil data SPK seutuhnya melalui spk_id. Setelah spk ditemukan, maka
         * kita perlu mengubah data_spk_item yang berbentuk json.
         * 
         * Untuk mengetahui index ke berapa yang perlu diganti, maka untuk mempermudah perbandingan
         * kita perlu ambil data nama dari produk sebelumnya melalui produk_id_old.
         * 
         * Untuk memudahkan perbandingan nya, maka kita pilih properti nama nya saja. Oleh karena itu
         * sebelumnya kita perlu untuk menyusun kembali nama dari item yang baru diedit melalui
         * fungsi baru, yakni getNameProduk yang aku taro di helper.php.
         * 
         * Kemungkinan yang ada:
         * 1) produk persis sama seperti sebelumnya, serta jumlah dan keterangan pun sama
         * 2) produk sama seperti sebelumnya, namun jumlah dan keterangan nya perlu diganti di table spk_produk
         * 3) produk berbeda, namun sudah terdaftar di database produk, sehingga table spk_produk nya saja
         * yang perlu diupdate
         * 4) produk berbeda dan belum terdaftar di database produk. Ini brrti produk yang benar2 baru.
         * Jadi pertama-tama insert terlebih dahulu di database produk, lalu insert ke db produk_harga
         * baru setelah itu update di table spk_produk
         * 
         * Setelah mendapatkan nama yang sudah disusun, maka kita dapat mulai membandingkan, apakah
         * ini merupakan produk yang sama atau berbeda. Apabila ternyata produknya sama, maka untuk
         * mempersingkat proses, kita tidak perlu membandingkan lagi parameter yang lain, seperti
         * jumlah dan keterangan. Kita langsung update saja di table spk_produk
         * 
         * Apabila ternyata nama produk berbeda, maka harus dicari apakah item tersebut sudah terdaftar
         * di database produk.
         * 
         * 
         */
        $post = $request->input();
        dump('$post');
        dump($post);
        $spk_id = $post['spk_id'];
        $spk = Spk::find($spk_id);
        // dd($spk);

        $produk_id_old = $post['produk_id_old'];
        $produk_old = Produk::find($produk_id_old);
        dump('$produk_old');
        dump($produk_old);

        $tipe = $post['tipe'];
        $produk_new = getNameProduk($tipe, $post);
        dump('$produk_new');
        dump($produk_new);

        if ($produk_new['nama'] === $produk_old['nama']) {
            dump('Produk Sama!');
            $spk_produk = SpkProduk::find($post['spk_produk_id']);
            dump('$spk_produk');
            dump($spk_produk);
            $spk_produk->ktrg = $post['ktrg'];
            $spk_produk->jumlah = $post['jumlah'];

            $spk_produk->save();
            dump($spk_produk);
            dump($spk_produk);
        } else {
            dump('Produk Berbeda!');
            $produk_search = Produk::where('nama', '=', $produk_new['nama'])->first();
            dump('mencari produk di database');
            dump($produk_search);
            if ($produk_search === null) {
                dump('Produk Belum Terdaftar!');

                // DIsini coba pake bantuan function properties
                $spk_item = [
                    'tipe' => $post['tipe'],
                    'jumlah' => $post['jumlah'],
                    'ktrg' => $post['ktrg'],
                ];

                // $spk_item = json_encode($spk_item);
                $properties = getProdukProperties($spk_item, $produk_new);
                dump($properties);
                // dd($properties);

                $produk_new_created = Produk::create([
                    'tipe' => $post['tipe'],
                    'properties' => json_encode($properties),
                    'nama' => $produk_new['nama'],
                    'nama_nota' => $produk_new['nama_nota'],
                ]);
                dump($produk_new_created);
                $produk_harga_new_created = ProdukHarga::create([
                    'produk_id' => $produk_new_created['id'],
                    'harga' => $produk_new['harga'],
                ]);
                dump($produk_harga_new_created);
            }
        }

        $request->session()->put('reload_page', true);
        $data = [
            'go_back_number' => -2
        ];
        return view('layouts.go-back-page', $data);
    }
}
