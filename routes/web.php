<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepsionisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\ApotekerController;
use App\Http\Controllers\PasienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/* =======================
   AUTH
======================= */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    /* =======================
       RESEPSIONIS
    ======================= */
    Route::get('/resepsionis/dashboard', [ResepsionisController::class, 'dashboard'])
        ->name('resepsionis.dashboard');

    // CRUD Pasien
    Route::get   ('/resepsionis/pasien',               [ResepsionisController::class, 'index'])
        ->name('resepsionis.index');
    Route::post  ('/resepsionis/pasien',               [ResepsionisController::class, 'store'])
        ->name('resepsionis.store');
    Route::get   ('/resepsionis/pasien/{pasien}/edit', [ResepsionisController::class, 'edit'])
        ->name('resepsionis.edit');
    Route::put   ('/resepsionis/pasien/{pasien}',      [ResepsionisController::class, 'update'])

        ->name('resepsionis.update');
    // Laporan Pasien
    Route::get('/resepsionis/laporan', [ResepsionisController::class, 'laporan'])
        ->name('resepsionis.laporan');

    /* =======================
       DOKTER
    ======================= */
    // Dokter Umum
    Route::get('/dokter/umum',          [DokterController::class, 'umum'])->name('dokter.dokterumum');
    Route::put('/dokter/umum/{id}',     [DokterController::class, 'update'])->name('dokterumum.update');
    Route::post('/dokterumum/terima/{id}', [DokterController::class, 'terima'])->name('dokterumum.terima');
    Route::put('/dokterumum/selesai/{id}', [DokterController::class, 'selesai'])->name('dokterumum.selesai');

    // Dokter Gigi
    Route::get('/dokter/gigi',          [DokterController::class, 'gigi'])->name('dokter.doktergigi');
    Route::post('/doktergigi/terima/{id}', [DokterController::class, 'terima'])->name('doktergigi.terima');
    Route::put('/doktergigi/selesai/{id}', [DokterController::class, 'selesai'])->name('doktergigi.selesai');

    // Bidan
    Route::get('/dokter/bidan',         [DokterController::class, 'bidan'])->name('dokter.bidan');
    Route::post('/dokter/bidan/terima/{id}', [DokterController::class, 'terima'])->name('dokter.bidan.terima');
    Route::put('/dokter/bidan/selesai/{id}', [DokterController::class, 'selesai'])->name('dokter.bidan.selesai');

    /* =======================
       APOTEKER
    ======================= */
    Route::get('/apoteker/dashboard', [ApotekerController::class, 'index'])->name('apoteker.dashboard');
    Route::post('/apoteker/terima/{id}', [ApotekerController::class, 'terima'])->name('apoteker.terima');
    Route::put('/apoteker/selesai/{id}', [ApotekerController::class, 'selesai'])->name('apoteker.selesai');

    // Manajemen Stok
    Route::get   ('/apoteker/stok',       [ApotekerController::class, 'stok'])->name('apoteker.stok.index');
    Route::put   ('/apoteker/stok/{obat}',[ApotekerController::class, 'updateStok'])->name('apoteker.stok.update');
    Route::delete('/apoteker/stok/{id}',  [ApotekerController::class, 'hapusObat'])->name('apoteker.stok.hapus');
});
