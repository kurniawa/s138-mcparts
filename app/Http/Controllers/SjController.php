<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SiteSetting;
use App\Sj;
use Illuminate\Http\Request;

class SjController extends Controller
{
    public function index(Request $request)
    {
        $load_num = SiteSetting::find(1);
        $load_num->value = 0;
        $load_num->save();

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
}
