<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use App\SiteSetting;
use Illuminate\Http\Request;

class PelangganBaruController extends Controller
{
    public function pelanggan_baru(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = true;
        $show_hidden_dump = true;
        $run_db = false;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        if ($show_dump === true) {
        }

        $data = [];

        return view('pelanggan.pelanggan-baru', $data);
    }

    public function create(Request $request)
    {
        //
        $load_num = SiteSetting::find(1);

        $show_dump = true;
        $show_hidden_dump = true;
        $run_db = false;
        $load_num_ignore = false;

        if ($show_hidden_dump === true) {
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $request->validate([
            'nama_pelanggan' => 'required',
            // 'alamat_pelanggan[]' => 'required',
            // 'daerah' => 'required',
            // 'pulau' => 'required',
        ]);

        $post = $request->input();

        if ($show_dump === true) {
            dump("post:", $post);
        }

        if ($run_db === true) {
            Pelanggan::create([
                'nama' => $post['nama_pelanggan'],
            ]);
        }

        $data = [
            'go_back_number'=>-2
        ];

        if ($run_db === true) {
            $load_num->value += 1;
            $load_num->save();
        }

        return view('layouts.go-back-page', $data);
    }
}
