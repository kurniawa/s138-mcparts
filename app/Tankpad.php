<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tankpad extends Model
{
    public function label_tp()
    {

        $tp_terbaru = DB::table('tankpad_harga')
            ->selectRaw('id, tankpad_id, harga, MAX(created_at)')
            ->groupBy('tankpad_id');

        $label_tp = DB::table('tankpads')
            ->select('tankpads.id', 'tankpads.nama AS label', 'tankpads.nama AS value', 'tp_terbaru.harga', 'tankpads.ktrg')
            ->joinSub($tp_terbaru, 'tp_terbaru', function ($join) {
                $join->on('tankpads.id', '=', 'tp_terbaru.tankpad_id');
            })
            ->orderBy('tankpads.nama')->get();

        return $label_tp;
    }
}
