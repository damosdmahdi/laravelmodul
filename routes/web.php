<?php

use App\Http\Controllers\BelajarController;
use App\Http\Controllers\CheckerController;
use App\Http\Controllers\LabKasusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Modul & Lab Pembelajaran Laravel SMK
|--------------------------------------------------------------------------
*/

// Halaman Utama: Dashboard Portal Belajar Laravel SMK
Route::get('/', [BelajarController::class, 'index'])->name('home');

// ==========================================
// PILAR 1: MATERI & SIMULATOR INTERAKTIF
// ==========================================
Route::prefix('belajar')->name('belajar.')->group(function () {
    Route::get('/', [BelajarController::class, 'index'])->name('index');
    Route::get('/modul-1', [BelajarController::class, 'modul1'])->name('modul1');
    Route::get('/modul-2', [BelajarController::class, 'modul2'])->name('modul2');
    Route::get('/modul-3', [BelajarController::class, 'modul3'])->name('modul3');
    Route::get('/modul-4', [BelajarController::class, 'modul4'])->name('modul4');
    Route::get('/modul-5', [BelajarController::class, 'modul5'])->name('modul5');
    Route::get('/modul-6', [BelajarController::class, 'modul6'])->name('modul6');
});

// ==========================================
// PILAR 2: SISTEM AUTOCHECKER TUGAS SISWA
// (Memeriksa folder tugas-siswa secara otomatis)
// ==========================================
Route::prefix('tugas-siswa')->name('tugas.')->group(function () {
    Route::get('/', [CheckerController::class, 'index'])->name('index');
    Route::post('/init', [CheckerController::class, 'initWorkspace'])->name('init');
    Route::get('/api/check', [CheckerController::class, 'checkAjax'])->name('api');
});

// ==========================================
// STUDI KASUS & TANTANGAN PENGERJAAN SISWA
// (Halaman belum sempurna tapi bisa dijalankan + tanda pengerja)
// ==========================================
Route::prefix('lab-kasus')->name('lab-kasus.')->group(function () {
    Route::get('/', [LabKasusController::class, 'index'])->name('index');
    Route::get('/tambah', [LabKasusController::class, 'create'])->name('create');
    Route::post('/simpan', [LabKasusController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [LabKasusController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [LabKasusController::class, 'update'])->name('update');
    Route::delete('/hapus/{id}', [LabKasusController::class, 'destroy'])->name('destroy');
    Route::post('/reset-data', [LabKasusController::class, 'resetData'])->name('reset');
    Route::get('/simulasi-kelompok', [LabKasusController::class, 'kelompok'])->name('kelompok');
});

// ==========================================
// TEMPLATE STATIS MENTAH (BAHAN MENTOR MODUL 3)
// ==========================================
Route::prefix('template-statis')->group(function () {
    Route::get('/', function () {
        return view('template_statis.index');
    })->name('template.index');

    Route::get('/tambah', function () {
        return view('template_statis.tambah');
    })->name('template.tambah');

    Route::get('/edit', function () {
        return view('template_statis.edit');
    })->name('template.edit');
});
