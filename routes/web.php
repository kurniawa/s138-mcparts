<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SpkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/spk', [SpkController::class, "index"]);
Route::get('/spk/spk_baru', [SpkController::class, "spk_baru"]);
Route::post('/spk/inserting_spk_item', [SpkController::class, "inserting_spk_item"]);
Route::get('/pelanggan', [PelangganController::class, "index"]);
Route::get('/about', function () {
    return view('/about/about');
});
