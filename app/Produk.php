<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public function Harga()
    {
        return $this->hasMany(ProdukHarga::class);
    }

    public function spk()
    {
        return $this->belongsToMany(Spk::class);
    }
}
