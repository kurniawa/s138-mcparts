<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Busastang extends Model
{
    public function label_busastang()
    {

        $busastang_terbaru = DB::table('busastang_harga')
            ->selectRaw('id, busastang_id, harga, MAX(created_at)')
            ->groupBy('busastang_id');

        $label_busastang = DB::table('busastangs')
            ->select('busastangs.id', 'busastangs.nama AS label', 'busastangs.nama AS value', 'busastang_terbaru.harga', 'busastangs.ktrg')
            ->joinSub($busastang_terbaru, 'busastang_terbaru', function ($join) {
                $join->on('busastangs.id', '=', 'busastang_terbaru.busastang_id');
            })
            ->orderBy('busastangs.nama')->get();

        return $label_busastang;
    }
}
