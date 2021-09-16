<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Standar extends Model
{
    public function label_stds()
    {

        $bahan_terbaru = DB::table('bahan_harga')
            ->selectRaw('id, bahan_id, harga, MAX(created_at)')
            ->groupBy('bahan_id');

        // $bahan_terbaru = DB::table('bahan_harga')
        //     ->selectRaw('id, bahan_id, harga, MAX(created_at) GROUP BY bahan_id');

        $label_stds = DB::table('bahans')
            ->select('bahans.id', 'bahans.nama AS label', 'bahans.nama AS value', 'bahan_terbaru.harga', 'bahans.ktrg')
            ->joinSub($bahan_terbaru, 'bahan_terbaru', function ($join) {
                $join->on('bahans.id', '=', 'bahan_terbaru.bahan_id');
            })
            ->orderBy('bahans.nama')->get();

        return $label_stds;
    }
}
