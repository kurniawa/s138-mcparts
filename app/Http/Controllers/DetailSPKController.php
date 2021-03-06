<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use App\Produk;
use App\SiteSetting;
use App\Spk;
use Illuminate\Http\Request;
use App\SpkProduk;

class DetailSPKController extends Controller
{
    public function index(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = false;
        $show_hidden_dump = false;
        $run_db = true;
        $load_num_ignore = false;

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        // $reload_page = $request->session()->get('reload_page');

        // if ($reload_page === true) {
        //     $request->session()->put('reload_page', false);
        // }

        if ($show_hidden_dump === true) {
            dump('load_num->value');
            dump($load_num->value);
        }
        // $site_setting
        // $reload_page = $request->session()->get('reload_page');
        // if ($reload_page === true) {
        //     $request->session()->put('reload_page', false);
        // }

        $get = $request->input();
        $spk = Spk::find($get['spk_id']);
        $pelanggan = Spk::find($spk['id'])->pelanggan;
        $reseller = null;
        if ($spk['reseller_id'] !== null) {
            $reseller = Pelanggan::find($spk['reseller_id']);
        }
        $produks = Spk::find($spk['id'])->produks;
        $spk_item = Spk::find($spk['id'])->spk_item;

        if ($show_dump === true) {
            dump($get);
            dump('$spk');
            dump($spk);
            dump($pelanggan);
            dump('$produks');
            dump($produks);
            dump($spk_item);
        }
        $data = [
            'spk' => $spk,
            'pelanggan' => $pelanggan,
            'reseller' => $reseller,
            'spk_item' => $spk_item,
            'produks' => $produks,
            'my_csrf' => csrf_token(),
            // 'reload_page' => $reload_page,
        ];

        // DB run testing seeder apabila ada file yang terhapus
        $run_seeder = false;
        if ($run_seeder === true) {
            
            $spk_produk = [
                ['spk_id' => 1, 'produk_id' => 1, 'jumlah' => 150, 'harga' => 18000],
                ['spk_id' => 1, 'produk_id' => 2, 'jumlah' => 150, 'harga' => 27500],
                ['spk_id' => 1, 'produk_id' => 3, 'jumlah' => 150, 'harga' => 12500],
                ['spk_id' => 1, 'produk_id' => 4, 'jumlah' => 300, 'harga' => 5500],
                ['spk_id' => 1, 'produk_id' => 5, 'jumlah' => 150, 'harga' => 9000],
                ['spk_id' => 1, 'produk_id' => 6, 'jumlah' => 150, 'harga' => 30000],
                ['spk_id' => 1, 'produk_id' => 7, 'jumlah' => 300, 'harga' => 4000],
            ];
            for ($i = 0; $i < count($spk_produk); $i++) {
                SpkProduk::create([
                    'spk_id' => $spk_produk[$i]['spk_id'],
                    'produk_id' => $spk_produk[$i]['produk_id'],
                    'jumlah' => $spk_produk[$i]['jumlah'],
                    'harga' => $spk_produk[$i]['harga'],
                ]);
            }
            dump("seeder finished!");
        }

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

    public function hapus_SPK(Request $request)
    {
        $load_num = SiteSetting::find(1);

        $show_dump = true;
        $show_hidden_dump = false;
        $run_db = true;
        $load_num_ignore = false;

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $post = $request->input();
        $spk = Spk::find($post['id']);

        if ($run_db === true) {
            $spk->delete();
        }

        $data = [
            "go_back_number" => -2,
        ];

        $load_num->value += 1;
        $load_num->save();

        if ($show_dump === true) {
            dump('$post');
            dump($post);
            dump('$spk');
            dump($spk);
            dump("DELETION PROCESS IS FINISHED!");
        }
        return view('layouts.go-back-page', $data);
    }
}
