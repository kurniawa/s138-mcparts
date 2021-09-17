<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RegisterController;
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

// SPK
Route::get('/spk', [SpkController::class, "index"]);
Route::get('/spk/spk_baru', [SpkController::class, "spk_baru"]);
Route::get('/spk/inserting_spk_item', [SpkController::class, "inserting_spk_item"]);
Route::post('/spk/inserting_item-db', [SpkController::class, "inserting_item_db"]);
Route::get('/spk/inserting_varia', [SpkController::class, "inserting_varia"]);
Route::get('/spk/inserting_kombi', [SpkController::class, "inserting_kombi"]);
Route::get('/spk/inserting_std', [SpkController::class, "inserting_std"]);
Route::get('/spk/inserting_tankpad', [SpkController::class, "inserting_tankpad"]);
Route::get('/spk/inserting_busastang', [SpkController::class, "inserting_busastang"]);
Route::get('/spk/inserting_spjap', [SpkController::class, "inserting_spjap"]);
Route::get('/spk/inserting_std', [SpkController::class, "inserting_std"]);
Route::get('/spk/inserting_busastang', [SpkController::class, "inserting_busastang"]);

// PELANGGAN
Route::get('/pelanggan', [PelangganController::class, "index"]);
Route::get('/about', function () {
    return view('/about/about');
});

// LOGIN & REGISTER
Route::get('/login', [LoginController::class, "index"]);
Route::post('/login', [LoginController::class, "authenticate"]);
Route::get('/register', [RegisterController::class, "index"]);
Route::post('/register', [RegisterController::class, "store"]);
