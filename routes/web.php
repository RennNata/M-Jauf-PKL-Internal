<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    // ================================================
    // Route::get() = Tangani HTTP GET request
    // '/tentang'   = URL yang akan dihandle
    // function     = Kode yang dijalankan saat URL diakses
    // ================================================

    return view('tentang');
    // ↑ return view('tentang') = Tampilkan file tentang.blade.php
    // ↑ Laravel akan mencari di: resources/views/tentang.blade.php
});

Route::get('/sapa/{nama}', function ($nama) {
    // ================================================
    // Route dinamis dengan parameter {nama}
    // ================================================

    return "Halo, $nama! Selamat datang ";
    // ↑ Tampilkan sapaan dengan nama yang diberikan
});

Route::get('/kategori/{nama?}', function ($nama = 'Semua') {
        return "Kategori: $nama";
});

Route::get('/produk/{id}', function ($id) {
    return "Detail Produk $id";
})->name('produk.detail');