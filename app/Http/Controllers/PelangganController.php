<?php

namespace App\Http\Controllers;

use App\Ekspedisi;
use App\Pelanggan;
use App\PelangganEkspedisi;
use App\SiteSetting;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = false;
        $show_hidden_dump = false;
        $run_db = false;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $pelanggans = Pelanggan::all();

        if ($show_dump === true) {
            dump("pelanggans: ", $pelanggans);
        }
        $resellers = array();
        foreach ($pelanggans as $pelanggan) {
            $reseller = null;
            if ($pelanggan['reseller_id'] !== null) {
                $reseller = Pelanggan::find($pelanggan['reseller_id']);
            }
            array_push($resellers, $reseller);
        }

        $data = [
            "pelanggans" => $pelanggans,
            "resellers" => $resellers,
        ];

        if ($show_dump === true) {
            dump("data: ", $data);
        }
        return view('pelanggan.pelanggans', $data);
    }

    public function pelanggan_detail(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = false;
        $show_hidden_dump = true;
        $run_db = false;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $get = $request->input();
        $pelanggan = Pelanggan::find($get['cust_id']);
        $pelanggan_ekspedisi = PelangganEkspedisi::where('pelanggan_id', $pelanggan['id'])->get();
        $ekspedisis = array();
        $jml_ekspedisi = count($pelanggan_ekspedisi);
        $reseller = null;
        if ($pelanggan['reseller_id'] !== null) {
            $reseller = Pelanggan::find($pelanggan['reseller_id']);
        }

        for ($i_pelangganEkspedisi=0; $i_pelangganEkspedisi < count($pelanggan_ekspedisi); $i_pelangganEkspedisi++) {
            $ekspedisi = Ekspedisi::find($pelanggan_ekspedisi[$i_pelangganEkspedisi]['id']);
            array_push($ekspedisis, $ekspedisi);
        }

        if ($show_dump === true) {
            dump('get');
            dump($get);
            dump('pelanggan');
            dump($pelanggan);
            dump('ekspedisi');
            dump($ekspedisi);
            dump('reseller');
            dump($reseller);
        }

        $data = [
            "cust_id" => $pelanggan['id'],
            "pelanggan" => $pelanggan,
            "pelanggan_ekspedisi" => $pelanggan_ekspedisi,
            "ekspedisis" => $ekspedisis,
            "jml_ekspedisi" => $jml_ekspedisi,
            "reseller" => $reseller,
        ];

        return view('pelanggan.pelanggan-detail', $data);
    }
}
