<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Spk;
use Illuminate\Http\Request;
use App\SpkNotas;

class NotaController extends Controller
{
    //
    public function index(Request $request)
    {
        // dump($this->site_settings[0]->value);
        // $this->site_settings[0]->value = 'TRUE';
        // $this->site_settings->save();
        // dump($this->site_settings[0]['value']);
        $reload_page = $request->session()->get('reload_page');
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }
        // dump($reload_page);

        // else {
        //     $reload_page = false;
        // }


        $notas = Nota::limit(100)->orderByDesc('created_at')->get();
        $pelanggans = array();
        for ($i = 0; $i < count($notas); $i++) {
            $pelanggan = Nota::find($notas[$i]->id)->pelanggan;
            array_push($pelanggans, $pelanggan);
        }
        // $pelanggan = Pelanggan::find(3)->spk;
        // dd($pelanggans);
        $data = ['notas' => $notas, 'pelanggans' => $pelanggans, 'reload_page' => $reload_page];
        // $data = ['notas' => $notas, 'pelanggans' => $pelanggans];
        return view('nota/notas', $data);
    }

    public function notaBaru_pilihSPK(Request $request)
    {
        /**
         * Form pilihan spk yang ingin dibuatkan nota nya akan muncul. Daftar spk yang ada di pilihan adalah SPK dengan status "SELESAI"
         * atau "SEBAGIAN"
         */
        $available_spk = Spk::where('status', 'SEBAGIAN')->orWhere('status', 'SELESAI')->get();
        // dump('available_spk');
        // dump($available_spk);

        $data = [
            'csrf' => csrf_token(),
            'available_spk' => $available_spk,
        ];
        return view('nota/nota_baru-pilih_spk', $data);
    }

    public function notaBaru_pilihSPK_pilihNota(Request $request)
    {

        $post = $request->input();
        dump('post');
        dump($post);

        $spk_id = $post['spk_id'];
        $spk_nota_this = SpkNotas::where('spk_id', $spk_id)->get();
        dump('spk_nota dengan spk_id ini');
        dump($spk_nota_this);

        $available_nota = [];
        for ($i = 0; $i < count($spk_nota_this); $i++) {
            $available_nota_temp = Nota::find($spk_nota_this[$i]['nota_id']);
            array_push($available_nota, $available_nota_temp);
        }
        dump('available_nota');
        dump($available_nota);

        $data = [
            'csrf' => csrf_token(),
            'available_nota' => $available_nota,
            'spk_id' => $spk_id
        ];
        return view('nota/nota_baru-pilih_spk-pilih_nota', $data);
    }

    public function notaBaru_pSPK_pNota_pItem(Request $request)
    {

        $post = $request->input();
        dump('post');
        dump($post);

        $spk_id = $post['spk_id'];


        $data = [
            'csrf' => csrf_token(),
            // 'available_spk' => $available_spk
        ];
        return view('nota/nota_baru-pSPK-pNota-pItem', $data);
    }
}
