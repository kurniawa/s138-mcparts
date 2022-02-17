<?php

namespace App\Http\Controllers;

use App\Produk;
use App\ProdukHarga;
use App\SiteSetting;
use App\Spk;
use App\SpkProduk;
use Illuminate\Http\Request;

class EditSPKFDetail extends Controller
{
    public function index(Request $request)
    {
        /**
         * Untuk edit salah satu item SPK, maka kita perlu untuk mengolah data dari awal terlebih dahulu.
         * Pertama2 kita akan ambil data SPK seutuhnya melalui spk_id. Setelah spk ditemukan, maka
         * kita perlu mengubah data_spk_item yang berbentuk json.
         * 
         * Untuk mengetahui index ke berapa yang perlu diganti, maka untuk mempermudah perbandingan
         * kita perlu ambil data nama dari produk sebelumnya melalui produk_id_old.
         * 
         * Untuk memudahkan perbandingan nya, maka kita pilih properti nama nya saja. Oleh karena itu
         * sebelumnya kita perlu untuk menyusun kembali nama dari item yang baru diedit melalui
         * fungsi baru, yakni getNameProduk yang aku taro di helper.php.
         * 
         * Kemungkinan yang ada:
         * 1) produk persis sama seperti sebelumnya, serta jumlah dan keterangan pun sama
         * 2) produk sama seperti sebelumnya, namun jumlah dan keterangan nya perlu diganti di table spk_produk
         * 3) produk berbeda, namun sudah terdaftar di database produk, sehingga table spk_produk nya saja
         * yang perlu diupdate
         * 4) produk berbeda dan belum terdaftar di database produk. Ini brrti produk yang benar2 baru.
         * Jadi pertama-tama insert terlebih dahulu di database produk, lalu insert ke db produk_harga
         * baru setelah itu update di table spk_produk
         * 
         * Setelah mendapatkan nama yang sudah disusun, maka kita dapat mulai membandingkan, apakah
         * ini merupakan produk yang sama atau berbeda. Apabila ternyata produknya sama, maka untuk
         * mempersingkat proses, kita tidak perlu membandingkan lagi parameter yang lain, seperti
         * jumlah dan keterangan. Kita langsung update saja di table spk_produk
         * 
         * Apabila ternyata nama produk berbeda, maka harus dicari apakah item tersebut sudah terdaftar
         * di database produk.
         * 
         * 
         */
        $post = $request->input();
        dump('$post');
        dump($post);
        $spk_id = $post['spk_id'];
        $spk = Spk::find($spk_id);
        // dd($spk);

        /**data_spk_item berbentuk json, maka kita perlu ambil bentuk array nya dan mencari letak yang harus diganti.
         * Untuk mencari data_spk_item mana yang perlu diganti, maka kita terlebih dahulu decode data_spk_item yang ada
         * lalu kita loop dengan mencari nama yang sesuai, saya rasa perbandingan nya paling mudah menggunakan
         * variable produk_old yang telah dicari dibawah ini. 
         *
         * */
        $produk_id_old = $post['produk_id_old'];
        $produk_old = Produk::find($produk_id_old);
        dump('$produk_old');
        dump($produk_old);

        dump('data_spk_item');
        // dump($spk->data_spk_item);

        $data_spk_item = json_decode($spk->data_spk_item, true);
        dump($data_spk_item);

        /**Data SPK Item mana yang akan nantinya perlu di edit, akan tampil disini */
        $index_data_spk_item = '';
        for ($i = 0; $i < count($data_spk_item); $i++) {
            if ($data_spk_item[$i]['nama'] === $produk_old['nama']) {
                $index_data_spk_item = $i;
            }
        }
        dump('index_data_spk_item');
        dump($index_data_spk_item);
        dump('data_spk_item_old');
        dump($data_spk_item[$index_data_spk_item]);

        $tipe = $post['tipe'];
        $produk_new = getNameProduk($tipe, $post);
        dump('$produk_new');
        dump($produk_new);
        // dd($produk_new);

        $spk_produk = SpkProduk::find($post['spk_produk_id']);
        dump('$spk_produk');
        dump($spk_produk);

        // Disini coba pake bantuan function properties
        /** properties di definisikan disini supaya bisa di pake oleh if else yang ada dibawahnya */
        $spk_item = [
            'tipe' => $post['tipe'],
            'jumlah' => (int)$post['jumlah'],
            'ktrg' => $post['ktrg'],
        ];
        dump('spk_item');
        dump($spk_item);
        // dd($spk_item);

        // $spk_item = json_encode($spk_item);
        $properties = getProdukProperties($spk_item, $produk_new, $post);
        dump('properties');
        dump($properties);
        // dd($properties);

        /** Data properties diatas hanya untuk keterangan properties di table produk, sedangkan untuk
         * data_spk_item yang baru, masih perlu tambahan nama, nama_nota, jumlah, harga dan keterangan.
         * Untuk menentkan spk_item_new, maka kita panggil function. Supaya di sini tidak perlu
         * lagi untuk memfilter tipe produk varia, kombi, dll.
         * 
         * Function yang di panggil diantaranya ketika menentukan properties, ketika menentukan produk_new
         * dan ambil dari post
         */

        /**METODE UPDATE SPK, SPKProduk, ProdukHarga
         * 
         * Dibawah ini adalah coding untuk mulai update database yang bersangkutan.
         * 
         * Nanti setelah update SPK Produk, maka perlu juga untuk update data_spk_item pada SPK.
         * Selain data_spk_item yang diupdate, tentunya perlu update juga harga total spk dan jumlah
         * total spk. Untuk metode nya, saya ingin menggunakan looping dari data_spk_item yang baru,
         * sambil di setiap loop, maka ditambahkan harga dan jumlah item nya.
         */
        // dd('MULAI UPDATE DATABASE');
        dump('MULAI UPDATE DATABASE');
        if ($produk_new['nama'] === $produk_old['nama']) {
            dump('Produk Sama!');
            if ($spk_produk['ktrg'] !== $post['ktrg'] || $spk_produk['jumlah'] !== $post['jumlah']) {
                $spk_produk->ktrg = $post['ktrg'];
                $spk_produk->jumlah = $post['jumlah'];

                $spk_produk->save();
                dump('$spk_produk_updated');
                dump($spk_produk);

                // $spk->save();
            } else {
                /**DO NOTHING */
            }
        } else {
            dump('Produk Berbeda!');
            $produk_search = Produk::where('nama', '=', $produk_new['nama'])->first();
            dump('mencari produk di database');
            dump($produk_search);
            if ($produk_search === null) {
                dump('Produk Belum Terdaftar!');

                $produk_new_created = new Produk;
                $produk_new_created->tipe = $post['tipe'];
                $produk_new_created->properties = json_encode($properties);
                $produk_new_created->nama = $produk_new['nama'];
                $produk_new_created->nama_nota = $produk_new['nama_nota'];
                $produk_new_created->save();

                // $produk_new_created = Produk::create([
                //     'tipe' => $post['tipe'],
                //     'properties' => json_encode($properties),
                //     'nama' => $produk_new['nama'],
                //     'nama_nota' => $produk_new['nama_nota'],
                // ]);

                dump('$produk_new_created');
                dump($produk_new_created);

                $produk_harga_new_created = new ProdukHarga;
                $produk_harga_new_created->produk_id = $produk_new_created['id'];
                $produk_harga_new_created->harga = $produk_new['harga'];
                $produk_harga_new_created->save();

                // $produk_harga_new_created = ProdukHarga::create([
                //     'produk_id' => $produk_new_created['id'],
                //     'harga' => $produk_new['harga'],
                // ]);
                dump('$produk_harga_new_created');
                dump($produk_harga_new_created);

                /**
                 * Setelah create produk baru dan relasi nya dengan harga, maka kita perlu update data
                 * produk_id pada id spk_produk yang berkaitan
                 *  */

                dump($produk_new_created['id']);
                $spk_produk->produk_id = $produk_new_created['id'];
                $spk_produk->ktrg = $post['ktrg'];
                $spk_produk->jumlah = $post['jumlah'];
                $spk_produk->save();
            } else {
                $spk_produk->produk_id = $produk_search['id'];
                $spk_produk->ktrg = $post['ktrg'];
                $spk_produk->jumlah = $post['jumlah'];
                $spk_produk->save();
            }

            /**Setelah update SPK Produk, maka perlu juga untuk update data_spk_item pada SPK */
            // $spk->data_spk_item = json_encode($data_spk_item);
        }

        /** PENETAPAN data_spk_item
         * Intinya sih entah ada produk baru atau tidak. Produk nya sama seperti sebelumnya atau tidak. Atau
         * hanya ada perubahan pada jumlah dan keterangan nya saja, intinya data_spk_item tetap diupdate.
         * 
         * Lalu untuk keterangan dalam spk_item_new nya entah ada produk baru atau tidak atau hanya ada perubahan
         * pada jumlah dan keterangan saja, intinya spk_produk_id tidak akan berubah. Karena yang berubah
         * hanya produk_id nya saja di table spk_produk, sedangkan id nya sendiri tidak berubah
         */

        /** Data properties diatas hanya untuk keterangan properties di table produk, sedangkan untuk
         * data_spk_item yang baru, masih perlu tambahan nama, nama_nota, jumlah, harga dan keterangan.
         * Untuk menentkan spk_item_new, maka kita panggil function. Supaya di sini tidak perlu
         * lagi untuk memfilter tipe produk varia, kombi, dll.
         * 
         * Function yang di panggil diantaranya ketika menentukan properties, ketika menentukan produk_new
         * dan ambil dari post
         */
        $spk_item_new = $properties;
        $spk_item_new['nama'] = $produk_new['nama'];
        $spk_item_new['nama_nota'] = $produk_new['nama_nota'];
        $spk_item_new['harga'] = (int)$produk_new['harga'];
        $spk_item_new['jumlah'] = (int)$post['jumlah'];
        $spk_item_new['ktrg'] = $post['ktrg'];
        $spk_item_new['spk_produk_id'] = $spk_produk['id'];
        $spk_item_new['status'] = 'PROSES';
        dump('spk_item_new');
        dump($spk_item_new);

        $data_spk_item[$index_data_spk_item] = $spk_item_new;
        dump('data_spk_item_new');
        dump($data_spk_item);
        // dd($data_spk_item);

        /**METODE UPDATE SPK, SPKProduk, ProdukHarga
         * 
         * 
         * Nanti setelah update SPK Produk, maka perlu juga untuk update data_spk_item pada SPK.
         * Selain data_spk_item yang diupdate, tentunya perlu update juga harga total spk dan jumlah
         * total spk. Untuk metode nya, saya ingin menggunakan looping dari data_spk_item yang baru,
         * sambil di setiap loop, maka ditambahkan harga dan jumlah item nya.
         */
        $harga_total_new = 0;
        $jumlah_total_new = 0;
        for ($i = 0; $i < count($data_spk_item); $i++) {
            $harga_total_new += $data_spk_item[$i]['harga'];
            $jumlah_total_new += $data_spk_item[$i]['jumlah'];
        }
        $spk->harga_total = $harga_total_new;
        $spk->jumlah_total = $jumlah_total_new;

        $spk->data_spk_item = json_encode($data_spk_item);
        $spk->save();

        // $request->session()->put('reload_page', true);
        // $reload_page = SiteSetting::where('setting', '=', 'reload_page');
        // $reload_page->value = 'TRUE';
        // $reload_page->save();

        $reload_page = $request->session()->put('reload_page', true);

        $data = [
            'go_back_number' => -2,
            'reload_page' => $reload_page
        ];
        // dd('dd sebelum ke halaman lain');
        // dump('dd sebelum ke halaman lain');
        return view('layouts.go-back-page', $data);
    }

