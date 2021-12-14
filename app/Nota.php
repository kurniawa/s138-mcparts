<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    //
    protected $guarded = ['id'];
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'spk_produks');
    }
    public function nota_item()
    {
        return $this->hasMany(SpkProduk::class);
    }
}
