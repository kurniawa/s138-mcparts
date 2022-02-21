<?php

namespace App\Providers;

use App\SpkProduk;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        // SpkProduk::saving(function ($spk_produk) {
        //     // we want to save blank emails as NULL
        //     if ($spk_produk->jmlSelesai_kapan === "") {
        //         $spk_produk->jmlSelesai_kapan = null;
        //     }
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
