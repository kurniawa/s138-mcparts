<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jahit extends Model
{
    public function jahits_harga()
    {
        // $sql = "SELECT jahit_kepala.id, jahit_kepala.nama, jk_terbaru.harga FROM jahit_kepala INNER JOIN
        // (SELECT id, id_jk, harga, MAX(tanggal) FROM jk_harga GROUP BY id_jk) AS jk_terbaru
        // ON jahit_kepala.id=jk_terbaru.id_jk";

        $jahit_terbaru = DB::table('jahit_harga')
            ->selectRaw('id, jahit_id, harga, MAX(created_at)')
            ->groupBy('jahit_id');

        // $jahit_terbaru = DB::table('jahit_harga')
        //     ->selectRaw('id, jahit_id, harga, MAX(created_at) GROUP BY jahit_id');

        $jahits_harga = DB::table('jahits')
            ->select('jahits.id', 'jahits.nama', 'jahit_terbaru.harga', 'jahits.ktrg')
            ->joinSub($jahit_terbaru, 'jahit_terbaru', function ($join) {
                $join->on('jahits.id', '=', 'jahit_terbaru.jahit_id');
            })
            ->orderBy('jahits.nama')->get();

        return $jahits_harga;
    }
}
