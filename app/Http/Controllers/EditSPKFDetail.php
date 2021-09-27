<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Spk;
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
         * Setelah mendapatkan nama yang sudah disusun, maka kita dapat mulai membandingkan, apakah
         * ini merupakan produk yang sama atau berbeda.
         */
        $post = $request->input();
        dump($post);
        $spk_id = $post['spk_id'];
        $spk = Spk::find($spk_id);
        // dd($spk);

        $produk_id_old = $post['produk_id_old'];
        $produk_old = Produk::find($produk_id_old);
        dump($produk_old);

        $tipe = $post['tipe'];
        $produk_new = getNameProduk($tipe, $post);
        dump($produk_new);

        if ($produk_new['nama'] === $produk_old['nama']) {
            dd('Produk Sama!');
        } else {
            dd('Produk Berbeda!');
        }
    }
}