    public function deleteSPKItem(Request $request)
    {
        dump('Controller: EditSPKFDetail; Function: deleteSPKItem');
        /**
         * # Parameter spk_item_id di post kita retrieve. Ini untuk ambil data SpkProduk dengan id yang bersangkutan.
         * # Setelah mendapat data SpkProduk yang di tampung dalam variable $spk_produk, maka kita bisa mendapatkan data SPK
         * # Kita tetap membutuhkan $spk sebelum menghapus, karena leider dengan metode penampilan daftar SPK saat ini,
         * maka kita perlu juga update data_spk_item pada table SPK.
         * # Setelah mendapat $spk, maka kita bisa mendapatkan $data_spk_item.
         */
        $post = $request->input();
        dump($post);

        $spk_produk = SpkProduk::find($post['spk_item_id']);
        dump('spk_produk');
        dump($spk_produk);

        $spk = Spk::find($spk_produk['spk_id']);
        dump('SPK');
        dump($spk);

        dump('data_spk_item');
        $data_spk_item = $spk['data_spk_item'];
        dump($data_spk_item);
        $data_spk_item = json_decode($data_spk_item, true);
        dump($data_spk_item);

        $spk_item_id = (int)$post['spk_item_id'];
        $index_spk_item = '?';
        for ($i = 0; $i < count($data_spk_item); $i++) {
            dump($data_spk_item[$i]['spk_produk_id'], $spk_item_id);
            if ($data_spk_item[$i]['spk_produk_id'] === $spk_item_id) {
                $index_spk_item = $i;
                dump('ditemukan');
                break;
            }
        }
        dump('index_spk_item');
        dump($index_spk_item);
        unset($data_spk_item[$index_spk_item]);
        dump('data_spk_item setelah ada yang dihapus');
        dump($data_spk_item);

        /**
         * SETELAH unset(), saya menggunakan array_values() ketika di encode.
         * Why? Because you're unsetting array's key without re-ordering it.
         * So after this the only way to keep that in JSON will be encode keys too.
         * After applying array_values(), however,
         * you'll get ordered keys (starting from 0) which can be encoded properly without including keys.
         */

        $data_spk_item = json_encode(array_values($data_spk_item));
        dump($data_spk_item);
        // $data_spk_item = json_decode($data_spk_item, true);
        // dump($data_spk_item);

        /**
         * MULAI DELETE spk_produk yang berkaitan
         */
        $spk_produk->delete();

        /**
         * MULAI UPDATE data_spk_item pada table spk.
         * Tapi perlu diingat, yang perlu diupdate bukan hanya data_spk_item, namun jumlah_total dan harga_total juga
         * perlu diubah, karena ada satu spk_produk yang dihapus.
         */
        $jumlah_total_old = $spk->jumlah_total;
        $harga_total_old = $spk->harga_total;
        dump('jumlah_total_old dan harga_total_old');
        dump($jumlah_total_old, $harga_total_old);

        $jumlah_total_new = $jumlah_total_old - $spk_produk['jumlah'];
        $harga_total_new = $harga_total_old - ($spk_produk['harga'] * $spk_produk['jumlah']);

        $spk->data_spk_item = $data_spk_item;
        $spk->jumlah_total = $jumlah_total_new;
        $spk->harga_total = $harga_total_new;
        $spk->save();

        $reload_page = $request->session()->put('reload_page', true);

        $data = [
            'go_back_number' => -2,
            'reload_page' => $reload_page
        ];
        return view('layouts.go-back-page', $data);
    }
}
