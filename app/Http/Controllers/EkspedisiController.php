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
}
