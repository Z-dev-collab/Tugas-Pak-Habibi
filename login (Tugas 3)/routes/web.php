<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [LoginController::class, 'showLogin'])->name('auth.login');
Route::post('login', [LoginController::class, 'login'])->name('login.proceed');

Route::get('/dashboard', function(){
    return view('dashboard');
});
