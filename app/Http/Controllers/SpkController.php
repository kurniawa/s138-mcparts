<?php

namespace App\Http\Controllers;

use App\Spk;
use App\Pelanggan;
use App\Bahan;
use App\Jahit;
use App\Ukuran;
use App\Variasi;
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

        dd($post);

        // Ternyata disini tetap membutuhkan table bantuan atau mungkin table asli untuk
        // menyimpan data spk seperti data pelanggan dan tanggal, supaya tidak hilang ketika
        // berpindah-pindah halaman.

        DB::table('spks')->insert([
            'pelanggan_id' => $post['pelanggan_id'],
            'reseller_id' => $post['reseller_id'],
            'status' => 'PROSES',
            'judul' => $post['judul'],
        ]);

        // Setelah berhasil insert, maka berikutnya coba get temp_spk_produk,
        // apakah sebelumnya sempat ada item yang diinput.

        $spk_item = DB::table('temp_spk_produk')->get();
        $data = ['spks' => $post, 'spk_item' => $spk_item];
        return view('/spk/inserting_spk_item', $data);
        // return $post;
    }

    public function inserting_varia()
    {
        $bahan = new Bahan();
        $label_bahans = $bahan->label_bahans();

        $variasi = new Variasi();
        $varias_harga = $variasi->varias_harga();

        $ukuran = new Ukuran();
        $ukurans_harga = $ukuran->ukurans_harga();

        $jahit = new Jahit();
        $jahits_harga = $jahit->jahits_harga();

        // dump($label_bahans);
        // dump($varias_harga);
        // dump($ukurans_harga);
        // dump($jahits_harga);

        $data = [
            'bahans' => $label_bahans,
            'varias' => $varias_harga,
            'ukurans' => $ukurans_harga,
            'jahits' => $jahits_harga,
        ];
        return view('/spk/inserting_varia', $data);
    }

    public function inserting_item_db(Request $request)
    {
        $post = $request->all();

        dump($post);

        // $table->id();
        // $table->string('tipe', 50);
        // $table->bigInteger('tipe_id');
        // $table->foreignId('bahan_id');
        // $table->foreignId('variasi_id');
        // $table->foreignId('ukuran_id');
        // $table->foreignId('jahit_id');
        // $table->foreignId('std_id');
        // $table->foreignId('kombi_id');
        // $table->foreignId('busastang_id');
        // $table->foreignId('tankpad_id');
        // $table->string('nama');
        // $table->string('nama_nota');
        // $table->string('jumlah');
        // $table->integer('harga');
        // $table->integer('ktrg')->nullable();
        // 'kombi_id' => $post['kombi_id'],
        // 'busastang_id' => $post['busastang_id'],
        // 'tankpad_id' => $post['tankpad_id'],
        $ktrg = null;
        if ($post['ktrg'] !== null) {
            $ktrg = trim($post['ktrg']);
        }
        $ukuran_id = null;
        $jahit_id = null;
        if ($post['tipe'] === 'varia') {
            $variasi = json_decode($post['variasi'], true);
            $harga = $post['bahan_harga'] + $variasi['harga'];
            $nama = "$post[bahan] $variasi[nama]";
            $nama_nota = $nama;
            // dd($variasi);
            if (isset($post['ukuran'])) {
                $ukuran = json_decode($post['ukuran'], true);
                $harga += $ukuran['harga'];
                $nama .= " uk.$ukuran[nama]";
                $nama_nota .= " uk.$ukuran[nama_nota]";
                $ukuran_id = $ukuran['id'];
            }
            if (isset($post['jahit'])) {
                $jahit = json_decode($post['jahit'], true);
                $harga += $jahit['harga'];
                $nama .= " + jht.$jahit[nama]";
                $nama_nota .= " + jht.$jahit[nama]";
                $jahit_id = $jahit['id'];
            }
            // dump($harga);
            // dump($nama_nota);
            // dd($nama);
            DB::table('temp_spk_produk')->insert([
                'tipe' => $post['tipe'],
                'bahan_id' => $post['bahan_id'],
                'variasi_id' => $variasi['id'],
                'ukuran_id' => $ukuran_id,
                'jahit_id' => $jahit_id,
                'nama' => $nama,
                'nama_nota' => $nama_nota,
                'jumlah' => $post['jumlah'],
                'harga' => $harga,
                'ktrg' => $ktrg,
            ]);
        }

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
