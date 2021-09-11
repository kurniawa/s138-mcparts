<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ukuran extends Model
{
    public function ukurans_harga()
    {
        $sql = "SELECT sj_ukuran.id, sj_ukuran.nama, sj_ukuran.nama_nota, sj_ukuran_terbaru.harga FROM sj_ukuran INNER JOIN
        (SELECT id, id_ukuran, harga, MAX(tanggal) FROM sj_ukuran_harga GROUP BY id_ukuran) AS sj_ukuran_terbaru
        ON sj_ukuran.id=sj_ukuran_terbaru.id_ukuran";

        $ukuran_terbaru = DB::table('ukuran_harga')
            ->selectRaw('id, ukuran_id, harga, MAX(created_at)')
            ->groupBy('ukuran_id');

        // $ukuran_terbaru = DB::table('ukuran_harga')
        //     ->selectRaw('id, ukuran_id, harga, MAX(created_at) GROUP BY ukuran_id');

        $ukurans_harga = DB::table('ukurans')
            ->select('ukurans.id', 'ukurans.nama', 'ukurans.nama_nota', 'ukuran_terbaru.harga', 'ukurans.ktrg')
            ->joinSub($ukuran_terbaru, 'ukuran_terbaru', function ($join) {
                $join->on('ukurans.id', '=', 'ukuran_terbaru.ukuran_id');
            })
            ->orderBy('ukurans.nama')->get();

        return $ukurans_harga;
    }
}
