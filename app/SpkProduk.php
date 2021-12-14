<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpkProduk extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
    // public function Spk()
    // {
    //     return $this->belongsToMany(Spk::class);
    // }

    // public function Produk()
    // {
    //     return $this->belongsToMany(Produk::class);
    // }
}
