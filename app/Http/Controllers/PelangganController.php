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
        //
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
        return view('pelanggan/pelanggans', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function create(Request $request)
    {
        //
        $load_num = SiteSetting::find(1);

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

        $load_num->value += 1;
        $load_num->save();

        return view('pelanggan.pelanggan-baru', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
