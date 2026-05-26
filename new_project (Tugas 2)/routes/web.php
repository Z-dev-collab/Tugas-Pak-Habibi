<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MajorController;

Route::get('/', function () {
    return view('welcome');
});

// view major
Route::get('/major/', [MajorController::class, 'index'])->name('major.index');
Route::get('/major/create', [MajorController::class, 'create'])->name('major.create');
Route::post('/major/', [MajorController::class, 'store'])->name('major.store');
