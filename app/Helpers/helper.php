<?php

use App\Bahan;
use App\Busastang;
use App\Jahit;
use App\Kombi;
use App\SPJap;
use App\Standar;
use App\Stiker;
use App\Tankpad;
use App\Ukuran;
use App\Variasi;

function integerToRoman($integer)
{
    // Convert the integer into an integer (just to make sure)
    $integer = intval($integer);
    $result = '';

    // Create a lookup array that contains all of the Roman numerals.
    $lookup = array(
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    );

    foreach ($lookup as $roman => $value) {
        // Determine the number of matches
        $matches = intval($integer / $value);

        // Add the same number of characters to the string
        $result .= str_repeat($roman, $matches);

        // Set the integer to be the remainder of the integer and the value
        $integer = $integer % $value;
    }

    // The Roman numeral should be built, return it
    return $result;
}

function fetchBahan()
{
    $bahan = new Bahan();
    return $bahan;
}

function fetchVaria()
{
    $variasi = new Variasi();
    return $variasi;
}

function fetchUkuran()
{
    $ukuran = new Ukuran();
    return $ukuran;
}
function fetchJahit()
{
    $jahit = new Jahit();
    return $jahit;
}

function fetchKombi()
{
    $kombi = new Kombi();
    return $kombi;
}

function fetchSpjap()
{
    $spjap = new SPJap();
    return $spjap;
}

function fetchStandar()
{
    $std = new Standar();
    return $std;
}

function fetchTankpad()
{
    $tp = new Tankpad();
    return $tp;
}

function fetchBusastang()
{
    $busastang = new Busastang();
    return $busastang;
}

function fetchStiker()
{
    $stiker = new Stiker();
    return $stiker;
}

function fetch_att_varia()
{
    $label_bahans = fetchBahan()->label_bahans();
    $varias_harga = fetchVaria()->varias_harga();
    $ukurans_harga = fetchUkuran()->ukurans_harga();
    $jahits_harga = fetchJahit()->jahits_harga();

    $att_varia = [
        'label_bahans' => $label_bahans,
        'varias_harga' => $varias_harga,
        'ukurans_harga' => $ukurans_harga,
        'jahits_harga' => $jahits_harga,
    ];

    return $att_varia;
}

function fetch_att_kombi()
{
    $label_kombis = fetchKombi()->label_kombis();


    $att_kombi = [
        'kombis' => $label_kombis,
    ];

    return $att_kombi;
}

function fetch_att_std()
{
    $label_stds = fetchStandar()->label_stds();


    $att_std = [
        'stds' => $label_stds,
    ];

    return $att_std;
}

function fetch_att_spjap()
{
    $label_spjaps = fetchSpjap()->label_spjaps();


    $att_spjap = [
        'spjaps' => $label_spjaps,
    ];

    return $att_spjap;
}

function fetch_att_tp()
{
    $label_tp = fetchTankpad()->label_tp();


    $att_tp = [
        'tankpads' => $label_tp,
    ];

    return $att_tp;
}

function fetch_att_busastang()
{
    $label_busastang = fetchBusastang()->label_busastang();


    $att_busastang = [
        'busastangs' => $label_busastang,
    ];

    return $att_busastang;
}

function fetch_att_stiker()
{
    $label_stiker = fetchStiker()->label_stiker();


    $att_busastang = [
        'stikers' => $label_stiker,
    ];

    return $att_busastang;
}

