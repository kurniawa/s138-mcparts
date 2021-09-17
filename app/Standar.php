<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Standar extends Model
{
    public function label_stds()
    {

        $std_terbaru = DB::table('standar_variasi_harga')
            ->selectRaw('id, standar_id, harga, MAX(created_at)')
            ->groupBy('standar_id');

        $label_stds = DB::table('standars')
            ->select('standars.id', 'standars.nama AS label', 'standars.nama AS value', 'std_terbaru.harga', 'standars.ktrg')
            ->joinSub($std_terbaru, 'std_terbaru', function ($join) {
                $join->on('standars.id', '=', 'std_terbaru.standar_id');
            })
            ->orderBy('standars.nama')->get();

        return $label_stds;
    }
}
