<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PerbandinganController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AhpController;
use App\Http\Controllers\PenggunaController;

Route::get('/', function () {
    return view('welcome');
});

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
//  semua fitur pakai auth
Route::middleware('auth')->group(function () {

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔥 SISWA
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/edit/{id}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::get('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.delete');

    // 🔥 KRITERIA
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');

Route::get('/kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');

Route::post('/kriteria/store', [KriteriaController::class, 'store'])->name('kriteria.store');

Route::get('/kriteria/edit/{id}', [KriteriaController::class, 'edit'])->name('kriteria.edit');

Route::put('/kriteria/update/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');

Route::get('/kriteria/delete/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.delete');

    // 🔥 AHP (Perbandingan)

Route::get('/ahp', [AhpController::class, 'index'])
    ->name('ahp.index');
Route::post('/ahp/simpan', [AhpController::class, 'simpan'])
    ->name('ahp.simpan');

    // 🔥 PENILAIAN
// Bulk store dari halaman index (semua siswa sekaligus)
Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

// Individual per siswa (dari tombol detail di ranking/dashboard)
Route::get('/penilaian/{siswa}/create', [PenilaianController::class, 'create'])->name('penilaian.create');
Route::get('/penilaian/{siswa}/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
Route::put('/penilaian/{siswa}', [PenilaianController::class, 'update'])->name('penilaian.update');
Route::delete('/penilaian/{siswa}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');
    

    // 🔥 RANKING
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');

});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::resource('/pengguna', PenggunaController::class);
    
});