function getNameProduk($tipe, $post)
{
    dump('Menjalankan fungsi getNameProduk');
    dump('tipe:');
    dump($tipe);

    /**
     * Apa saja variable yang akan di return? Yang bernilai null, tidak di include ke dalam variable yang akan di return.
     */

    // apabila ada bahan_id di post, maka set dalam variable $bahan_id

    $nama = $nama_nota = $harga = $variasi_id = $ukuran_id = $jahit_id = null;
    $tipe_bahan = $bahan_id = null;
    if (isset($post['bahan_id'])) {
        $bahan_id = (int)$post['bahan_id'];
    }
    if ($tipe === 'varia') {
        $variasi = json_decode($post['variasi'], true);
        $variasi_id = $variasi['id'];
        $harga = $post['bahan_harga'] + $variasi['harga'];
        $nama = "$post[bahan] $variasi[nama]";
        $nama_nota = $nama;
        // dd($variasi);

        $ukuran_id = null;
        if (isset($post['ukuran'])) {
            $ukuran = json_decode($post['ukuran'], true);
            $harga += $ukuran['harga'];
            $nama .= " uk.$ukuran[nama]";
            $nama_nota .= " uk.$ukuran[nama_nota]";
            $ukuran_id = $ukuran['id'];
        }
        $jahit_id = null;
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

    if ($tipe === 'kombi') {
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
        dump('Melakukan perbandingan tipe, apakah tipe===spjap');
        $nama = "Bahan($post[tipe_bahan]) $post[spjap]";
        $nama_nota = $nama;
        $harga = $post['spjap_harga'];
        dump($nama, $nama_nota, $harga);
    }

    // MELENGKAPI NAMA NOTA SEKALI LAGI
    if ($tipe === 'varia' || $tipe === 'kombinasi' || $tipe === 'std' || $tipe === 'spjap') {
        $nama_nota = "SJ $nama_nota";
        // dump($nama_nota);
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

    $variables = ['nama', 'nama_nota', 'harga', 'bahan_id', 'variasi_id', 'ukuran_id', 'jahit_id', 'tipe_bahan'];
    $var_values = [$nama, $nama_nota, $harga, $bahan_id, $variasi_id, $ukuran_id, $jahit_id, $tipe_bahan];

    $data = array();
    for ($i = 0; $i < count($variables); $i++) {
        if ($var_values[$i] !== null) {
            // array_push($data, [$variables[$i] => $var_values[$i]]);
            $data[$variables[$i]] = $var_values[$i];
        }
    }

    // dd($data);
    return $data;
}

function getProdukProperties($spk_item, $produk_new, $post)
{
    /**properties nantinya untuk value dari kolom properties pada table produk, sedangkan
     * spk_item_simple nantinya untuk value dari data_spk_item pada table SPK
     * yang mana, data_spk_item berfungsi untuk menyederhanakan pemanggilan data dari Database
     * supaya tidak memanggil berturut-turut table dan kolom2 yang lainnya.
     */
    if ($spk_item['tipe'] === 'varia') {
        $ukuran_id = $jahit_id = null;
        if (isset($produk_new['ukuran_id'])) {
            $ukuran_id = (int)$produk_new['ukuran_id'];
        }
        if (isset($produk_new['jahit_id'])) {
            $jahit_id = (int)$produk_new['jahit_id'];
        }
        $properties = [
            'bahan_id' => (int)$produk_new['bahan_id'],
            'variasi_id' => (int)$produk_new['variasi_id'],
            'ukuran_id' => $ukuran_id,
            'jahit_id' => $jahit_id,
        ];
        $spk_item_simple = [
            'bahan_id' => (int)$produk_new['bahan_id'],
            'variasi_id' => (int)$produk_new['variasi_id'],
            'ukuran_id' => $ukuran_id,
            'jahit_id' => $jahit_id,
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'jumlah' => (int)$spk_item['jumlah'],
            'harga' => (int)$produk_new['harga'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'kombi') {
        $properties = [
            'kombi_id' => (int)$post['kombi_id'],
        ];
        dump('properties dari kombi');
        dump($properties);
        $spk_item_simple = [
            'kombi_id' => (int)$post['kombi_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => (int)$produk_new['harga'],
            'jumlah' => (int)$spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'std') {
        $properties = [
            'standar_id' => (int)$post['standar_id'],
        ];
        $spk_item_simple = [
            'standar_id' => (int)$post['standar_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => (int)$produk_new['harga'],
            'jumlah' => (int)$spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'tankpad') {
        $properties = [
            'tankpad_id' => (int)$post['tankpad_id'],
        ];
        $spk_item_simple = [
            'tankpad_id' => (int)$post['tankpad_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => (int)$produk_new['harga'],
            'jumlah' => (int)$spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'busastang') {
        $properties = [
            'busastang_id' => (int)$post['busastang_id'],
        ];
        $spk_item_simple = [
            'busastang_id' => (int)$post['busastang_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => (int)$produk_new['harga'],
            'jumlah' => (int)$spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'spjap') {
        $properties = [
            'spjap_id' => (int)$post['spjap_id'],
            'tipe_bahan' => $post['tipe_bahan'],
        ];
        if ($post['bahan_id'] !== null) {
            $properties['bahan_id'] = (int)$post['bahan_id'];
        }
        $spk_item_simple = [
            'spjap_id' => (int)$post['spjap_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => (int)$produk_new['harga'],
            'jumlah' => (int)$spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'stiker') {
        $properties = [
            'stiker_id' => (int)$post['stiker_id'],
        ];
        $spk_item_simple = [
            'stiker_id' => (int)$post['stiker_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => (int)$produk_new['harga'],
            'jumlah' => (int)$spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    }

    return $properties;
}

// function reloadPage(Request $request)
// {
    
// }
