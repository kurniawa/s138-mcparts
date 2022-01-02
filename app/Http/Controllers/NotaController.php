<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Pelanggan;
use App\Spk;
use Illuminate\Http\Request;
use App\SpkNotas;
use App\SpkProduk;

class NotaController extends Controller
{
    //
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


        $notas = Nota::limit(100)->orderByDesc('created_at')->get();
        $pelanggans = array();
        for ($i = 0; $i < count($notas); $i++) {
            $pelanggan = Nota::find($notas[$i]->id)->pelanggan;
            array_push($pelanggans, $pelanggan);
        }
        // $pelanggan = Pelanggan::find(3)->spk;
        // dd($pelanggans);
        $data = ['notas' => $notas, 'pelanggans' => $pelanggans, 'reload_page' => $reload_page];
        // $data = ['notas' => $notas, 'pelanggans' => $pelanggans];
        return view('nota/notas', $data);
    }

    public function notaBaru_pilihSPK(Request $request)
    {
        /**
         * Form pilihan spk yang ingin dibuatkan nota nya akan muncul. Daftar spk yang ada di pilihan adalah SPK dengan status "SELESAI"
         * atau "SEBAGIAN"
         */
        $available_spk = Spk::where('status', 'SEBAGIAN')->orWhere('status', 'SELESAI')->get();
        // dump('available_spk');
        // dump($available_spk);

        $data = [
            'csrf' => csrf_token(),
            'available_spk' => $available_spk,
        ];
        return view('nota/nota_baru-pilih_spk', $data);
    }

    public function notaBaru_pSPK_pItem(Request $request)
    {
        /**
         * Setelah pilih SPK, maka sudah semestinya langsung ke pilih Item. Karena ini konsepnya kita akan membuat Nota Baru.
         * Ada beberapa kasus yang perlu diperhatikan disini:
         * 1) SPK yang belum sepenuhnya selesai semua tapi sebagian yang sudah kelar ingin dibuatkan nota dan surat jalan terlebih dahulu
         * * Ini artinya dalam satu SPK bisa 'memiliki' lebih dari satu nota.
         * 
         * * Lalu misal salah satu item di SPK berjumlah 300, maka ini juga bisa di split, misal yang ingin dibuatkan nota terlebih dahulu
         * * Hanya yang 150 nya saja.
         * 
         * Sebelum melakukan itu semua, kita perlu mencari spk dari spk_id yang di post, supaya dapat get pelanggan_id dan get pelanggan
         * 
         * Lalu kita perlu juga untuk get spk_item dari table spk_produks. Supaya nanti bisa di tampilkan daftar pilihan item yang dapat dibuat nota.
         * Daftar Item yang dapat dibuat nota tentunya adalah item yang telah selesai proses produksi dan juga item tersebut belum di input
         * ke dalam nota yang lain. Oleh karena itu kita perlu untuk edit table spk_produks yang sekarang, harus ditambahkan column nota_jumlah.
         * Dengan data Type Varchar(255) dan value nya nanti adalah string json.
         * Untuk memudahkan lagi, kita coba untuk menambahkan column sudah_nota dengan value yang juga sebagai string dengan contoh value nya misalnya
         * 'SEBAGIAN' atau 'SEMUA' atau 'BELUM. Kalo sebagian brrti sudah dimasukkan ke dalam nota sebagian, kalo semua brrti sudah semua nya diinput ke nota
         * kalo belum berrti belum diinput ke nota sama sekali. 
         * 
         * SPK sudah dipilih dan di send via post. spk_id diketahui, otomatis spk_item yang berkaitan dengan spk_id juga dapat diketahui.
         * 
         */

        $post = $request->input();
        dump('post');
        dump($post);

        $spk_id = $post['spk_id'];
        $spk_this = Spk::find($spk_id);
        $pelanggan_this = Pelanggan::find($spk_this['pelanggan_id']);
        $spk_item_available = SpkProduk::where('spk_id', $spk_id)->where('status_nota', 'BELUM')->orWhere('status_nota', 'SEBAGIAN')->get();
        dump('spk_item_available');
        dump($spk_item_available);


        // $spk_nota_this = SpkNotas::where('spk_id', $spk_id)->get();
        // dump('spk_nota dengan spk_id ini');
        // dump($spk_nota_this);

        // $available_nota = [];
        // for ($i = 0; $i < count($spk_nota_this); $i++) {
        //     $available_nota_temp = Nota::find($spk_nota_this[$i]['nota_id']);
        //     array_push($available_nota, $available_nota_temp);
        // }
        // dump('available_nota');
        // dump($available_nota);

        $data = [
            'csrf' => csrf_token(),
            'spk' => $spk_this,
            'pelanggan' => $pelanggan_this,
            // 'date_today' => date('Y-m-d\TH:i:s'),
        ];
        return view('nota/notaBaru-pSPK-pItem', $data);
    }

    public function notaBaru_pilihSPK_pilihNota(Request $request)
    {
        /**
         * Setelah pilih SPK, maka sudah semestinya langsung ke pilih Item
         */

        $post = $request->input();
        dump('post');
        dump($post);

        $spk_id = $post['spk_id'];
        $spk_nota_this = SpkNotas::where('spk_id', $spk_id)->get();
        dump('spk_nota dengan spk_id ini');
        dump($spk_nota_this);

        $available_nota = [];
        for ($i = 0; $i < count($spk_nota_this); $i++) {
            $available_nota_temp = Nota::find($spk_nota_this[$i]['nota_id']);
            array_push($available_nota, $available_nota_temp);
        }
        dump('available_nota');
        dump($available_nota);

        $data = [
            'csrf' => csrf_token(),
            'available_nota' => $available_nota,
            'spk_id' => $spk_id
        ];
        return view('nota/nota_baru-pilih_spk-pilih_nota', $data);
    }

    public function notaBaru_pSPK_pNota_pItem(Request $request)
    {
        /**
         * SPK sudah dipilih dan di send via post. spk_id diketahui, otomatis spk_item yang berkaitan dengan spk_id juga dapat diketahui.
         * Ada 2 kasus yang perlu ditangani via Controller dan halaman ini:
         * 1) Nota baru
         * 2) Nota yang sudah ada
         * Apabila sebelumnya terpilih nota baru, maka kita perlu tau item apa saja yang ada di spk ini dan apakah item tersebut sudah sempat diinput ke nota atau
         */
        $post = $request->input();
        dump('post');
        dump($post);

        $spk_id = $post['spk_id'];


        $data = [
            'csrf' => csrf_token(),
            // 'available_spk' => $available_spk
        ];
        return view('nota/nota_baru-pSPK-pNota-pItem', $data);
    }
}
