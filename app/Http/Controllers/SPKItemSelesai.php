<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use App\Spk;
use Illuminate\Http\Request;
use App\SpkProduk;
use Illuminate\Support\Arr;

class SPKItemSelesai extends Controller
{
    public function index(Request $request)
    {
        $reload_page = $request->session()->get('reload_page');
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }

        $get = $request->input();
        dump($get);
        // dd($get);

        $spk = Spk::find($get['spk_id']);
        dump('SPK');
        dump($spk);

        $pelanggan = Pelanggan::find($spk['pelanggan_id']);
        dump('pelanggan');
        dump($pelanggan);

        dump('data_spk_item');
        $data_spk_item = $spk['data_spk_item'];
        dump($data_spk_item);
        $data_spk_item = json_decode($data_spk_item, true);
        // dd($data_spk_item);
        dump($data_spk_item);

        $tgl_pembuatan = date('Y-m-d', strtotime($spk['created_at']));
        $tgl_pembuatan_dmY = date('d-m-Y', strtotime($tgl_pembuatan));

        $data = [
            'spk' => $spk,
            'pelanggan' => $pelanggan,
            'data_spk_item' => $data_spk_item,
            'tgl_pembuatan' => $tgl_pembuatan,
            'tgl_pembuatan_dmY' => $tgl_pembuatan_dmY,
            'csrf' => csrf_token(),
            'reload_page' => $reload_page,
        ];

        return view('spk.penetapan_item_selesai', $data);
    }

    public function setItemSelesai(Request $request)
    {
        /**
         * Ketika men set item spk selesai, yang perlu diperhatikan adalah:
         * 1) Item yang di set sebagai selesai, berupa array, jadi penanganan nya dengan
         * menggunakan loop. Hanya spk_id saja yang tidak perlu di loop.
         * 2) Apabila ada deviasi jumlah, maka ini akan mempengaruhi jumlah_total
         * dan maksimal dari jml_selesai seharusnya
         * 
         */
        $post = $request->input();
        dump('post');
        dump($post);
        // dd($post);

        // 1)
        /**
         * Sebelum melanjutkan poin 1, yaitu sebelum looping, sebaiknya concern terlebih dahulu
         * ke SPK, supaya pada saat looping juga bisa skalian mengubah data_spk_item
         */
        $spk = Spk::find($post['spk_id']);
        $str_data_spk_item_old = $spk['data_spk_item'];

        dump('data_spk_item_old');
        dump($str_data_spk_item_old);
        $data_spk_item_old = json_decode($str_data_spk_item_old, true);
        dump($data_spk_item_old);
        $data_spk_item_new = $data_spk_item_old;

        $d_spk_produk_id = $post['spk_produk_id'];
        $jumlah_total_old = (int)$spk['jumlah_total'];
        $harga_total_old = (int)$spk['harga_total'];
        $jumlah_total_new = $jumlah_total_old;
        $harga_total_new = $harga_total_old;

        for ($i = 0; $i < count($d_spk_produk_id); $i++) {
            /** DEFINISI VARIABLE AWAL */
            $spk_produk_this = SpkProduk::find($d_spk_produk_id[$i]);
            // dump('spk_produk_this');
            // dump($spk_produk_this);
            $deviasi_jml = (int)$post['deviasi_jml'][$i];
            $jml_selesai = (int)$post['jml_selesai'][$i];
            // $jumlah_akhir adalah jumlah masing-masing item setelah adanya deviasi jumlah
            $jumlah_akhir = $spk_produk_this['jumlah'];
            $harga_item = $spk_produk_this['harga'];
            $harga_total_item = 0;
            $status = 'PROSES';

            // 2)
            // dump('jumlah_akhir');
            // dump($jumlah_akhir);
            if ($deviasi_jml !== 0) {
                $jumlah_akhir += $deviasi_jml;
                $jumlah_total_new += $deviasi_jml;
                $harga_total_new += $deviasi_jml * $harga_item;
            }

            if ($jml_selesai === $jumlah_akhir) {
                $status = 'SELESAI';
            } elseif ($jml_selesai !== 0) {
                $status = 'SEBAGIAN';
            }

            $spk_produk_this->deviasi_jml = $deviasi_jml;
            $spk_produk_this->jml_selesai = $jml_selesai;
            $spk_produk_this->status = $status;

            $finished_at = date('Y-m-d', strtotime($post['tgl_selesai'][$i]));
            $spk_produk_this->finished_at = $finished_at;

            $spk_produk_this->save();

            /**
             * UPDATE DATABASE SPK
             * ===================
             * Setelah update table spk_produks, maka perlu update pula jumlah total dan harga total nya
             * yang tercantum pada table spk tapi coding update nya nanti di luar looping
             * Selain itu perlu juga untuk update status. (-UPDATE STATUS SPK-)
             * --Kalau spk_item belum ada yang selesai, status tetap tertulis 'PROSES'
             * --Kalau spk_item ada yang selesai atau selesai sebagian, status spk harus tertulis 'SEBAGIAN'
             * --Kalau semua spk_item sudah selesai maka status spk jadi tertulis 'SELESAI'
             */

            /**
             * disini mulai update array dari data_spk_item. Untuk update database spk nya masih nanti setelah looping
             * selesai.
             */
            $index_data_spk_item = '';
            for ($j = 0; $j < count($data_spk_item_old); $j++) {
                if ($data_spk_item_old[$j]['spk_produk_id'] === (int)$spk_produk_this['id']) {
                    $index_data_spk_item = $j;
                    break;
                } else {
                    $index_data_spk_item = 'NOT FOUND!';
                }
            }
            dump('index_data_spk_item');
            dump($index_data_spk_item);

            $data_spk_item_new[$index_data_spk_item]['deviasi_jml'] = $deviasi_jml;
            $data_spk_item_new[$index_data_spk_item]['jml_selesai'] = $jml_selesai;
            $data_spk_item_new[$index_data_spk_item]['status'] = $status;
        }

        /**
         * -UPDATE STATUS SPK-
         */
        $spk_produk = SpkProduk::where('spk_id', $spk['id'])->get();
        dump('UPDATE STATUS SPK: spk_produk');
        dump($spk_produk);

        $spk_status = 'PROSES';

        for ($i = 0; $i < count($spk_produk); $i++) {
            if ($spk_produk[$i]['status'] !== 'PROSES') {
                $spk_status = 'SEBAGIAN';
                break;
            }
        }



        /** UPDATE DATA_SPK_ITEM
         * Setelah update yang di spk_produk, maka sekarang giliran data_spk_item nya juga diupdate
         */
        dump('data_spk_item_new');
        dump($data_spk_item_new);

        $spk->data_spk_item = $data_spk_item_new;
        $spk->jumlah_total = $jumlah_total_new;
        $spk->harga_total = $harga_total_new;
        $spk->status = $spk_status;
        $spk->save();

        $request->session()->put('reload_page', true);

        $data = [
            'go_back_number' => -2,
        ];

        return view('layouts.go-back-page', $data);
    }
}
