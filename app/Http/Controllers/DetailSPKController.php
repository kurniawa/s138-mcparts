<?php

namespace App\Http\Controllers;

use App\Spk;
use Illuminate\Http\Request;

class DetailSPKController extends Controller
{
    public function index(Request $request)
    {
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
        $data = ['spk' => $spk, 'pelanggan' => $pelanggan, 'spk_item' => $spk_item, 'produks' => $produks];
        return view('spk.detail_spk', $data);
    }
}
