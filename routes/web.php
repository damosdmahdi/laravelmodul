<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Starter kit routes untuk praktikum Laravel SMK Kelas 10 & 11.
|
*/

// Halaman Panduan & Starter Kit Dashboard
Route::get('/', function () {
    return view('welcome');
});

// Route Preview Template Statis (Sebelum diubah menjadi Master Layout Blade di Modul 3)
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
