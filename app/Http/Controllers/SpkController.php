<?php

namespace App\Http\Controllers;

use App\Spk;
use App\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['spks' => Spk::all()];
        return view('spk/spks', $data);
    }

    public function spk_baru()
    {
        $pelanggan = new Pelanggan();
        $d_label_pelanggan = $pelanggan->d_label_pelanggan();
        // $d_nama_pelanggan_2 = $pelanggan->d_nama_pelanggan_2();
        // dd($d_label_pelanggan);
        // dd($d_label_pelanggan_2);

        $data = ['d_label_pelanggan' => $d_label_pelanggan];
        return view('spk/spk_baru', $data);
    }

    public function inserting_spk_item(Request $request)
    {
        $post = $request->input();

        // dd($post);
        // DB::table('temp_spks')->insert([
        //     'pelanggan_id' => $post['pelanggan_id'],
        //     'reseller_id' => $post['reseller_id'],
        //     'status' => 'PROSES',
        //     'judul' => $post['judul'],
        // ]);

        // Setelah berhasil insert, maka berikutnya coba get temp_spk_produk,
        // apakah sebelumnya sempat ada item yang diinput.

        $spk_item = DB::table('temp_spk_produk')->get();
        $data = ['spks' => $post, 'spk_item' => $spk_item];
        return view('/spk/inserting_spk_item', $data);
        // return $post;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Spk  $spk
     * @return \Illuminate\Http\Response
     */
    public function show(Spk $spk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spk  $spk
     * @return \Illuminate\Http\Response
     */
    public function edit(Spk $spk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spk  $spk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Spk $spk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Spk  $spk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spk $spk)
    {
        //
    }
}
