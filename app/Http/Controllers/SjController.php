<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Nota;
use App\Pelanggan;
use App\SiteSetting;
use App\Sj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SjController extends Controller
{
    public function index(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $reload_page = $request->session()->get('reload_page');
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }

        $sjs = Sj::limit(100)->orderByDesc('created_at')->get();
        $pelanggans = array();
        for ($i = 0; $i < count($sjs); $i++) {
            $pelanggan = Sj::find($sjs[$i]->id)->pelanggan;
            array_push($pelanggans, $pelanggan);
        }
        // $pelanggan = Pelanggan::find(3)->spk;
        // dd($pelanggans);
        $data = ['sjs' => $sjs, 'pelanggans' => $pelanggans, 'reload_page' => $reload_page];

        return view('sj.sjs', $data);
    }

    public function sjBaru_pCust(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $notas_blm_kirim_gr_cust = Nota::where('status_sj', 'BELUM SJ')->orderByDesc('created_at')->groupBy('pelanggan_id')->get();
        dump('notas_blm_kirim_gr_cust');
        dump($notas_blm_kirim_gr_cust);

        $custs_notas = array();
        for ($i0 = 0; $i0 < count($notas_blm_kirim_gr_cust); $i0++) {
            $pelanggan = Pelanggan::find($notas_blm_kirim_gr_cust[$i0]['pelanggan_id']);
            $notas = Nota::where('pelanggan_id', $pelanggan['id'])->get();

            $cust_notas = [
                'pelanggan' => json_encode($pelanggan),
                'notas' => json_encode($notas),
            ];

            array_push($custs_notas, $cust_notas);
        }

        dump('$custs_notas');
        dump($custs_notas);

        $data = [
            'custs_notas' => $custs_notas,
        ];

        return view('sj.sjBaru-pCust', $data);
    }

    public function sjBaru_pCust_DB(Request $request)
    {
        $load_num = SiteSetting::find(1);
        // if ($load_num !== 0) {
        //     $load_num->value = 0;
        //     $load_num->save();
        // }

        $show_dump = true;
        $show_hidden_dump = true;
        $run_db = true;
        $load_num_ignore = true;
        // Pada development mode, load number boleh diignore. Yang perlu diperhatikan adalah
        // insert dan update database supaya tidak berantakan
        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $post = $request->input();
        if ($show_dump === true) {
            dump('post');
            dump($post);
        }

        $pelanggan_id = null;
        $reseller_id = null;

        $sj_items_gabungan = array();
        for ($iL_notaID = 0; $iL_notaID < count($post['nota_id']); $iL_notaID++) {
            $nota = Nota::find($post['nota_id'][$iL_notaID]);
            if ($show_dump === true) {
                dump("nota-$iL_notaID:");
                dump($nota);
            }
            $nota_items = json_decode($nota['data_nota_item'], true);
            dump("nota_items-$iL_notaID");
            dump($nota_items);

            if ($iL_notaID === 0) {
                $pelanggan_id = $nota['pelanggan_id'];
            }
            if ($iL_notaID === 0 && $nota['reseller_id'] !== null) {
                $reseller_id = $nota['reseller_id'];
            }
            $sj_items = array();

            // SETELAH INPUT KE SJ, MAKA KITA PERLU INPUT KE spkcpnotasj
            // BELUM DIKERJAKAN: SORTING PRODUK & PENGGABUNGAN PRODUK YANG SAMA

            for ($i_notaItem=0; $i_notaItem < count($nota_items); $i_notaItem++) {
                $colly = null;

                $sj_item = [
                    'spkcpnota_id' => $nota_items[$i_notaItem]['spkcpnota_id'],
                    'produk_id' => $nota_items[$i_notaItem]['produk_id'],
                    'nama_nota' => $nota_items[$i_notaItem]['nama_nota'],
                    'jml_item' => $nota_items[$i_notaItem]['jml_item'],
                    'hrg_item' => $nota_items[$i_notaItem]['hrg_per_item'],
                    'hrg_t' => $nota_items[$i_notaItem]['hrg_total_item'],
                    'colly' => $colly,
                ];
                array_push($sj_items_gabungan, $sj_item);
            }
        }

        if ($show_dump === true) {
            // Sebelum mulai input ke DB, cek dlu apakah sudah benar semua
            dump([
                'pelanggan_id' => $pelanggan_id,
                'reseller_id' => $reseller_id,
                'status' => 'SJ DIBUAT - BLM KIRIM',
                'json_sj_item' => $sj_items_gabungan,
            ]);
        }

        if ($run_db === true) {
            $sj_id = DB::table('sjs')->insertGetId([
                'pelanggan_id' => $pelanggan_id,
                'reseller_id' => $reseller_id,
                'status' => 'SJ DIBUAT - BLM KIRIM',
                'json_sj_item' => json_encode($sj_items_gabungan),
            ]);
            $sj_barusan_input = Sj::find($sj_id);
            $sj_barusan_input->no_sj = "SJ-$sj_id";
            $sj_barusan_input->save();

            for ($i_notaItemsGabungan=0; $i_notaItemsGabungan < count($sj_items_gabungan); $i_notaItemsGabungan++) { 
                DB::table('spkcpnotsjs')->insert([
                    'spkcpnota_id' => $sj_items_gabungan[$i_notaItemsGabungan]['spkcpnota_id'],
                    'sj_id' => $sj_id,
                    'jml' => $sj_items_gabungan[$i_notaItemsGabungan]['jml_item'],
                ]);
            }
        }

        $data = [
            'go_back_number' => -2,
        ];

        dump('ALL PROCESS IS FINISHED!');

        $load_num->value += 1;
        $load_num->save();

        return view('layouts.go-back-page', $data);
    }

    public function sj_detailSJ(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = true;
        $show_hidden_dump = true;
        $run_db = true;
        $load_num_ignore = true;
        // Pada development mode, load number boleh diignore. Yang perlu diperhatikan adalah
        // insert dan update database supaya tidak berantakan
        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $get = $request->input();
        
        $sj = Sj::find($get['sj_id']);

        if ($show_dump === true) {
            dump('get');
            dump($get);
            dump('sj:');
            dump($sj);
        }

        $data = [
            'sj' => $sj,
            'csrf' => csrf_token()
        ];

        return view('sj.sj-detailSJ', $data);
    }
}

