<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

/*
 * First Database Setup for this Project
 * 
 php artisan make:model -m -c Pelanggan
 php artisan make:model -m -c Ekspedisi
 php artisan make:model -m -c Produk
 php artisan make:model -m -c Bahan
 php artisan make:model -m -c Variasi
 php artisan make:model -m -c Ukuran
 php artisan make:model -m -c Jahit
 php artisan make:model -m -c Kombinasi
 php artisan make:model -m -c Standar
 php artisan make:model -m -c Busastang
 php artisan make:model -m -c Spk
 php artisan make:model -m -c Nota
 php artisan make:model -m -c Srjl
 php artisan make:migration pelanggan_reseller
 php artisan make:migration pelanggan_produk
 php artisan make:migration pelanggan_produk_harga
 php artisan make:migration produk_harga
 php artisan make:migration bahan_harga
 php artisan make:migration variasi_harga
 php artisan make:migration ukuran_harga
 php artisan make:migration jahit_harga
 php artisan make:migration kombinasi_harga
 php artisan make:migration standar_harga
 php artisan make:migration busastang_harga
 php artisan make:migration pelanggan_ekspedisi
 php artisan make:migration pelanggan_pengiriman
 php artisan make:migration ekspedisi_tujuan
 php artisan make:migration spk_nota
 php artisan make:migration nota_srjl
 php artisan make:migration spk_produk
 php artisan make:migration nota_produk
 php artisan make:migration srjl_produk

 Schema - Pelanggan:
 -------------------
  Schema::create('pelanggans', function (Blueprint $table) {
    $table->id();
    $table->string("nama", 100);
    $table->string("alamat");
    $table->string("daerah", 50);
    $table->string("kontak", 50)->nullable();
    $table->string("pulau", 50);
    $table->string("ktrg")->nullable();
    $table->timestamp("created_at")->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp("updated_at")->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
});
    
Schema - Ekspedisi:
-------------------
Schema::create('ekspedisis', function (Blueprint $table) {
    $table->id();
    $table->string("nama", 100);
    $table->string("alamat");
    $table->string("kontak", 50)->nullable();
    $table->string("ktrg")->nullable();
    $table->timestamp("created_at")->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp("updated_at")->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
});

Schema - Produk:
----------------
Schema::create('ekspedisis', function (Blueprint $table) {
    $table->id();
    $table->string("tipe", 100);
    $table->foreignId("bahan");
    $table->foreignId("bahan");
    $table->string("pulau_tujuan", 50);
    $table->string("daerah_tujuan", 50);
    $table->string("kontak", 50)->nullable();
    $table->string("ktrg")->nullable();
    $table->timestamp("created_at")->default(DB::raw('CURRENT_TIMESTAMP'));
    $table->timestamp("updated_at")->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
});
* 
 */