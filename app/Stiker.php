<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stiker extends Model
{
    public function label_stiker()
    {
        $stiker_terbaru = DB::table('stiker_harga')
            ->selectRaw('id, stiker_id, harga, MAX(created_at)')
            ->groupBy('stiker_id');

        $label_stiker = DB::table('stikers')
            ->select('stikers.id', 'stikers.nama AS label', 'stikers.nama AS value', 'stiker_terbaru.harga', 'stikers.ktrg')
            ->joinSub($stiker_terbaru, 'stiker_terbaru', function ($join) {
                $join->on('stikers.id', '=', 'stiker_terbaru.stiker_id');
            })
            ->orderBy('stikers.nama')->get();

        return $label_stiker;
    }
}
