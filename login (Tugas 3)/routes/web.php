<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

route::get('login', [LoginController::class, 'showLogin'])->name('auth.login');
route::post('login', [LoginController::class, 'login'])->name('login.proceed');

route::get('/dashboard', function(){
    return view('dashboard');
});
