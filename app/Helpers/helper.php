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

function getNameProduk($tipe, $post)
{
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
        $data = [
            'nama' => $nama,
            'nama_nota' => $nama_nota,
            'harga' => $harga,
            'bahan_id' => (int)$post['bahan_id'],
            'variasi_id' => $variasi_id,
            'ukuran_id' => $ukuran_id,
            'jahit_id' => $jahit_id,
        ];
        return $data;
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
}

function getProdukProperties($spk_item, $produk_new)
{
    if ($spk_item['tipe'] === 'varia') {
        $properties = [
            'bahan_id' => $produk_new['bahan_id'],
            'variasi_id' => $produk_new['variasi_id'],
            'ukuran_id' => $produk_new['ukuran_id'],
            'jahit_id' => $produk_new['jahit_id'],
        ];
        $spk_item_simple = [
            'bahan_id' => $produk_new['bahan_id'],
            'variasi_id' => $produk_new['variasi_id'],
            'ukuran_id' => $produk_new['ukuran_id'],
            'jahit_id' => $produk_new['jahit_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'jumlah' => $spk_item['jumlah'],
            'harga' => $produk_new['harga'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'kombinasi') {
        $properties = [
            'kombi_id' => $produk_new['kombi_id'],
        ];
        $spk_item_simple = [
            'kombi_id' => $produk_new['kombi_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => $produk_new['harga'],
            'jumlah' => $spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'std') {
        $properties = [
            'standar_id' => $produk_new['standar_id'],
        ];
        $spk_item_simple = [
            'standar_id' => $produk_new['standar_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => $produk_new['harga'],
            'jumlah' => $spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'tankpad') {
        $properties = [
            'tankpad_id' => $produk_new['tankpad_id'],
        ];
        $spk_item_simple = [
            'tankpad_id' => $produk_new['tankpad_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => $produk_new['harga'],
            'jumlah' => $spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'busastang') {
        $properties = [
            'busastang_id' => $produk_new['busastang_id'],
        ];
        $spk_item_simple = [
            'busastang_id' => $produk_new['busastang_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => $produk_new['harga'],
            'jumlah' => $spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'spjap') {
        $properties = [
            'spjap_id' => $produk_new['spjap_id'],
        ];
        $spk_item_simple = [
            'spjap_id' => $produk_new['spjap_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => $produk_new['harga'],
            'jumlah' => $spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    } elseif ($spk_item['tipe'] === 'stiker') {
        $properties = [
            'stiker_id' => $produk_new['stiker_id'],
        ];
        $spk_item_simple = [
            'stiker_id' => $produk_new['stiker_id'],
            'nama' => $produk_new['nama'],
            'nama_nota' => $produk_new['nama_nota'],
            'harga' => $produk_new['harga'],
            'jumlah' => $spk_item['jumlah'],
            'ktrg' => $spk_item['ktrg'],
        ];
    }

    return $properties;
}

// function reloadPage(Request $request)
// {
    
// }
