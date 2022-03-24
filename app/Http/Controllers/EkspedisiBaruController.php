<?php

namespace App\Http\Controllers;

use App\Ekspedisi;
use App\SiteSetting;
use Illuminate\Http\Request;

class EkspedisiBaruController extends Controller
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
        $all_ekspedisi = Ekspedisi::orderBy('nama')->get();

        $data = [
            'all_ekspedisi' => $all_ekspedisi,
        ];
        return view('ekspedisi.ekspedisi-baru', $data);
    }

    /**
     * Nanti setelah selesai menjalankan fungsi dibawah ini, maka setelah menekan tombol kembali, app akan pindah ke halaman sebelumnya yang sudah ditentukan oleh developer, mesti kembali ke belakang yang ke berapa. Lalu di halaman tersebut, app akan reload, karena sudah di setting dari go-back-page terdapat javascript yang mengatur supaya session storage men set sebuah key-value pair. Key-value pair ini akan dipanggil di halaman kembali nya untuk cek apakah perlu reload atau tidak.
     */
    public function ekspedisi_baru_db(Request $request)
    {
        $load_num = SiteSetting::find(1);

        $show_dump = true; // false apabila mode production, supaya tidak terlihat berantakan oleh customer
        $run_db = true; // true apabila siap melakukan CRUD ke DB
        $load_num_ignore = false; // false apabila proses CRUD sudah sesuai dengan ekspektasi. Ini mencegah apabila terjadi reload page.
        $show_hidden_dump = true;

        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $post = $request->input();
        $arr_alamat_eks = $post['alamat_ekspedisi'];
        $bentuk_perusahaan = null;
        if (isset($post['bentuk_perusahaan']) && $post['bentuk_perusahaan'] !== null && $post['bentuk_perusahaan'] !== '') {
            $bentuk_perusahaan = $post['bentuk_perusahaan'];
        }

        if ($show_dump === true) {
            dump('$post: ', $post);
            dump('count($arr_alamat_eks)', count($arr_alamat_eks));
        }

        $alamat_ekspedisi = "";

        $i_arrAlamatEks = 0;
        foreach ($arr_alamat_eks as $alamat_eks) {
            if ($alamat_eks === null || $alamat_eks === "") {
                # Kalau tidak diisi, maka tidak perlu ada yang diinput
            } else {
                if ($i_arrAlamatEks !== 0) {
                    $alamat_ekspedisi .= "[br]";
                }
                $alamat_ekspedisi .= $alamat_eks;
            }
            $i_arrAlamatEks++;
        }

        $keterangan = $post['keterangan'];

        if ($keterangan === null || $keterangan === '') {
            $keterangan = null;
        }

        if ($run_db === true) {
            Ekspedisi::create([
                'bentuk' => $bentuk_perusahaan,
                'nama' => $post['nama_ekspedisi'],
                'alamat' => $alamat_ekspedisi,
                'no_kontak' => $post['kontak_ekspedisi'],
                'ktrg' => $keterangan,
            ]);
        }

        $data = [
            'go_back_number' => -2
        ];

        $load_num->value += 1;
        $load_num->save();
        return view('layouts.go-back-page', $data);
    }
}
