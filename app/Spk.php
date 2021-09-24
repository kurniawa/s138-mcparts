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

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'spk_produks');
    }
    public function spk_item()
    {
        return $this->hasMany(SpkProduk::class);
    }
}
