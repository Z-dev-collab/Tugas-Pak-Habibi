<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PelangganController;

Route::get('/welcome', function () {
    return view('welcome');
});

// view Hello

Route::get('/hello', function () {
    return view('hello');
});

// view posts
Route::get('/posts/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts/', [PostController::class, 'store'])->name('posts.store');

// view barang
Route::get('/barang/', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang/', [BarangController::class, 'store'])->name('barang.store');

// view pelanggan
Route::get('/pelanggan/', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/createpelanggan', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('/pelanggan/', [PelangganController::class, 'store'])->name('pelanggan.store');