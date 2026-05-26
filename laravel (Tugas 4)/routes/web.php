<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MajorController;

Route::get('/', function () {
    return view('welcome');
});