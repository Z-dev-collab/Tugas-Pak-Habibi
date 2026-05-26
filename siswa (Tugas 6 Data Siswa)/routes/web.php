<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect()->route('majors.index');
});

// Major Routes
Route::get('/major/', [MajorController::class, 'index'])->name('majors.index');
Route::get('/major/create', [MajorController::class, 'create'])->name('majors.create');
Route::post('/major/', [MajorController::class, 'store'])->name('majors.store');
Route::get('/major/{major}', [MajorController::class, 'show'])->name('majors.show');
Route::get('/major/{major}/edit', [MajorController::class, 'edit'])->name('majors.edit');
Route::put('/major/{major}', [MajorController::class, 'update'])->name('majors.update');
Route::delete('/major/{major}', [MajorController::class, 'destroy'])->name('majors.destroy');

// Classroom Routes
Route::get('/classroom/', [ClassroomController::class, 'index'])->name('classrooms.index');
Route::get('/classroom/create', [ClassroomController::class, 'create'])->name('classrooms.create');
Route::post('/classroom/', [ClassroomController::class, 'store'])->name('classrooms.store');
Route::get('/classroom/{classroom}', [ClassroomController::class, 'show'])->name('classrooms.show');
Route::get('/classroom/{classroom}/edit', [ClassroomController::class, 'edit'])->name('classrooms.edit');
Route::put('/classroom/{classroom}', [ClassroomController::class, 'update'])->name('classrooms.update');
Route::delete('/classroom/{classroom}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');

// Student Routes
Route::get('/student/', [StudentController::class, 'index'])->name('students.index');
Route::get('/student/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/student/', [StudentController::class, 'store'])->name('students.store');
Route::get('/student/{student}', [StudentController::class, 'show'])->name('students.show');
Route::get('/student/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/student/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/student/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
