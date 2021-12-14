<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function Harga()
    {
        return $this->hasMany(ProdukHarga::class);
    }

    public function spk()
    {
        return $this->belongsToMany(Spk::class);
    }
}
