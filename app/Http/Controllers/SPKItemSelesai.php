<?php

namespace App\Http\Controllers;

use App\Pelanggan;
use App\Spk;
use Illuminate\Http\Request;
use App\SpkProduk;
use Illuminate\Support\Arr;

class SPKItemSelesai extends Controller
{
    public function index(Request $request)
    {
        $reload_page = $request->session()->get('reload_page');
        // $reload_page = true;
        if ($reload_page === true) {
            $request->session()->put('reload_page', false);
        }

        $get = $request->input();
        dump($get);
        // dd($get);

        $spk = Spk::find($get['spk_id']);
        dump('SPK');
        dump($spk);

        $pelanggan = Pelanggan::find($spk['pelanggan_id']);
        dump('pelanggan');
        dump($pelanggan);

        dump('data_spk_item');
        $data_spk_item = $spk['data_spk_item'];
        dump($data_spk_item);
        $data_spk_item = json_decode($data_spk_item, true);
        // dd($data_spk_item);
        dump($data_spk_item);

        $tgl_pembuatan = date('Y-m-d', strtotime($spk['created_at']));
        $tgl_pembuatan_dmY = date('d-m-Y', strtotime($tgl_pembuatan));

        $spk_produks = SpkProduk::where('spk_id', $spk['id'])->get();
        dump('spk_produks');
        dump($spk_produks);

        // $jmlSelesai_kapan = array();
        // for ($i=0; $i < count($spk_produks); $i++) { 
        //     if ($spk_produks[$i]['jmlSelesai_kapan'] !== null && $spk_produks[$i]['jmlSelesai_kapan'] !== '') {
        //         array_push($jmlSelesai_kapan, )
        //     }
        // }

        $data = [
            'spk' => $spk,
            'pelanggan' => $pelanggan,
            'data_spk_item' => $data_spk_item,
            'tgl_pembuatan' => $tgl_pembuatan,
            'tgl_pembuatan_dmY' => $tgl_pembuatan_dmY,
            'csrf' => csrf_token(),
            'reload_page' => $reload_page,
            'spk_produks' => $spk_produks,
        ];

        return view('spk.penetapan_item_selesai', $data);
    }

