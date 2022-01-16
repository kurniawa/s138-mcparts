<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Pelanggan;
use App\Produk;
use App\SiteSetting;
use App\Spk;
use App\SpkcpNota;
use Illuminate\Http\Request;
use App\SpkNotas;
use App\SpkProduk;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    //
    public function index(Request $request)
    {
        // dump($this->site_settings[0]->value);
        // $this->site_settings[0]->value = 'TRUE';
        // $this->site_settings->save();
        // dump($this->site_settings[0]['value']);

        // Metode untuk reset value pada pencegahan reload pada insert dan update DB
        $load_num = SiteSetting::find(1);
        if ($load_num['value'] > 0) {
            $load_num->value = 0;
            $load_num->save();
        }
        // END: metode untuk reset value: pencegahan reload pada halaman insert dan update DB

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
        $reload_page = $request->session()->get('reload_page');
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }
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

        $get = $request->input();
        dump('get');
        dump($get);

        $spk_id = $get['spk_id'];
        $spk_this = Spk::find($spk_id);
        $pelanggan_this = Pelanggan::find($spk_this['pelanggan_id']);

        /**
         * nota_item_available Tadinya di ambil langsung dari table SpkProduk. Namun karena di table spk terdapat data yang sama
         * dan juga lebih lengkap karena disertai juga dengan nama nya, maka kita consider jg untuk ambil data dari table spk
         */
        $nota_item_av = SpkProduk::where('spk_id', $spk_id)->where('status_nota', 'BELUM')->orWhere('status_nota', 'SEBAGIAN')->get();
        dump('nota_item_av');
        dump($nota_item_av);
        // dd($nota_item_av);

        $produks = array();

        for ($i = 0; $i < count($nota_item_av); $i++) {
            $produk = Produk::find($nota_item_av[$i]['produk_id']);
            array_push($produks, $produk);
        }

        // dd('produks: ', $produks);
        dump('produks: ', $produks);


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
            'nota_item_av' => $nota_item_av,
            'produks' => $produks,
            'tgl_nota' => date('Y-m-d\TH:i:s'),
            'reload_page' => $reload_page,
        ];
        return view('nota/notaBaru-pSPK-pItem', $data);
    }

    public function notaBaru_pSPK_pItem_DB(Request $request)
    {
        // Tindakan pencegahan salah kepencet reload
        $load_num = SiteSetting::find(1);

        $post = $request->input();
        dump('post');
        dump($post);
        /**
         * Mulai insert ke table notas, maka kita perlu mengetahui pelanggan_id, reseller_id terlebih dahulu.
         * Ini diketahui dari SPK
         * 
         * data_nota_item: produk_id, nama_nota, jml_item, hrg_per_item, hrg_total_item
         */

        $spk = Spk::find($post['spk_id']);

        $d_spk_produk_id = $post['spk_produk_id'];

        $data_nota_item = array();
        $hrg_total_nota = 0;
        $index_nota_jml_kpn = array(); // Untuk nanti setelah insert nota, bisa balik lagi ke spk_produk untuk edit nota_id

        $d_spkcpnota_id = array();
        for ($i = 0; $i < count($d_spk_produk_id); $i++) {
            $spk_produk = SpkProduk::find($d_spk_produk_id[$i]);
            // $spkcpnota = SpkcpNota::where('spkcp_id', $spk_produk['id']);
            dump('spk_produk: ', $spk_produk);
            $produk = Produk::find($spk_produk['produk_id']);

            $hrg_per_item = $spk_produk['harga'];

            if ($spk_produk['koreksi_harga'] !== null && $spk_produk['koreksi_harga'] !== '') {
                $hrg_per_item += $spk_produk['koreksi_harga'];
            }

            $hrg_total_item = (int)$hrg_per_item * (int)$post['jml_input'][$i];
            $hrg_total_nota += $hrg_total_item;

            $nota_item = [
                'produk_id' => $produk['id'],
                'nama_nota' => $produk['nama_nota'],
                'jml_item' => $post['jml_input'][$i],
                'hrg_per_item' => $hrg_per_item,
                'hrg_total_item' => $hrg_total_item,
            ];

            array_push($data_nota_item, $nota_item);

            // MULAI INSERT KE nota_produks
            // Disini aku sementara mau abaikan dulu table nota_produks, karena sudah ada json nya di table notas
            // notas, nota_produks, spk_notas

            // DB::table('nota_produks')->insert([
            //     'spk_id' => $spk['id'],
            //     'produk_id' => $produk['id'],
            //     'jumlah' => $post['jml_input'][$i],
            //     'harga' => $hrg_per_item,
            //     'koreksi_harga' => $spk_produk['koreksi_harga'],
            // ]);

            // UPDATE spk_produks kolom nota_jml_kapan dan status_nota

            $d_nota_jml_kapan = array();

            $jml_sdh_nota = $spk_produk['jml_sdh_nota']; // Secara defaulut value=0 sudah diatur pada pembuatan database nya
            // Concern Untuk KOLOM status_nota pada spk_produk

            if ($spk_produk['nota_jml_kapan'] !== null && $spk_produk['nota_jml_kapan'] !== '') {
                $d_nota_jml_kapan = json_decode($spk_produk['nota_jml_kapan'], true);

                // Concern untuk kolom status_nota pada spk_produk, maka kita perlu mengetahui jumlah item yang sudah nota
                // supaya bisa dibandingkan dengan jumlah_item yang sebenarnya
                for ($i2=0; $i2 < count($d_nota_jml_kapan); $i2++) { 
                    $jml_sdh_nota += $d_nota_jml_kapan[$i2]['jml_item'];
                }
            }

            $nota_jml_kapan = [
                'nota_id' => '',
                'jml_item' => $post['jml_input'][$i],
                'tgl_input' => date('Y-m-d\TH:i:s'),
            ];

            $jml_sdh_nota += $post['jml_input'][$i];
            $status_nota = 'BELUM';

            $jml_total_item_ini = $spk_produk['jumlah'] + $spk_produk['deviasi_jml'];

            if ($jml_sdh_nota === $jml_total_item_ini) {
                $status_nota = 'SEMUA';
            } else if ($jml_sdh_nota > 0) {
                $status_nota = 'SEBAGIAN';
            }

            array_push($d_nota_jml_kapan, $nota_jml_kapan);

            array_push($index_nota_jml_kpn, count($d_nota_jml_kapan) - 1);

            dump('d_nota_jml_kapan: ', $d_nota_jml_kapan);
            $spk_produk->nota_jml_kapan = $d_nota_jml_kapan;
            $spk_produk->jml_sdh_nota = $jml_sdh_nota;
            $spk_produk->status_nota = $status_nota;

            if ($load_num['value'] === 0) {
                // to comment:
                $spk_produk->save();
            }

            // to comment
            $spkcpnota_id = DB::table('spkcp_notas')->insertGetId([
                'spkcp_id' => $spk_produk['id'],
                'jml' => $post['jml_input'][$i]
            ]);

            array_push($d_spkcpnota_id, $spkcpnota_id);
            // to recomment
            array_push($d_spkcpnota_id, $i);
        }

        // CEK SEMUA YANG PERLU DIINSERT
        dump('INSERT TABLE nota');
        dump([
            'pelanggan_id' => $spk['pelanggan_id'],
            'reseller_id' => $spk['reseller_id'],
            'status' => 'PROSES',
            'data_nota_item' => json_encode($data_nota_item),
            'harga_total' => $hrg_total_nota,
        ]);

        dump('INSERT TABLE spk_notas', [
            'spk_id' => $spk['id'],
            'nota_id' => 'Dari insertGetId sebelumnya dulu',
        ]);

        // MULAI INSERT

        $nota_id = '?';
        if ($load_num['value'] === 0) {
            // to comment:
            $nota_id = DB::table('notas')->insertGetId([
                'pelanggan_id' => $spk['pelanggan_id'],
                'reseller_id' => $spk['reseller_id'],
                'status' => 'PROSES',
                'data_nota_item' => json_encode($data_nota_item),
                'harga_total' => $hrg_total_nota,
            ]);
            DB::table('spk_notas')->insert([
                'spk_id' => $spk['id'],
                'nota_id' => $nota_id,
            ]);
            
        }

        // UPDATE spk_produk dan spkcpnota

        // to recomment
        // DB::table('spkcp_notas')->insert([
        //     'spkcp_id' => 1,
        //     'jml' => 150
        // ]);

        for ($i3 = 0; $i3 < count($d_spk_produk_id); $i3++) {
            $spk_produk = SpkProduk::find($d_spk_produk_id[$i3]);
            $nota_jml_kapan = json_decode($spk_produk['nota_jml_kapan'], true);
            dump('nota_jml_kapan: ', $nota_jml_kapan);
            dump('index_nota_jml_kpn[$i3]: ', $index_nota_jml_kpn[$i3]);
            $nota_jml_kapan[$index_nota_jml_kpn[$i3]]['nota_id'] = $nota_id;
            $spk_produk->nota_jml_kapan = $nota_jml_kapan;
            
            dump('spk_produk_new: ', $spk_produk);
            
            // to comment
            $spkcpnota = SpkcpNota::where('spkcp_id', $d_spk_produk_id[$i3])->latest()->get();
            // to recomment
            // $spkcpnota = SpkcpNota::where('spkcp_id', 1)->latest()->get();
            dump('spkcpnota:', $spkcpnota);
            // to comment
            $spkcpnota = SpkcpNota::find($spkcpnota[0]['id']);
            // to recomment
            // $spkcpnota = SpkcpNota::find(1);
            // to comment
            $spkcpnota->nota_id = $nota_id;
            

            if ($load_num['value'] === 0) {
                // to comment
                $spk_produk->save();
                $spkcpnota->save();
            }

        }

        // UPDATE NO NOTA

        // to-comment
        $nota = Nota::find($nota_id);
        $nota->no_nota = "N-$nota_id";

        if ($load_num['value'] === 0) {
            // to-comment
            $nota->save();
        }

        $data = [
            'go_back_number' => -1,
        ];

        $load_num->value = $load_num['value'] + 1;
        $load_num->save();
        return view('layouts.go-back-page', $data);
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

    public function nota_detailNota(Request $request)
    {
        $get = $request->input();
        // dump('get');
        // dump($get);

        $nota_id = $get['nota_id'];

        $nota = Nota::find($nota_id);

        /**
         * PENGEN CARI TAU, SPKCPNota
         * implementasi nya sama2 merasa rumit, jadi kita jalanin aja pake JSON dlu.
         */

        $d_spkNota = SpkNotas::where('nota_id', $nota_id)->get();

        dump('d_spkNota: ', $d_spkNota);

        for ($i=0; $i < count($d_spkNota); $i++) { 
            
        }


        $data = [
            'csrf' => csrf_token(),
            'nota' => $nota,
            // 'available_spk' => $available_spk
        ];
        return view('nota/nota-detailNota', $data);
    }

    public function nota_printOut(Request $request)
    {
        $get = $request->input();
        // dump('get');
        // dump($get);

        $nota_id = $get['nota_id'];

        $nota = Nota::find($nota_id);

        $pelanggan = Pelanggan::find($nota['pelanggan_id']);

        $reseller = 'none';
        if ($nota['reseller_id'] !== null && $nota['reseller_id'] !== '') {
            $reseller = Pelanggan::find($nota['reseller_id']);
        }


        $data = [
            'csrf' => csrf_token(),
            'nota' => $nota,
            'pelanggan' => $pelanggan,
            'reseller' => $reseller,
            // 'available_spk' => $available_spk
        ];
        return view('nota/nota-printOut', $data);
    }
}
