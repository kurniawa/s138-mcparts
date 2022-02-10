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
        $hide_dump = true;
        $run_db = false;
        $load_num_ignore = true;
        // Pada development mode, load number boleh diignore. Yang perlu diperhatikan adalah
        // insert dan update database supaya tidak berantakan

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $post = $request->input();
        if ($show_dump === true) {
            dump('post');
            dump($post);
        }

        for ($iL_notaID = 0; $iL_notaID < count($post['nota_id']); $iL_notaID++) {
            $nota = Nota::find($post['nota_id'][$iL_notaID]);
            if ($show_dump === true) {
                dump("nota-$iL_notaID:");
                dump($nota);
            }
            $nota_items = json_decode($nota['data_nota_item'], true);
            dump("nota_items-$iL_notaID");
            dump($nota_items);

            $reseller_id = null;
            if ($nota['reseller_id'] !== null) {
                $reseller_id = $nota['reseller_id'];
            }

            if ($show_dump === true) {
                // Sebelum mulai input ke DB, cek dlu apakah sudah benar semua
                dump([
                    'pelanggan_id' => $nota['pelanggan_id'],
                    'reseller_id' => $reseller_id,
                    'status' => 'SJ DIBUAT - BLM KIRIM',
                    'data_nota_item' => json_encode($nota_items),
                ]);
            }

            if ($run_db === true) {
                $sj_id = DB::table('sjs')->insertGetId([
                    'pelanggan_id' => $nota['pelanggan_id'],
                    'reseller_id' => $reseller_id,
                    'status' => 'SJ DIBUAT - BLM KIRIM',
                    'data_nota_item' => json_encode($nota_items),
                ]);
            }
        }

        dd('end');

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
}
