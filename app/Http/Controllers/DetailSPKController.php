<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Spk;
use Illuminate\Http\Request;
use App\SpkProduk;

class DetailSPKController extends Controller
{
    public function index(Request $request)
    {
        $get = $request->input();
        // dump($get);
        $spk = Spk::find($get['spk_id']);
        // dump($spk);
        $pelanggan = Spk::find($spk['id'])->pelanggan;
        // dump($pelanggan);
        $produks = Spk::find($spk['id'])->produks;
        // dump($produks);
        $spk_item = Spk::find($spk['id'])->spk_item;
        // dd($spk_item);
        $data = ['spk' => $spk, 'pelanggan' => $pelanggan, 'spk_item' => $spk_item, 'produks' => $produks];
        return view('spk.detail_spk', $data);
    }

    public function editSPKItem(Request $request)
    {
        $get = $request->input();
        // dd($get);
        $spk_item = SpkProduk::find($get['spk_item_id']);
        $produk = Produk::find($get['produk_id']);
        dump($produk);
        // dd($spk_item);

        if ($produk->tipe === 'varia') {
            $att_varia = fetch_att_varia();
        }
        $data = ['spk_item' => $spk_item, 'produk' => $produk, 'mode' => 'edit', 'tipe' => $produk['tipe'], 'att_varia' => $att_varia];
        return view('spk.inserting_spk_item-2', $data);
    }
}
