<?php

namespace App\Http\Controllers;

use App\Produk;
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
            dump($produk_search);
            if ($produk_search === null) {
                dd('Produk Belum Terdaftar!');

                // DIsini coba pake bantuan function properties
                $produk_id = Produk::create([
                    'tipe' => $post['tipe'],
                    'properties' => json_encode($properties),
                    'nama' => $spk_item[$i]->nama,
                    'nama_nota' => $spk_item[$i]->nama_nota,
                ]);
                DB::table('produk_hargas')->insert([
                    'produk_id' => $produk_id,
                    'harga' => $spk_item[$i]->harga,
                ]);
                // echo ('produk_id: ');
                // dd($produk_id);
                array_push($d_produk_id, $produk_id);
            }
        }
    }
}
