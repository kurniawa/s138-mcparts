<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Pelanggan;
use App\Produk;
use App\ProdukHarga;
use App\SiteSetting;
use App\Spk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SpkProduk;

class SpkBaru extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function proceed_spk(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = true;
        $show_hidden_dump = false;
        $run_db = true;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $post = $request->input();
        $pelanggan = Pelanggan::find($post['pelanggan_id']);

        if ($show_dump === true) {
            dump('$post');
            dump($post);
        }

        if ($post['submit_type'] === 'proceed_spk') {
            $spk_item = DB::table('temp_spk_produk')->get();
            dump('spk_item');
            dump($spk_item);
            // dd($spk_item);
            // dump($spk_item[0]);
            // dump($spk_item[1]->kombi_id);
            // dump($spk_item[2]->standar_id);
            // dump($spk_item[3]->tankpad_id);
            // dump($spk_item[4]->busastang_id);
            // dump($spk_item[5]->spjap_id);
            // dump($spk_item[6]->stiker_id);
            // dd($spk_item[0]->jumlah);
            $jumlah_total = 0;
            $harga_total = 0;
            /**Looping sekaligus insert ke produks dan produk_harga,
             * apabila belum exist */
            $spk_item_simple = array();
            $d_produk_id = array();
            for ($i = 0; $i < count($spk_item); $i++) {
                $jumlah_total += (int)$spk_item[$i]->jumlah;
                $harga_total += $spk_item[$i]->harga * $spk_item[$i]->jumlah;
                // dump($produk);
                // dump($produk['id']);
                // MENENTUKAN PROPERTIES UNTUK PRODUK BARU DAN MENYEDERHANAKAN DATA PRODUK
                if ($spk_item[$i]->tipe === 'varia') {
                    $properties = [
                        'bahan_id' => $spk_item[$i]->bahan_id,
                        'variasi_id' => $spk_item[$i]->variasi_id,
                        'ukuran_id' => $spk_item[$i]->ukuran_id,
                        'jahit_id' => $spk_item[$i]->jahit_id,
                    ];
                    $spk_item_simple[$i] = [
                        // 'bahan' => $spk_item[$i]->bahan,
                        'bahan_id' => $spk_item[$i]->bahan_id,
                        'variasi_id' => $spk_item[$i]->variasi_id,
                        'ukuran_id' => $spk_item[$i]->ukuran_id,
                        'jahit_id' => $spk_item[$i]->jahit_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'harga' => $spk_item[$i]->harga,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                } elseif ($spk_item[$i]->tipe === 'kombinasi') {
                    $properties = [
                        'kombi_id' => $spk_item[$i]->kombi_id,
                    ];
                    $spk_item_simple[$i] = [
                        'kombi_id' => $spk_item[$i]->kombi_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'harga' => $spk_item[$i]->harga,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                } elseif ($spk_item[$i]->tipe === 'std') {
                    $properties = [
                        'standar_id' => $spk_item[$i]->standar_id,
                    ];
                    $spk_item_simple[$i] = [
                        'standar_id' => $spk_item[$i]->standar_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'harga' => $spk_item[$i]->harga,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                } elseif ($spk_item[$i]->tipe === 'tankpad') {
                    $properties = [
                        'tankpad_id' => $spk_item[$i]->tankpad_id,
                    ];
                    $spk_item_simple[$i] = [
                        'tankpad_id' => $spk_item[$i]->tankpad_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'harga' => $spk_item[$i]->harga,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                } elseif ($spk_item[$i]->tipe === 'busastang') {
                    $properties = [
                        'busastang_id' => $spk_item[$i]->busastang_id,
                    ];
                    $spk_item_simple[$i] = [
                        'busastang_id' => $spk_item[$i]->busastang_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'harga' => $spk_item[$i]->harga,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                } elseif ($spk_item[$i]->tipe === 'spjap') {
                    $properties = [
                        'spjap_id' => $spk_item[$i]->spjap_id,
                        'tipe_bahan' => $spk_item[$i]->tipe_bahan,
                    ];
                    if ($spk_item[$i]->bahan_id !== null) {
                        $arr_to_push = [
                            'bahan_id' => $spk_item[$i]->bahan_id,
                        ];
                        array_push($properties, $arr_to_push);
                    }
                    $spk_item_simple[$i] = [
                        'spjap_id' => $spk_item[$i]->spjap_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'harga' => $spk_item[$i]->harga,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                } elseif ($spk_item[$i]->tipe === 'stiker') {
                    $properties = [
                        'stiker_id' => $spk_item[$i]->stiker_id,
                    ];
                    $spk_item_simple[$i] = [
                        'stiker_id' => $spk_item[$i]->stiker_id,
                        'nama' => $spk_item[$i]->nama,
                        'nama_nota' => $spk_item[$i]->nama_nota,
                        'harga' => $spk_item[$i]->harga,
                        'jumlah' => $spk_item[$i]->jumlah,
                        'ktrg' => $spk_item[$i]->ktrg,
                    ];
                }

                // APABILA EXIST MAKA PERLU DI UPDATE HARGA LAMA NYA.
                $produk = Produk::where('nama', '=', $spk_item[$i]->nama)->first();
                // echo "produk: ";
                // dd($produk);
                if ($produk !== null) {
                    $produk_harga = ProdukHarga::latest()->where('produk_id', '=', $produk['id'])->first();
                    if ($produk_harga['harga'] < $spk_item[$i]->harga) {
                        // uncomment

                        if ($run_db === true) {
                            # code...
                            $produk_id = DB::table('produk_hargas')->insertGetId([
                                'produk_id' => $produk['id'],
                                'harga' => $spk_item[$i]->harga,
                            ]);
                        }

                        // $produk_harga_updated = DB::table('produk_hargas')->orderBy('created_at')->first();
                        // $produk_harga_terbaru = DB::table('produk_hargas')->latest();

                        // uncomment
                        // dd($produk_harga_updated['produk_id']);
                        // $produk_id = $produk_harga_terbaru['id'];
                    } else {
                        // dd($produk_harga['produk_id']);
                        $produk_id = $produk_harga['produk_id'];
                    }

                    array_push($d_produk_id, $produk_id);
                } else {

                    // dump(json_encode($properties));
                    // uncomment

                    if ($run_db === true) {
                        $produk_id = DB::table('produks')->insertGetId([
                            'tipe' => $spk_item[$i]->tipe,
                            'properties' => json_encode($properties),
                            'nama' => $spk_item[$i]->nama,
                            'nama_nota' => $spk_item[$i]->nama_nota,
                        ]);
                        DB::table('produk_hargas')->insert([
                            'produk_id' => $produk_id,
                            'harga' => $spk_item[$i]->harga,
                        ]);
                    }

                    // echo ('produk_id: ');
                    // dd($produk_id);
                    array_push($d_produk_id, $produk_id);

                    // uncomment

                }
            }

            // SETELAH LOOPING, SEKARANG MULAI INSERT KE SPK


            /**
             * format nomor spk= SPK.1/MCP-ADM/XXI-IX/2021
             * 1-1-1
             * id-pelanggan - id user - id spk
             */


            // uncomment

            if ($run_db === true) {
                $spk_id = DB::table('spks')->insertGetId([
                    'pelanggan_id' => $post['pelanggan_id'],
                    'reseller_id' => $pelanggan['reseller_id'],
                    'status' => 'PROSES',
                    'judul' => $post['judul'],
                    // 'data_spk_item' => $string_spk_item_simple,
                    'jumlah_total' => $jumlah_total,
                    'harga_total' => $harga_total,
                ]);
    
                DB::table('spks')
                    ->where('id', $spk_id)
                    ->update([
                        'no_spk' => "SPK-$spk_id"
                    ]);
            }



            // Setelah selesai insert ke SPK, maka berikutnya insert ke SPK produk
            /**
             * # Setelah insert ke SpkProduk, maka kita update lagi spk nya, yakni untuk kolom data_spk_item
             * # Kenapa ga langsung aja sebelumnya udah diisi kolom nya data_spk_item?
             * Karena di data_spk_item alangkah lebih baik apabila terdapat juga keterangan ttg: spk_produk_id
             * yang berkaitan.
             * # Setelah ditambahkan data spk_produk_id pada masing2 $spk_item_simple, maka kita perlu untuk
             * stringify $spk_item_simple melalui json_encode yang ditampung pada variable $string_spk_item_simple
             * # Setelah stringify, maka kita siap untuk update data spk
             */
            // dd($d_produk_id);


            for ($j = 0; $j < count($spk_item); $j++) {
                if ($run_db === true) {
                    $spk_produk_id = DB::table('spk_produks')->insertGetId([
                        'spk_id' => $spk_id,
                        'produk_id' => $d_produk_id[$j],
                        'jumlah' => $spk_item[$j]->jumlah,
                        'harga' => $spk_item[$j]->harga,
                        'ktrg' => $spk_item[$j]->ktrg,
                        'status' => 'PROSES',
                    ]);
                    
                    $spk_produk = SpkProduk::find($spk_produk_id);
                    $spk_item_simple[$j]['spk_produk_id'] = $spk_produk_id;
                    $spk_item_simple[$j]['status'] = 'PROSES';
                    // $spk_item_simple[$j]['status'] = $spk_produk['status'];
                    // $spk_item_simple[$j]['created_at'] = $spk_produk['created_at'];
                    // $spk_item_simple[$j]['updated_at'] = $spk_produk['updated_at'];
                }
            }
            $string_spk_item_simple = json_encode($spk_item_simple);
            dump('string_spk_item_simple');
            dump($string_spk_item_simple);

            if ($run_db === true) {
                $spk = Spk::find($spk_id);
                $spk->data_spk_item = $string_spk_item_simple;
                $spk->save();
            }

            DB::table('temp_spk_produk')->truncate();

            // uncomment

            // $request->session()->put('reload_page', true);
            $data = ['spk_item' => $spk_item, 'spks' => $post, 'go_back_number' => -3];
            return view('layouts.go-back-page', $data);
        }
    }
}
