<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailSPKController;
use App\Http\Controllers\EditSPKFDetail;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PrintOutSPK;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\SPKItemSelesai;
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

/**
 * SPK
 */
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
Route::get('/spk/inserting_stiker', [SpkController::class, "inserting_stiker"]);
Route::post('/spk/proceed_spk', [SpkController::class, "store"]);
Route::get('/spk/detail_spk', [DetailSPKController::class, "index"]);
Route::get('/spk/edit_spk_item', [DetailSPKController::class, "editSPKItem"]);
Route::post('/spk/edit_spk_item-db', [EditSPKFDetail::class, "index"]);
Route::post('/spk/delete_spk_item', [EditSPKFDetail::class, "deleteSPKItem"]);
Route::get('/spk/penetapan_item_selesai', [SPKItemSelesai::class, "index"]);
Route::post('/spk/penetapan_item_selesai-db', [SPKItemSelesai::class, "setItemSelesai"]);
// Print SPK
Route::get('/spk/print_out_spk', [PrintOutSPK::class, "index"]);

// PELANGGAN
Route::get('/pelanggan', [PelangganController::class, "index"]);
Route::get('/about', function () {
    return view('/about/about');
});

/**
 * NOTA
 * 
 * Terkadang saya butuh get, supaya ketika back, tidak terjadi masalah expired.
 */
Route::get('/nota', [NotaController::class, 'index']);
Route::get('/nota/nota_baru-pilih_spk', [NotaController::class, 'notaBaru_pilihSPK']);
Route::get('/nota/notaBaru-pSPK-pItem', [NotaController::class, 'notaBaru_pSPK_pItem']);
Route::post('/nota/notaBaru-pSPK-pItem-DB', [NotaController::class, 'notaBaru_pSPK_pItem_DB']);
Route::post('/nota/notaBaru-pSPK-pNota-pItem', [NotaController::class, 'notaBaru_pSPK_pNota_pItem']);

// LOGIN & REGISTER coment dikit ah
Route::get('/login', [LoginController::class, "index"])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, "authenticate"]);
Route::get('/register', [RegisterController::class, "index"])->middleware('guest');
Route::post('/register', [RegisterController::class, "store"]);
Route::get('/dashboard', [DashboardController::class, "index"])->middleware('auth');

Route::post('/logout', [LoginController::class, "logout"]);