    public function setItemSelesai(Request $request)
    {
        /**
         * Ketika men set item spk selesai, yang perlu diperhatikan adalah:
         * 1) Item yang di set sebagai selesai, berupa array, jadi penanganan nya dengan
         * menggunakan loop. Hanya spk_id saja yang tidak perlu di loop.
         * 2) Apabila ada deviasi jumlah, maka ini akan mempengaruhi jumlah_total
         * dan maksimal dari jml_selesai seharusnya
         * 
         */
        $post = $request->input();
        dump('post');
        dump($post);

        // dd($post);

        // 1)
        /**
         * Sebelum melanjutkan poin 1, yaitu sebelum looping, sebaiknya concern terlebih dahulu
         * ke SPK, supaya pada saat looping juga bisa skalian mengubah data_spk_item
         */
        $spk = Spk::find($post['spk_id']);
        $str_data_spk_item_old = $spk['data_spk_item'];

        dump('data_spk_item_old');
        dump($str_data_spk_item_old);
        $data_spk_item_old = json_decode($str_data_spk_item_old, true);
        dump($data_spk_item_old);
        $data_spk_item_new = $data_spk_item_old;

        $d_spk_produk_id = $post['spk_produk_id'];

        /**
         * Jumlah total mengacu pada jumlah item seharusnya baik yang selesai atau yang belum.
         */
        $jumlah_total_old = (int)$spk['jumlah_total'];
        $harga_total_old = (int)$spk['harga_total'];
        $jumlah_total_new = $jumlah_total_old;
        $harga_total_new = $harga_total_old;

        for ($i = 0; $i < count($d_spk_produk_id); $i++) {
            /** DEFINISI VARIABLE AWAL */
            $spk_produk_this = SpkProduk::find($d_spk_produk_id[$i]);
            // dump('spk_produk_this');
            // dump($spk_produk_this);
            $deviasi_jml = (int)$post['deviasi_jml'][$i];
            $tbh_jml_selesai = (int)$post['tbh_jml_selesai'][$i];
            // $jumlah_akhir adalah jumlah masing-masing item setelah adanya deviasi jumlah
            $jumlah_akhir = $spk_produk_this['jumlah'] + $deviasi_jml;
            $harga_item = $spk_produk_this['harga'];
            $harga_total_item = 0;

            // status sebelumnya
            $status = $spk_produk_this['status'];

            $jmlSelesai_kapan = $spk_produk_this['jmlSelesai_kapan'];

            $jml_selesai_old = $spk_produk_this['jml_selesai'];

            $i_jmlSelesai_kapan = 0;

            if ($jmlSelesai_kapan !== null && $jmlSelesai_kapan !== '') {
                $jmlSelesai_kapan = json_decode($jmlSelesai_kapan, true);
                $i_jmlSelesai_kapan = count($jmlSelesai_kapan);
                /**
                 * index dimulai dari nol, sedangkan jumlah count dimulai dari angka 1, sehingga jumlah count
                 * dapat menjadi index tahap berikutnya.
                 */
            } else {
                $jmlSelesai_kapan = array();
                dump('jmlSelesai_kapan');
                dump($jmlSelesai_kapan);
            }

            // 2)
            // dump('jumlah_akhir');
            // dump($jumlah_akhir);
            if ($deviasi_jml !== 0) {
                if ((int)$spk_produk_this['deviasi_jml'] !== $deviasi_jml) {
                    $deviasi_jml_old = $spk_produk_this['deviasi_jml'];
                    if ($deviasi_jml_old === null) {
                        $deviasi_jml_old = 0;
                    }
                    $diff_deviasi_jml = $deviasi_jml_old - $deviasi_jml;
                    /**
                     * misal deviasi_jml sebelumnya lebi besar daripada deviasi jmlh yang saat ini diinput:
                     * 10 - 5 = 5
                     * -2 - (-8) = 6
                     * jumlah akhir yang tadinya 110 misal, menjadi:
                     * 110 - 5 = 105
                     * 98 - 6 = 92
                     */
                    $jumlah_akhir -= $diff_deviasi_jml;
                    $jumlah_total_new -= $diff_deviasi_jml;
                    $harga_total_new -= $diff_deviasi_jml * $harga_item;

                    //
                }
            }

            // $jumlah_akhir += $deviasi_jml;
            // $jumlah_total_new += $jumlah_akhir;
            // $harga_total_new += $jumlah_akhir * $harga_item;

            $jml_selesai_new = $jml_selesai_old + $tbh_jml_selesai;

            // Apabila memang ada inputan penambahan jml_selesai, jadi bukan hanya inputan deviasi_jml saja, baru dihitungin semua nya dan
            // diubah isi JSON jmlSelesai_kapan

            // 305, 160
            dump($jml_selesai_new, $jumlah_akhir);
            if ($jml_selesai_new <= $jumlah_akhir && $jml_selesai_new >= 0 && $tbh_jml_selesai > 0) {
                // Apabila sebelumnya memang belum ada item yang selesai
                if (count($jmlSelesai_kapan) === 0) {
                    $arrToPush = [
                        'tahap' => 1,
                        'jmlSelesai' => $tbh_jml_selesai,
                        'tglSelesai' => date('Y-m-d', strtotime($post['tgl_selesai'][$i])),
                    ];

                    array_push($jmlSelesai_kapan, $arrToPush);
                } else {
                    // Apabila memang sebelumnya sudah ada yang selesai dan juga checkbox tahapan di klik
                    if (isset($post['tahapan'])) {
                        dump('tahapan');
                        $i_tahapan = $post['tahapan'][$i];
                        dump($i_tahapan);

                        // Apabila tahapan di klik, maka kita perlu tau, apakah tahapan yang dipilih adalah tahapan yang sudah
                        // pernah dipilih sebelumnya. Kalo iya maka:
                        // Dicari dulu index tahapan yang sudah ada di JSON array urutan ke berapa
                        $tahap_new = (int)$post["tahap-$i_tahapan"];
                        dump('tahap_new: ', $tahap_new);

                        $i_tahap_sama = 0;
                        for ($i2 = 0; $i2 < count($jmlSelesai_kapan); $i2++) {
                            if ($tahap_new === $jmlSelesai_kapan[$i2]['tahap']) {
                                $i_tahap_sama = $i2;
                                break;
                            }
                        }
                        if ($i_tahap_sama === 0) {
                            // disini berrti tidak ada tahap yang sama, otomatis ini merupakan tahap yang baru
                            $arrToPush = [
                                'tahap' => $tahap_new,
                                'jmlSelesai' => $tbh_jml_selesai,
                                'tglSelesai' => date('Y-m-d', strtotime($post["tgl_selesai_dd-$i"])),
                            ];

                            array_push($jmlSelesai_kapan, $arrToPush);
                        } else {
                            // disini brrti tahap yang sama, artinya JSON yang sebelumnya diganti dengan ini
                            $jmlSelesai_kapan[$i_tahap_sama] = [
                                'tahap' => $post["tahap-$i"],
                                'jmlSelesai' => $tbh_jml_selesai,
                                'tglSelesai' => date('Y-m-d', strtotime($post["tgl_selesai_dd-$i"])),
                            ];
                        }

                        // dump('arrToPush');
                        // dd($arrToPush);
                    } else {
                    }
                }
            } else if ($tbh_jml_selesai < 0 && $jumlah_akhir >= $tbh_jml_selesai) {
                // INI ADALAH KASUS PENGURANGAN. Untuk masuk ke instruksi disini, maka $tbh_jml_selesai harus minus dan $jumlah_akhir harus >= dari $tbh_jml_selesai
                // Disini juga akan diperhatikan TAHAPAN nya
                if (isset($post['tahapan'])) {
                    dump('tahapan');
                    $i_tahapan = $post['tahapan'][$i];
                    dump($i_tahapan);

                    // Apabila tahapan di klik, maka kita perlu tau, apakah tahapan yang dipilih adalah tahapan yang sudah
                    // pernah dipilih sebelumnya. Kalo iya maka:
                    // Dicari dulu index tahapan yang sudah ada di JSON array urutan ke berapa
                    $tahap_new = (int)$post["tahap-$i_tahapan"];
                    dump('tahap_new: ', $tahap_new);

                    $i_tahap_sama = 0;
                    $i_tahap_sebelumnya = array();
                    for ($i2 = 0; $i2 < count($jmlSelesai_kapan); $i2++) {
                        if ($i2 - 1 !== 0) {
                            $i_tahap_sebelum_temp = $i2 - 1;
                            array_push($i_tahap_sebelumnya, $i_tahap_sebelum_temp);
                        }
                        if ($tahap_new === $jmlSelesai_kapan[$i2]['tahap']) {
                            $i_tahap_sama = $i2;
                            array_push($i_tahap_sebelumnya, $i2);
                            break;
                        }
                    }
                    if ($i_tahap_sama === 0) {
                        // disini berrti tidak ada tahap yang sama, otomatis pemilihan tahapan akan diabaikan
                        // akan mengurangi otomatis dari tahapan sebelumnya apabila ada.
                        if (count($i_tahap_sebelumnya) !== 0) {
                            $sisa_pengurangan_jml_selesai = $tbh_jml_selesai;
                            $i_yang_perlu_hilang = array();
                            $i_yg_prlu_edit = '?';

                            for ($i3 = count($i_tahap_sebelumnya) - 1; $i3 >= 0; $i3--) {
                                if ($jmlSelesai_kapan[$i3]['jmlSelesai'] < $sisa_pengurangan_jml_selesai) {
                                    $sisa_pengurangan_jml_selesai = $jmlSelesai_kapan[$i3]['jmlSelesai'] + $sisa_pengurangan_jml_selesai;
                                    // array_push($i_yang_perlu_hilang, $i3);
                                    unset($jmlSelesai_kapan, $i3);
                                    array_values($jmlSelesai_kapan);
                                } else if ($jmlSelesai_kapan[$i3]['jmlSelesai'] === $sisa_pengurangan_jml_selesai) {
                                    $sisa_pengurangan_jml_selesai = 0;
                                    // array_push($i_yang_perlu_hilang, $i3);
                                    unset($jmlSelesai_kapan, $i3);
                                    array_values($jmlSelesai_kapan);
                                } else if ($jmlSelesai_kapan[$i3]['jmlSelesai'] > $sisa_pengurangan_jml_selesai) {
                                    $jmlSelesai_kapan[$i3]['jmlSelesai'] = $jmlSelesai_kapan[$i3]['jmlSelesai'] - $sisa_pengurangan_jml_selesai;
                                }
                            }
                        }

                        // $arrToPush = [
                        //     'tahap' => $tahap_new,
                        //     'jmlSelesai' => $tbh_jml_selesai,
                        //     'tglSelesai' => date('Y-m-d', strtotime($post["tgl_selesai_dd-$i"])),
                        // ];

                        // array_push($jmlSelesai_kapan, $arrToPush);
                    } else {
                        // disini brrti tahap yang sama, artinya JSON yang sebelumnya diganti dengan ini
                        $jmlSelesai_kapan[$i_tahap_sama] = [
                            'tahap' => $post["tahap-$i"],
                            'jmlSelesai' => $tbh_jml_selesai,
                            'tglSelesai' => date('Y-m-d', strtotime($post["tgl_selesai_dd-$i"])),
                        ];
                    }

                    // dump('arrToPush');
                    // dd($arrToPush);
                } else {
                    // Disini apabila pengurangan tidak memperhatikan tahapan, otomatis pemilihan tahapan akan diabaikan
                    // akan mengurangi otomatis dari tahapan sebelumnya apabila ada.
                    $sisa_pengurangan_jml_selesai = $tbh_jml_selesai;

                    for ($i3 = count($jmlSelesai_kapan) - 1; $i3 >= 0; $i3--) {
                        if ($jmlSelesai_kapan[$i3]['jmlSelesai'] < $sisa_pengurangan_jml_selesai) {
                            $sisa_pengurangan_jml_selesai = $jmlSelesai_kapan[$i3]['jmlSelesai'] + $sisa_pengurangan_jml_selesai;
                            // array_push($i_yang_perlu_hilang, $i3);
                            unset($jmlSelesai_kapan, $i3);
                            array_values($jmlSelesai_kapan);
                        } else if ($jmlSelesai_kapan[$i3]['jmlSelesai'] === $sisa_pengurangan_jml_selesai) {
                            $sisa_pengurangan_jml_selesai = 0;
                            // array_push($i_yang_perlu_hilang, $i3);
                            unset($jmlSelesai_kapan, $i3);
                            array_values($jmlSelesai_kapan);
                            break;
                        } else if ($jmlSelesai_kapan[$i3]['jmlSelesai'] > $sisa_pengurangan_jml_selesai) {
                            $jmlSelesai_kapan[$i3]['jmlSelesai'] = $jmlSelesai_kapan[$i3]['jmlSelesai'] + $sisa_pengurangan_jml_selesai;
                            break;
                        }
                    }
                }
            } else {

                if ($jml_selesai_new > $jumlah_akhir) {
                    dump('ada error di perhitungan');
                    dump('Jumlah item yang telah selesai, melebihi jumlah item yang telah ditetapkan sebelumnya!');
                    $request->session()->put('reload_page', true);

                    $data = [
                        'go_back_number' => -2,
                    ];

                    return view('layouts.go-back-page', $data);
                }
            }

            if ($jml_selesai_new === $jumlah_akhir) {
                $status = 'SELESAI';
            } elseif ($jml_selesai_new !== 0) {
                $status = 'SEBAGIAN';
            }

            $spk_produk_this->deviasi_jml = $deviasi_jml;
            $spk_produk_this->jml_selesai = $jml_selesai_new;

            // Supaya di database tetap null di bagian jmlSelesai_kapan nya, apabila memang tidak ada perubahan
            if (count($jmlSelesai_kapan) !== 0) {
                $spk_produk_this->jmlSelesai_kapan = json_encode($jmlSelesai_kapan);
            }

            $spk_produk_this->status = $status;

            $finished_at = date('Y-m-d', strtotime($post['tgl_selesai'][$i]));
            // $spk_produk_this->finished_at = $finished_at;

            /**
             * Cara update kolom baru: jmlSelesai_kapan, nota_jml_kapan dan status_nota
             * Cara updatenya berbeda karena jmlSelesai_kapan dan nota_jml_kapan berbentuk string json
             */
            // $jmlSelesai_kapan_this = $spk_produk_this->jmlSelesai_kapan;


            $spk_produk_this->save();

            /**
             * UPDATE DATABASE SPK
             * ===================
             * Setelah update table spk_produks, maka perlu update pula jumlah total dan harga total nya
             * yang tercantum pada table spk tapi coding update nya nanti di luar looping
             * Selain itu perlu juga untuk update status. (-UPDATE STATUS SPK-)
             * --Kalau spk_item belum ada yang selesai, status tetap tertulis 'PROSES'
             * --Kalau spk_item ada yang selesai atau selesai sebagian, status spk harus tertulis 'SEBAGIAN'
             * --Kalau semua spk_item sudah selesai maka status spk jadi tertulis 'SELESAI'
             */

            /**
             * disini mulai update array dari data_spk_item. Untuk update database spk nya masih nanti setelah looping
             * selesai.
             */
            $index_data_spk_item = '';
            for ($j = 0; $j < count($data_spk_item_old); $j++) {
                if ($data_spk_item_old[$j]['spk_produk_id'] === (int)$spk_produk_this['id']) {
                    $index_data_spk_item = $j;
                    break;
                } else {
                    $index_data_spk_item = 'NOT FOUND!';
                }
            }
            dump('index_data_spk_item');
            dump($index_data_spk_item);

            $data_spk_item_new[$index_data_spk_item]['deviasi_jml'] = $deviasi_jml;
            $data_spk_item_new[$index_data_spk_item]['jml_selesai'] = $jml_selesai_new;
            $data_spk_item_new[$index_data_spk_item]['status'] = $status;
        }

        /**
         * -UPDATE STATUS SPK-
         */
        $spk_produk = SpkProduk::where('spk_id', $spk['id'])->get();
        dump('UPDATE STATUS SPK: spk_produk');
        dump($spk_produk);

        $spk_status = $spk->status;

        for ($i = 0; $i < count($spk_produk); $i++) {
            if ($spk_produk[$i]['status'] !== 'PROSES') {
                $spk_status = 'SEBAGIAN';
                break;
            }
        }



        /** UPDATE DATA_SPK_ITEM
         * Setelah update yang di spk_produk, maka sekarang giliran data_spk_item nya juga diupdate
         */
        dump('data_spk_item_new');
        dump($data_spk_item_new);

        $spk->data_spk_item = $data_spk_item_new;
        $spk->jumlah_total = $jumlah_total_new;
        $spk->harga_total = $harga_total_new;
        $spk->status = $spk_status;
        $spk->save();

        $request->session()->put('reload_page', true);

        $data = [
            'go_back_number' => -2,
        ];

        return view('layouts.go-back-page', $data);
    }
}
