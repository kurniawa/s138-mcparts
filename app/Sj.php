<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sj extends Model
{
    //
    protected $guarded = ['id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
