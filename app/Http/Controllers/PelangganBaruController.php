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
            'daerah' => 'required',
            'pulau' => 'required',
        ]);

        $post = $request->input();

        if ($show_dump === true) {
            dd("post:", $post);
        }

        // ALAMAT
        $arr_alamat_pelanggan = $post['alamat_pelanggan'];
        $alamat_pelanggan = "";

        $i_arrAlamatEks = 0;
        foreach ($arr_alamat_pelanggan as $baris_alamat_pelanggan) {
            if ($baris_alamat_pelanggan === null || $baris_alamat_pelanggan === "") {
                # Kalau tidak diisi, maka tidak perlu ada yang diinput
            } else {
                if ($i_arrAlamatEks !== 0) {
                    $alamat_pelanggan .= "[br]";
                }
                $alamat_pelanggan .= $baris_alamat_pelanggan;
            }
            $i_arrAlamatEks++;
        }


        if ($run_db === true) {
            Pelanggan::create([
                'nama' => $post['nama_pelanggan'],
                'daerah' => $post['daerah'],
                'no_kontak' => $post['kontak_pelanggan'],
                'pulau' => $post['pulau'],
                'initial' => $post['singkatan_pelanggan'],
                'ktrg' => $post['keterangan'],
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
