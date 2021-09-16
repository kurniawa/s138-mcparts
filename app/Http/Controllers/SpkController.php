<?php

namespace App\Http\Controllers;

use App\Spk;
use App\Pelanggan;
use App\Bahan;
use App\Jahit;
use App\Kombi;
use App\SPJap;
use App\Standar;
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
        return view('spk.spk_baru', $data);
    }

    public function inserting_spk_item(Request $request)
    {
        $get = $request->input();

        // dd($get);
        // 1.
        // Ternyata disini tetap membutuhkan table bantuan atau mungkin table asli untuk
        // menyimpan data spk seperti data pelanggan dan tanggal, supaya tidak hilang ketika
        // berpindah-pindah halaman..

        // 2.
        // Karena akan sering bolak balik halaman ini, maka butuh bantuan variable lain
        // yang akan menandakan, bahwa tidak perlu create spk lagi


        // $spk = Spk::create([
        //     'pelanggan_id' => $get['pelanggan_id'],
        //     'reseller_id' => $get['reseller_id'],
        //     'status' => 'PROSES',
        //     'judul' => $get['judul'],
        //     'created_at' => $get['tanggal'],
        // ]);

        // $no_spk = createNoSPK($get['tanggal']);
        // $getmonth = (int)date('m', strtotime($get['tanggal']));
        // $getyear = (int)date('Y', strtotime($get['tanggal']));
        // $month_roman = integerToRoman($getmonth);

        // $spk_update = Spk::find($spk['id']);
        // $spk_update->no_spk = "01.$spk_update[id]/MCP-A/$month_roman/$getyear";
        // $spk_update->save();

        $tanggal = date('d-m-Y', strtotime($get['tanggal']));
        $spk_item = DB::table('temp_spk_produk')->get();
        $data = ['spks' => $get, 'spk_item' => $spk_item, 'tanggal' => $tanggal];
        return view('spk.inserting_spk_item', $data);

        // dump(time());
        // dump(time() / 86400);
        // dump(date('Y-m-d', 18883 * 86400));
        // dd(date('Y-m-d', time()));
        // dump(getdate()['mon']);

        // dump($getmonth);

        // dd($month_roman);
        // DB::table('spks')->insert([
        //     'pelanggan_id' => $post['pelanggan_id'],
        //     'reseller_id' => $post['reseller_id'],
        //     'status' => 'PROSES',
        //     'judul' => $post['judul'],
        //     'created_at' => $post['tanggal'],
        // ]);

        // Setelah berhasil insert, maka berikutnya coba get temp_spk_produk,
        // apakah sebelumnya sempat ada item yang diinput.

        // dump($spk['id']);
        // dd($spk);

        // dd($spk_update);

        // return $post;
    }

    public function inserting_varia()
    {
        $label_bahans = $this->fetchBahan()->label_bahans();
        $varias_harga = $this->fetchVaria()->varias_harga();
        $ukurans_harga = $this->fetchUkuran()->ukurans_harga();
        $jahits_harga = $this->fetchJahit()->jahits_harga();

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

    public function inserting_kombi()
    {
        $label_kombis = $this->fetchKombi()->label_kombis();

        $element_properties = "
        <div id='div_pilih_kombi'></div>
        <div style='display:none;' class='mt-1em' id='div_ta_ktrg'></div>
        <div style='display:none;' class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'SJ Kombinasi',
            'tipe' => 'kombi',
            'kombis' => $label_kombis,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_kombi', $data);
    }

    public function inserting_spjap()
    {
        $label_spjaps = $this->fetchSpjap()->label_spjaps();
        $d_bahan_a = $this->fetchBahan()->d_bahan_a();
        $d_bahan_b = $this->fetchBahan()->d_bahan_b();

        $element_properties = "
        <br>
        Pilih Tipe Bahan:
        <div id='div_pilih_tipe_bhn'>
            <select id='tipe_bahan' name='tipe_bhn' class='form-select' onchange='setAutocomplete_D_Bahan();'>
                <option value='A'>Bahan(A)</option>
                <option value='B'>Bahan(B)</option>
            </select>
        </div>
        <br>
        Pilih Bahan:
        <div id='div_pilih_bahan'>
        <input type='text' id='bahan' name='bahan' class='input-normal' style='border-radius:5px;'>
        <input type='hidden' id='bahan_id' name='bahan_id'>
        </div>
        <br>
        <div id='div_pilih_spjap'></div>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'SJ SixPack/Japstyle',
            'tipe' => 'spjap',
            'spjaps' => $label_spjaps,
            'd_bahan_a' => $d_bahan_a,
            'd_bahan_b' => $d_bahan_b,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_std()
    {
        $label_spjaps = $this->fetchSpjap()->label_spjaps();
        $d_bahan_a = $this->fetchBahan()->d_bahan_a();
        $d_bahan_b = $this->fetchBahan()->d_bahan_b();

        $element_properties = "
        <br>
        Pilih Tipe Bahan:
        <div id='div_pilih_tipe_bhn'>
            <select id='tipe_bahan' name='tipe_bhn' class='form-select' onchange='setAutocomplete_D_Bahan();'>
                <option value='A'>Bahan(A)</option>
                <option value='B'>Bahan(B)</option>
            </select>
        </div>
        <br>
        Pilih Bahan:
        <div id='div_pilih_bahan'>
        <input type='text' id='bahan' name='bahan' class='input-normal' style='border-radius:5px;'>
        <input type='hidden' id='bahan_id' name='bahan_id'>
        </div>
        <br>
        <div id='div_pilih_spjap'></div>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'SJ SixPack/Japstyle',
            'tipe' => 'spjap',
            'spjaps' => $label_spjaps,
            'd_bahan_a' => $d_bahan_a,
            'd_bahan_b' => $d_bahan_b,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_item_db(Request $request)
    {
        $post = $request->all();

        // dump($post);

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
        return view('spk.inserting_item-db', $data);
        // return $post;
    }

    public function fetchBahan()
    {
        $bahan = new Bahan();
        return $bahan;
    }

    public function fetchVaria()
    {
        $variasi = new Variasi();
        return $variasi;
    }

    public function fetchUkuran()
    {
        $ukuran = new Ukuran();
        return $ukuran;
    }
    public function fetchJahit()
    {
        $jahit = new Jahit();
        return $jahit;
    }

    public function fetchKombi()
    {
        $kombi = new Kombi();
        return $kombi;
    }

    public function fetchSpjap()
    {
        $spjap = new SPJap();
        return $spjap;
    }

    public function fetchStandar()
    {
        $std = new Standar();
        return $std;
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
