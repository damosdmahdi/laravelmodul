<?php

use App\Http\Controllers\ApiItemController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\CheckerController;
use App\Http\Controllers\LabKasusController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Platform Belajar & Lab Inventaris SMK
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

    // Laboratorium Keamanan Web (Security Hub)
    Route::get('/keamanan', [SecurityController::class, 'index'])->name('keamanan');
    Route::post('/keamanan/role-check', [SecurityController::class, 'simulateRoleCheck'])->name('keamanan.role');
    Route::post('/keamanan/rate-limit', [SecurityController::class, 'simulateRateLimit'])->name('keamanan.ratelimit');
    Route::post('/keamanan/rate-limit-reset', [SecurityController::class, 'resetRateLimit'])->name('keamanan.ratelimit.reset');
    Route::post('/keamanan/hash', [SecurityController::class, 'simulateHash'])->name('keamanan.hash');
    Route::post('/keamanan/xss', [SecurityController::class, 'simulateXss'])->name('keamanan.xss');
    Route::post('/keamanan/mass-assignment', [SecurityController::class, 'simulateMassAssignment'])->name('keamanan.massassignment');
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
// PILAR 3: STUDI KASUS SISTEM INVENTARIS LAB SMK
// (Fitur Lengkap: CRUD, Show, Trash, Laporan, Peminjaman, API Docs)
// ==========================================
Route::prefix('lab-kasus')->name('lab-kasus.')->group(function () {
    // 1. Manajemen Barang Inventaris
    Route::get('/', [LabKasusController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [LabKasusController::class, 'show'])->name('show');
    Route::get('/tambah', [LabKasusController::class, 'create'])->name('create');
    Route::post('/simpan', [LabKasusController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [LabKasusController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [LabKasusController::class, 'update'])->name('update');
    Route::delete('/hapus/{id}', [LabKasusController::class, 'destroy'])->name('destroy');
    Route::post('/reset-data', [LabKasusController::class, 'resetData'])->name('reset');

    // 2. Proteksi Data: Soft Deletes & Tong Sampah (Recycle Bin)
    Route::get('/trash', [LabKasusController::class, 'trash'])->name('trash');
    Route::post('/trash/{id}/restore', [LabKasusController::class, 'restore'])->name('restore');
    Route::delete('/trash/{id}/force', [LabKasusController::class, 'forceDelete'])->name('force-delete');

    // 3. Cetak Berita Acara & Rekapitulasi Laporan Resmi
    Route::get('/laporan', [LabKasusController::class, 'laporan'])->name('laporan');

    // 4. Sistem Transaksi & Relasi Peminjaman Alat Lab
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/simpan', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');

    // 5. Dokumentasi Interaktif RESTful API Lab
    Route::get('/api-docs', [LabKasusController::class, 'apiDocs'])->name('api-docs');
});

// ==========================================
// RESTFUL WEB API ENDPOINTS (v1)
// ==========================================
Route::prefix('api/v1')->group(function () {
    Route::get('/items', [ApiItemController::class, 'index']);
    Route::get('/items/{id}', [ApiItemController::class, 'show']);
    Route::post('/items', [ApiItemController::class, 'store']);
    Route::get('/stats', [ApiItemController::class, 'stats']);
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
