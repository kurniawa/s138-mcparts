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
        $reload_page = $request->session()->get('reload_page');
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }

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
        // dump($produk);
        // dd($spk_item);

        if ($produk->tipe === 'varia') {
            $att_varia = fetch_att_varia();
            // $label_bahans = fetchBahan()->label_bahans();
            // $varias_harga = fetchVaria()->varias_harga();
            // $ukurans_harga = fetchUkuran()->ukurans_harga();
            // $jahits_harga = fetchJahit()->jahits_harga();
            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_varia' => $att_varia,
                'bahans' => $att_varia['label_bahans'],
                'varias' => $att_varia['varias_harga'],
                'ukurans' => $att_varia['ukurans_harga'],
                'jahits' => $att_varia['jahits_harga'],
            ];
        }
        return view('spk.inserting_spk_item-2', $data);
    }
}
