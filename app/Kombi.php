<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kombi extends Model
{
    public function label_kombis()
    {
        $kombi_terbaru = DB::table('kombi_harga')
            ->selectRaw('id, kombi_id, harga, MAX(created_at)')
            ->groupBy('kombi_id');

        $label_kombis = DB::table('kombis')
            ->select('kombis.id', 'kombis.nama AS label', 'kombis.nama AS value', 'kombi_terbaru.harga', 'kombis.ktrg')
            ->joinSub($kombi_terbaru, 'kombi_terbaru', function ($join) {
                $join->on('kombis.id', '=', 'kombi_terbaru.kombi_id');
            })
            ->orderBy('kombis.nama')->get();

        return $label_kombis;
    }
}
