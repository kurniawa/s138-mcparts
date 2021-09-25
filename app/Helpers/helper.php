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
