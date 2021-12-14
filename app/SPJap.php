<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SPJap extends Model
{
    public function label_spjaps()
    {
        $spjap_terbaru = DB::table('spjap_bhn_hrg')
            ->selectRaw('id, spjap_id, harga, tipe_bahan, MAX(created_at)')
            ->groupBy('spjap_id', 'tipe_bahan');

        $label_spjaps = DB::table('spjaps')
            ->select('spjaps.id', 'spjaps.nama AS label', 'spjaps.nama AS value', 'spjap_terbaru.harga', 'spjap_terbaru.tipe_bahan', 'spjaps.ktrg')
            ->joinSub($spjap_terbaru, 'spjap_terbaru', function ($join) {
                $join->on('spjaps.id', '=', 'spjap_terbaru.spjap_id');
            })
            ->orderBy('spjaps.nama')->get();

        return $label_spjaps;
    }
}
