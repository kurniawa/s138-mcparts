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
    // protected $nullable = ['jmlSelesai_kapan'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($model) {
    //         self::setNullables($model);
    //     });
    // }

    // protected static function setNullables($model)
    // {
    //     foreach ($model->nullable as $field) {
    //         if (empty($model->{$field})) {
    //             $model->{$field} = null;
    //         }
    //     }
    // }
}
