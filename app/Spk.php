<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    protected $guarded = ['id'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
