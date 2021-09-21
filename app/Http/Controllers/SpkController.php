<?php

namespace App\Http\Controllers;

use App\Spk;
use App\Pelanggan;
use App\Bahan;
use App\Busastang;
use App\Jahit;
use App\Kombi;
use App\Produk;
use App\SPJap;
use App\Standar;
use App\Stiker;
use App\Tankpad;
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

        // #
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
        <div>Pilih T.Sixpack/Japstyle:</div>
        <select id='div_pilih_spjap' name='spjap_id' class='form-select' onchange='assignSPJapIDValue(this.selectedIndex);'></select>
        <input type='hidden' id='spjap' name='spjap'>
        <input type='hidden' id='spjap_harga' name='spjap_harga'>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'SJ T.SixPack/Japstyle',
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
        $label_stds = $this->fetchStandar()->label_stds();

        $element_properties = "
        <br>
        Pilih Standar:
        <div id='div_pilih_standar'>
        <input type='text' id='standar' name='standar' class='input-normal' style='border-radius:5px;'>
        <input type='hidden' id='standar_id' name='standar_id'>
        <input type='hidden' id='standar_harga' name='standar_harga'>
        </div>
        <br>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'SJ Standar',
            'tipe' => 'std',
            'stds' => $label_stds,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_tankpad()
    {
        $label_tankpad = $this->fetchTankpad()->label_tp();

        $element_properties = "
        <br>
        Pilih Tankpad:
        <div id='div_pilih_tankpad'>
        <input type='text' id='tankpad' name='tankpad' class='input-normal' style='border-radius:5px;'>
        <input type='hidden' id='tankpad_id' name='tankpad_id'>
        <input type='hidden' id='tankpad_harga' name='tankpad_harga'>
        </div>
        <br>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'Tankpad',
            'tipe' => 'tankpad',
            'tankpads' => $label_tankpad,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_busastang()
    {
        $label_busastang = $this->fetchBusastang()->label_busastang();

        $element_properties = "
        <br>
        <div id='div_input_busastang'>
        <input type='text' id='busastang' name='busastang' class='input-normal' style='border-radius:5px;' value='Busa-Stang'>
        <input type='hidden' id='busastang_id' name='busastang_id'>
        <input type='hidden' id='busastang_harga' name='busastang_harga'>
        </div>
        <br>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'Busa-Stang',
            'tipe' => 'busastang',
            'busastangs' => $label_busastang,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_stiker()
    {
        $label_stiker = $this->fetchStiker()->label_stiker();

        $element_properties = "
        <br>
        Pilih Stiker:
        <div id='div_input_stiker'>
        <input type='text' id='stiker' name='stiker' class='input-normal' style='border-radius:5px;'>
        <input type='hidden' id='stiker_id' name='stiker_id'>
        <input type='hidden' id='stiker_harga' name='stiker_harga'>
        </div>
        <br>
        <div class='mt-1em' id='div_ta_ktrg'></div>
        <div class='mt-1em' id='div_input_jml'></div>
        ";

        $available_options = "
        <div style='display:inline-block' id='div_option_jml'></div>
        <div style='display:inline-block' id='div_option_ktrg'></div>
        ";

        $data = [
            'judul' => 'Stiker',
            'tipe' => 'stiker',
            'stikers' => $label_stiker,
            'element_properties' => $element_properties,
            'available_options' => $available_options,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_item_db(Request $request)
    {
        $post = $request->all();

        // dump($post);

        /**
         * Menentukan semua variable yang nantinya akan diinsert ke table temp_spk_item
         * Banyak variable akan di set value nya menjadi NULL
         */
        /*
        $table->id();
        $table->string('tipe', 50);
        $table->foreignId('bahan_id')->nullable();
        $table->foreignId('variasi_id')->nullable();
        $table->foreignId('ukuran_id')->nullable();
        $table->foreignId('jahit_id')->nullable();
        $table->foreignId('std_id')->nullable();
        $table->foreignId('kombi_id')->nullable();
        $table->foreignId('busastang_id')->nullable();
        $table->foreignId('tankpad_id')->nullable();
        $table->foreignId('spjap_id')->nullable();
        $table->foreignId('stiker_id')->nullable();
        $table->string('nama');
        $table->string('nama_nota');
        $table->string('jumlah');
        $table->integer('harga');
        $table->string('ktrg')->nullable();
        */

        $tipe = $post['tipe'];
        $jumlah = $post['jumlah'];
        $ktrg = null;
        $bahan_id = $variasi_id = $ukuran_id = $jahit_id = null;
        $standar_id = $kombi_id = $busastang_id = $tankpad_id = $spjap_id = $stiker_id = null;

        if (isset($post['bahan_id'])) {
            $bahan_id = $post['bahan_id'];
        }
        if (isset($post['variasi_id'])) {
            $variasi_id = $post['variasi_id'];
        }
        if (isset($post['ukuran_id'])) {
            $ukuran_id = $post['ukuran_id'];
        }
        if (isset($post['jahit_id'])) {
            $jahit_id = $post['jahit_id'];
        }
        if (isset($post['standar_id'])) {
            $standar_id = $post['standar_id'];
        }
        if (isset($post['kombi_id'])) {
            $kombi_id = $post['kombi_id'];
        }
        if (isset($post['busastang_id'])) {
            $busastang_id = $post['busastang_id'];
        }
        if (isset($post['tankpad_id'])) {
            $tankpad_id = $post['tankpad_id'];
        }
        if (isset($post['spjap_id'])) {
            $spjap_id = $post['spjap_id'];
        }
        if (isset($post['stiker_id'])) {
            $stiker_id = $post['stiker_id'];
        }
        if (isset($post['ktrg'])) {
            $ktrg = $post['ktrg'];
        }

        // dd($tipe);

        if ($tipe === 'varia') {
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
        }

        if ($tipe === 'kombinasi') {
            $nama = $post['kombi'];
            $nama_nota = $nama;
            $harga = $post['kombi_harga'];
        }

        if ($tipe === 'std') {
            $nama = "Standar $post[standar]";
            $nama_nota = $nama;
            $harga = $post['standar_harga'];
        }

        if ($tipe === 'spjap') {
            $nama = $post['spjap'];
            $nama_nota = $nama;
            $harga = $post['spjap_harga'];
        }

        // MELENGKAPI NAMA NOTA SEKALI LAGI
        if ($tipe === 'varia' || $tipe === 'kombinasi' || $tipe === 'std' || $tipe === 'spjap') {
            $nama_nota = "SJ $nama_nota";
        }

        if ($tipe === 'tankpad') {
            $nama = "TP $post[tankpad]";
            $nama_nota = $nama;
            $harga = $post['tankpad_harga'];
        }

        if ($tipe === 'busastang') {
            $nama = $post['busastang'];
            $nama_nota = $nama;
            $harga = $post['busastang_harga'];
        }

        if ($tipe === 'stiker') {
            $nama = $post['stiker'];
            $nama_nota = $nama;
            $harga = $post['stiker_harga'];
        }

        DB::table('temp_spk_produk')->insert([
            'tipe' => $tipe,
            'bahan_id' => $bahan_id,
            'variasi_id' => $variasi_id,
            'ukuran_id' => $ukuran_id,
            'jahit_id' => $jahit_id,
            'standar_id' => $standar_id,
            'kombi_id' => $kombi_id,
            'busastang_id' => $busastang_id,
            'tankpad_id' => $tankpad_id,
            'spjap_id' => $spjap_id,
            'stiker_id' => $stiker_id,
            'nama' => $nama,
            'nama_nota' => $nama_nota,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'ktrg' => $ktrg,
        ]);

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

    public function fetchTankpad()
    {
        $tp = new Tankpad();
        return $tp;
    }

    public function fetchBusastang()
    {
        $busastang = new Busastang();
        return $busastang;
    }

    public function fetchStiker()
    {
        $stiker = new Stiker();
        return $stiker;
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
        $post = $request->all();
        // dd($post);
        dump($post);
        if ($post['submit_type'] === 'proceed_spk') {
            $spk_item = DB::table('temp_spk_produk')->get();
            dump($spk_item);
            $jumlah_total = 0;
            $harga_total = 0;
            /**Looping sekaligus insert ke produks dan produk_harga,
             * apabila belum exist */
            for ($i = 0; $i < count($spk_item); $i++) {
                $jumlah_total += $spk_item[$i]['jumlah'];
                $harga_total += $spk_item[$i]['harga'];
                $produk = Produk::where('nama', '=', $spk_item[$i]['nama'])->first();
                if ($produk === null) {
                    DB::table('produks')->insert([
                        'nama' => $spk_item['nama'],
                        'nama_nota' => $spk_item['nama_nota'],
                    ]);
                }
            }
            $string_spk_item = json_encode($spk_item);
            dd($string_spk_item);

            /**
             * format nomor spk= SPK.1/MCP-ADM/XXI-IX/2021
             * 1-1-1
             * id-pelanggan - id user - id spk
             */

            $id = DB::table('spks')->insertGetId([
                'pelanggan_id' => $post['pelanggan_id'],
                'reseller_id' => $post['reseller_id'],
                'status' => 'PROSES',
                'judul' => $post['judul'],
                'data_produk' => $string_spk_item,
                'jumlah_total' => $jumlah_total,
                'harga_total' => $harga_total,
            ]);

            DB::table('spks')
                ->where('id', $id)
                ->update([
                    'no_spk' => "SPK-$id"
                ]);

            $data = ['spk_item' => $spk_item, 'spks' => $post];
            return view('spk.inserting_item-db', $data);
        }
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
