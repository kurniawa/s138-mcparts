<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\Table\Table;

class Pelanggan extends Model
{
    public function d_label_pelanggan()
    {
        $d_label_pelanggan = DB::table('pelanggans')
            ->leftJoin('pelanggan_reseller', 'pelanggans.id', '=', 'pelanggan_reseller.pelanggan_id')
            ->select('pelanggans.id', 'pelanggans.nama AS label', 'pelanggans.nama AS value', 'pelanggans.daerah', 'pelanggan_reseller.reseller_id')
            ->orderBy('pelanggans.nama')->get();

        return $d_label_pelanggan;
    }

    // public function d_nama_pelanggan_2()
    // {
    //     $d_nama_pelanggan = DB::select('SELECT pelanggans.id, pelanggans.nama, pelanggans.daerah, pelanggan_reseller.reseller_id
    //     FROM pelanggans LEFT JOIN pelanggan_reseller ON pelanggans.id=pelanggan_reseller.pelanggan_id ORDER BY pelanggans.nama ASC');

    //     return $d_nama_pelanggan;
    // }
}
