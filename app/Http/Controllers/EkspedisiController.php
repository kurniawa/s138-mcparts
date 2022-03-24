<?php

namespace App\Http\Controllers;

use App\Ekspedisi;
use App\Http\Controllers\Controller;
use App\SiteSetting;
use Illuminate\Http\Request;

class EkspedisiController extends Controller
{
    public function index()
    {
        //
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = false;
        $show_hidden_dump = false;
        $run_db = true;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $ekspedisis = Ekspedisi::orderBy('nama')->get();

        if ($show_dump === true) {
            dump('ekspedisis');
            dump($ekspedisis);
        }

        $data = [
            'ekspedisis' => $ekspedisis,
        ];

        return view('ekspedisi.ekspedisis', $data);
    }

    public function ekspedisi_detail(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = false; // false apabila mode production, supaya tidak terlihat berantakan oleh customer
        $run_db = false; // true apabila siap melakukan CRUD ke DB
        $load_num_ignore = true; // false apabila proses CRUD sudah sesuai dengan ekspektasi. Ini mencegah apabila terjadi reload page.
        $show_hidden_dump = false;

        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $get = $request->input();

        if ($show_dump === true) {
            dump("get:");
            dump($get);
        }
        $ekspedisi = Ekspedisi::find($get['ekspedisi_id']);

        $data = [
            'ekspedisi' => $ekspedisi,
            'csrf' => csrf_token()
        ];

        return view('ekspedisi.ekspedisi-detail', $data);
    }
}
