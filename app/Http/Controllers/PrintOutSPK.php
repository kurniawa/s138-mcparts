<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use App\Spk;
use Illuminate\Http\Request;

class PrintOutSPK extends Controller
{
    public function index(Request $request)
    {
        $post = $request->input();
        // dump('$post');
        // dump($post);

        /** DATA yang dibutuhkan untuk dikirim adalah:
         * spk, pelanggan, spk_produk, produk
         */

        $spk = Spk::find($post['spk_id']);
        // dump('SPK');
        // dump($spk);

        $pelanggan = Pelanggan::find($spk['pelanggan_id']);
        // dump('pelanggan');
        // dump($pelanggan);

        // dump('data_spk_item');
        $data_spk_item = $spk['data_spk_item'];
        // dump($data_spk_item);
        $data_spk_item = json_decode($data_spk_item, true);
        // dump($data_spk_item);

        $tgl_pembuatan = date('d-m-Y', strtotime($spk['created_at']));

        $data = [
            'spk' => $spk,
            'pelanggan' => $pelanggan,
            'data_spk_item' => $data_spk_item,
            'tgl_pembuatan' => $tgl_pembuatan,
            'go_back_number' => -1,
        ];

        return view('spk.print_out_spk', $data);
    }
}
