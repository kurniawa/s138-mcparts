<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailSPKController;
use App\Http\Controllers\EditSPKFDetail;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\PrintOutSPK;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SjController;
use App\Http\Controllers\SpkBaru;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\SPKItemSelesai;
use App\Http\Controllers\TutorialController;
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
Route::get('/about', function () {
    return view('/about/about');
});
/**
 * TUTORIAL
 */

Route::get('/tutorial/tutorial-laravel_vapor', [TutorialController::class, "laravel_vapor"]);

/**
 * SPK
 */
Route::get('/spk', [SpkController::class, "index"]);
Route::get('/spk/spk_baru', [SpkController::class, "spk_baru"])->middleware('auth');
Route::get('/spk/inserting_spk_item', [SpkController::class, "inserting_spk_item"])->middleware('auth');
Route::post('/spk/inserting_item-db', [SpkController::class, "inserting_item_db"])->middleware('auth');
Route::get('/spk/inserting_varia', [SpkController::class, "inserting_varia"])->middleware('auth');
Route::get('/spk/inserting_kombi', [SpkController::class, "inserting_kombi"])->middleware('auth');
Route::get('/spk/inserting_std', [SpkController::class, "inserting_std"])->middleware('auth');
Route::get('/spk/inserting_tankpad', [SpkController::class, "inserting_tankpad"])->middleware('auth');
Route::get('/spk/inserting_busastang', [SpkController::class, "inserting_busastang"])->middleware('auth');
Route::get('/spk/inserting_spjap', [SpkController::class, "inserting_spjap"])->middleware('auth');
Route::get('/spk/inserting_stiker', [SpkController::class, "inserting_stiker"])->middleware('auth');
Route::post('/spk/proceed_spk', [SpkBaru::class, "proceed_spk"])->middleware('auth');
Route::get('/spk/detail_spk', [DetailSPKController::class, "index"]);
Route::get('/spk/edit_spk_item', [DetailSPKController::class, "editSPKItem"])->middleware('auth');
Route::post('/spk/edit_spk_item-db', [EditSPKFDetail::class, "index"])->middleware('auth');
Route::post('/spk/hapus-SPK', [DetailSPKController::class, "hapus_SPK"])->middleware('auth');
Route::post('/spk/delete_spk_item', [EditSPKFDetail::class, "deleteSPKItem"])->middleware('auth');
Route::get('/spk/penetapan_item_selesai', [SPKItemSelesai::class, "index"])->middleware('auth');
Route::post('/spk/penetapan_item_selesai-db', [SPKItemSelesai::class, "setItemSelesai"])->middleware('auth');
// Print SPK
Route::get('/spk/print_out_spk', [PrintOutSPK::class, "index"]);

// PELANGGAN
Route::get('/pelanggan', [PelangganController::class, "index"]);
Route::get('/pelanggan/pelanggan-detail', [PelangganController::class, "pelanggan_detail"]);
Route::get('/pelanggan/pelanggan-baru', [PelangganController::class, "pelanggan_baru"])->middleware('auth');

/**
 * EKSPEDISI
 */
Route::get('/ekspedisi', [EkspedisiController::class, "index"]);

/**
 * NOTA
 * 
 * Terkadang saya butuh get, supaya ketika back, tidak terjadi masalah expired.
 */
Route::get('/nota', [NotaController::class, 'index']);
Route::get('/nota/nota_baru-pilih_spk', [NotaController::class, 'notaBaru_pilihSPK'])->middleware('auth');
Route::get('/nota/notaBaru-pSPK-pItem', [NotaController::class, 'notaBaru_pSPK_pItem'])->middleware('auth');
Route::post('/nota/notaBaru-pSPK-pItem-DB', [NotaController::class, 'notaBaru_pSPK_pItem_DB'])->middleware('auth');
Route::get('/nota/nota-detailNota', [NotaController::class, 'nota_detailNota']);
Route::get('/nota/nota-printOut', [NotaController::class, 'nota_printOut']);
Route::post('/nota/nota-hapus', [NotaController::class, 'nota_hapus'])->middleware('auth');


/**
 * SURAT JALAN
 */
Route::get('/sj', [SjController::class, 'index']);
Route::get('/sj/sjBaru-pCust', [SjController::class, 'sjBaru_pCust'])->middleware('auth');
Route::post('/sj/sjBaru-pCust-DB', [SjController::class, 'sjBaru_pCust_DB'])->middleware('auth');
Route::get('/sj/sj-detailSJ', [SjController::class, 'sj_detailSJ']);
Route::post('/sj/sj-printOut', [SjController::class, 'sj_printOut']);
Route::post('/sj/sj-hapus', [SjController::class, 'sj_hapus'])->middleware('auth');

// LOGIN & REGISTER coment dikit ah
Route::get('/login', [LoginController::class, "index"])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, "authenticate"]);
Route::get('/register', [RegisterController::class, "index"])->middleware('guest');
Route::post('/register', [RegisterController::class, "store"]);
Route::get('/dashboard', [DashboardController::class, "index"])->middleware('auth');

Route::post('/logout', [LoginController::class, "logout"])->middleware('auth');
