<?php

namespace App\Http\Controllers;

use App\Spk;
use App\Pelanggan;
// use App\Bahan;
// use App\Busastang;
// use App\Jahit;
// use App\Kombi;
use App\Produk;
use App\ProdukHarga;
use App\SiteSetting;
// use App\SPJap;
// use App\Standar;
// use App\Stiker;
// use App\Tankpad;
// use App\Ukuran;
// use App\Variasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SpkProduk;

class SpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dump($this->site_settings[0]->value);
        // $this->site_settings[0]->value = 'TRUE';
        // $this->site_settings->save();
        // dump($this->site_settings[0]['value']);
        $reload_page = $request->session()->get('reload_page');
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }
        // dump($reload_page);

        // else {
        //     $reload_page = false;
        // }


        $spks = Spk::limit(100)->orderByDesc('created_at')->get();
        $pelanggans = array();
        $resellers = array();
        for ($i = 0; $i < count($spks); $i++) {
            $pelanggan = Spk::find($spks[$i]->id)->pelanggan;
            if ($spks[$i]->reseller_id !== null && $spks[$i]->reseller_id !== '') {
                $reseller = Pelanggan::find($spks[$i]->reseller_id);
                array_push($resellers, $reseller);
            } else {
                array_push($resellers, 'none');
            }
            array_push($pelanggans, $pelanggan);
        }
        // $pelanggan = Pelanggan::find(3)->spk;
        // dd($pelanggans);
        $data = ['spks' => $spks, 'pelanggans' => $pelanggans, 'resellers' => $resellers, 'reload_page' => $reload_page];
        // $data = ['spks' => $spks, 'pelanggans' => $pelanggans];
        return view('spk/spks', $data);
    }

    public function spk_baru()
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
        // Pada development mode, load number boleh diignore. Yang perlu diperhatikan adalah
        // insert dan update database supaya tidak berantakan
        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }
        // $pelanggan = new Pelanggan();
        // $d_label_pelanggan = $pelanggan->d_label_pelanggan();
        $pelanggans = Pelanggan::all();
        $d_label_pelanggan = array();
        foreach ($pelanggans as $pelanggan) {
            $label_nama = $pelanggan['nama'];
            if ($pelanggan['reseller_id'] !== null) {
                $nama_reseller = Pelanggan::find($pelanggan['reseller_id'])['nama'];
                $label_nama = "$nama_reseller - " . $pelanggan['nama'];
            }
            $arr_to_push = [
                "id" => $pelanggan['id'],
                "label" => $label_nama,
                "value" => $label_nama,
            ];
            array_push($d_label_pelanggan, $arr_to_push);
        }

        if ($show_dump === true) {
            dump("d_label_pelanggan");
            dump($d_label_pelanggan);
        }

        // $d_nama_pelanggan_2 = $pelanggan->d_nama_pelanggan_2();
        // dd($d_label_pelanggan);
        // dd($d_label_pelanggan_2);

        $data = ['d_label_pelanggan' => $d_label_pelanggan];
        return view('spk.spk_baru', $data);
    }

    public function inserting_spk_item(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = true;
        $show_hidden_dump = false;
        $run_db = true;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }
        $get = $request->input();
        // #
        // Karena akan sering bolak balik halaman ini, maka request methodnya ditetapkan menjadi GET
        $pelanggan = Pelanggan::find($get['pelanggan_id']);
        $reseller = null;
        if ($pelanggan['reseller_id'] !== null) {
            $reseller = Pelanggan::find($pelanggan['reseller_id']);
        }
        $judul = $get['judul'];
        $tanggal = date('d-m-Y', strtotime($get['tanggal']));
        $spk_item = DB::table('temp_spk_produk')->get();

        if ($show_dump) {
            dump("get");
            dump($get);
            dump("pelanggan");
            dump($pelanggan);
        }

        $reload_page = $request->session()->get('reload_page');
        // dump($reload_page);
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }
        $data = [
            'pelanggan' => $pelanggan,
            'reseller' => $reseller,
            'judul' => $judul,
            'spk_item' => $spk_item,
            'tanggal' => $tanggal,
            'reload_page' => $reload_page
        ];
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
        $label_bahans = fetchBahan()->label_bahans();
        $varias_harga = fetchVaria()->varias_harga();
        $ukurans_harga = fetchUkuran()->ukurans_harga();
        $jahits_harga = fetchJahit()->jahits_harga();
        $att_varia = fetch_att_varia();

        // dump($label_bahans);
        // dump($varias_harga);
        // dump($ukurans_harga);
        // dump($jahits_harga);

        $data = [
            'tipe' => 'varia',
            'bahans' => $label_bahans,
            'varias' => $varias_harga,
            'ukurans' => $ukurans_harga,
            'jahits' => $jahits_harga,
            'att_varia' => $att_varia,
            'mode' => 'SPK_BARU',
            'spk_item' => null,
            'produk' => null,
        ];
        return view('/spk/inserting_spk_item-2', $data);
    }

    public function inserting_kombi()
    {
        $label_kombis = fetchKombi()->label_kombis();
        $att_kombi = fetch_att_kombi();

        // $element_properties = "
        // <div id='div_pilih_kombi'></div>
        // <div style='display:none;' class='mt-1em' id='div_ta_ktrg'></div>
        // <div style='display:none;' class='mt-1em' id='div_input_jml'></div>
        // ";

        // $available_options = "
        // <div style='display:inline-block' id='div_option_jml'></div>
        // <div style='display:inline-block' id='div_option_ktrg'></div>
        // ";

        $data = [
            'tipe' => 'kombi',
            'kombis' => $label_kombis,
            // 'element_properties' => $element_properties,
            // 'available_options' => $available_options,
            'att_kombi' => $att_kombi,
            'mode' => 'SPK_BARU',
            'spk_item' => null,
            'produk' => null,
        ];

        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_spjap()
    {
        $label_spjaps = fetchSpjap()->label_spjaps();
        $d_bahan_a = fetchBahan()->d_bahan_a();
        $d_bahan_b = fetchBahan()->d_bahan_b();
        $att_spjap = fetch_att_spjap();

        // $element_properties = "
        // <br>
        // Pilih Tipe Bahan:
        // <div id='div_pilih_tipe_bhn'>
        //     <select id='tipe_bahan' name='tipe_bhn' class='form-select' onchange='setAutocomplete_D_Bahan();'>
        //         <option value='A'>Bahan(A)</option>
        //         <option value='B'>Bahan(B)</option>
        //     </select>
        // </div>
        // <br>
        // Pilih Bahan:
        // <div id='div_pilih_bahan'>
        //     <input type='text' id='bahan' name='bahan' class='input-normal' style='border-radius:5px;'>
        //     <input type='hidden' id='bahan_id' name='bahan_id'>
        // </div>
        // <br>
        // <div>Pilih T.Sixpack/Japstyle:</div>
        // <select id='div_pilih_spjap' name='spjap_id' class='form-select' onchange='assignSPJapIDValue(this.selectedIndex);'></select>
        // <input type='hidden' id='spjap' name='spjap'>
        // <input type='hidden' id='spjap_harga' name='spjap_harga'>
        // <div class='mt-1em' id='div_ta_ktrg'></div>
        // <div class='mt-1em' id='div_input_jml'></div>
        // ";

        // $available_options = "
        // <div style='display:inline-block' id='div_option_jml'></div>
        // <div style='display:inline-block' id='div_option_ktrg'></div>
        // ";

        $data = [
            'judul' => 'SJ T.SixPack/Japstyle',
            'tipe' => 'spjap',
            'spjaps' => $label_spjaps,
            'd_bahan_a' => $d_bahan_a,
            'd_bahan_b' => $d_bahan_b,
            // 'element_properties' => $element_properties,
            // 'available_options' => $available_options,
            'att_spjap' => $att_spjap,
            'mode' => 'SPK_BARU',
            'produk' => null,
            'spk_item' => null,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_std()
    {
        $label_stds = fetchStandar()->label_stds();
        $att_std = fetch_att_std();

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
            // 'element_properties' => $element_properties,
            // 'available_options' => $available_options,
            'att_std' => $att_std,
            'mode' => 'SPK_BARU',
            'produk' => null,
            'spk_item' => null,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_tankpad()
    {
        $label_tankpad = fetchTankpad()->label_tp();
        $att_tp = fetch_att_tp();

        $data = [
            'judul' => 'Tankpad',
            'tipe' => 'tankpad',
            'tankpads' => $label_tankpad,
            // 'element_properties' => $element_properties,
            // 'available_options' => $available_options,
            'att_tp' => $att_tp,
            'mode' => 'SPK_BARU',
            'produk' => null,
            'spk_item' => null,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_busastang()
    {
        $label_busastang = fetchBusastang()->label_busastang();
        $att_busastang = fetch_att_busastang();

        $data = [
            'mode' => 'SPK_BARU',
            'tipe' => 'busastang',
            'busastangs' => $label_busastang,
            'att_busastang' => $att_busastang,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_stiker()
    {
        $label_stiker = fetchStiker()->label_stiker();
        $att_stiker = fetch_att_stiker();

        $data = [
            'mode' => 'SPK_BARU',
            'tipe' => 'stiker',
            'stikers' => $label_stiker,
            'att_stiker' => $att_stiker,
            'spk_item' => null,
            'produk' => null,
        ];
        return view('spk.inserting_spk_item-2', $data);
    }

    public function inserting_item_db(Request $request)
    {
        $load_num = SiteSetting::find(1);
        if ($load_num !== 0) {
            $load_num->value = 0;
            $load_num->save();
        }

        $show_dump = true;
        $show_hidden_dump = false;
        $run_db = true;
        $load_num_ignore = true;

        if ($show_hidden_dump === true) {
            dump("load_num_value: " . $load_num->value);
        }

        if ($load_num->value > 0 && $load_num_ignore === false) {
            $run_db = false;
        }

        $post = $request->all();

        if ($show_dump === true) {
            dump($post);
            dump($post);
        }

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
        $standar_id = $kombi_id = $busastang_id = $tankpad_id = $spjap_id = $tipe_bahan = $stiker_id = null;

        if (isset($post['bahan_id'])) {
            $bahan_id = $post['bahan_id'];
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
            $variasi_id = $variasi['id'];
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
            $harga = $post['spjap_harga'];
            $tipe_bahan = $post['tipe_bahan'];
            $bahan = $post['bahan'];
            if ($bahan !== null) {
                $nama = "$bahan $nama";
            } else {
                $nama = "Bahan($tipe_bahan) $nama";
            }
            $nama_nota = $nama;
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
            'tipe_bahan' => $tipe_bahan,
            'stiker_id' => $stiker_id,
            'nama' => $nama,
            'nama_nota' => $nama_nota,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'ktrg' => $ktrg,
        ]);

        $spk_item = DB::table('temp_spk_produk')->get();
        $data = ['spks' => $post, 'spk_item' => $spk_item, 'go_back_number' => -2];
        $request->session()->put('reload_page', true);
        return view('layouts.go-back-page', $data);
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
