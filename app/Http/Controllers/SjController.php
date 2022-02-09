<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Nota;
use App\Pelanggan;
use App\SiteSetting;
use App\Sj;
use Illuminate\Http\Request;

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
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_comment = true;

        $post = $request->input();
        if ($show_comment === true) {
            dump('post');
            dd($post);
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
}
