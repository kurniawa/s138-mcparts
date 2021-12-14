<?php

namespace App\Http\Controllers;

use App\Produk;
use App\SiteSetting;
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
        // $site_setting
        // $reload_page = $request->session()->get('reload_page');
        // if ($reload_page === true) {
        //     $request->session()->put('reload_page', false);
        // }

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
        $data = ['spk' => $spk, 'pelanggan' => $pelanggan, 'spk_item' => $spk_item, 'produks' => $produks, 'reload_page' => $reload_page];
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

        // $reload_page = $request->session()->get('reload_page');

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
                // 'reload_page' => $reload_page,
            ];
        } elseif ($produk->tipe === 'kombi') {
            $att_kombi = fetch_att_kombi();

            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_kombi' => $att_kombi,
                'kombis' => $att_kombi['kombis'],
            ];
        } elseif ($produk->tipe === 'std') {
            $att_std = fetch_att_std();

            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_std' => $att_std,
                'stds' => $att_std['stds'],
            ];
        } elseif ($produk->tipe === 'spjap') {
            $att_spjap = fetch_att_spjap();
            $d_bahan_a = fetchBahan()->d_bahan_a();
            $d_bahan_b = fetchBahan()->d_bahan_b();

            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_spjap' => $att_spjap,
                'spjaps' => $att_spjap['spjaps'],
                'd_bahan_a' => $d_bahan_a,
                'd_bahan_b' => $d_bahan_b,
            ];
        } elseif ($produk->tipe === 'tankpad') {
            $att_tp = fetch_att_tp();

            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_tp' => $att_tp,
                'tankpads' => $att_tp['tankpads'],
            ];
        } elseif ($produk->tipe === 'busastang') {
            $att_busastang = fetch_att_busastang();

            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_busastang' => $att_busastang,
                'busastangs' => $att_busastang['busastangs'],
            ];
        } elseif ($produk->tipe === 'stiker') {
            $att_stiker = fetch_att_stiker();

            $data = [
                'spk_item' => $spk_item,
                'produk' => $produk,
                'mode' => 'edit',
                'tipe' => $produk['tipe'],
                'att_stiker' => $att_stiker,
                'stikers' => $att_stiker['stikers'],
            ];
        }
        return view('spk.inserting_spk_item-2', $data);
    }
}
