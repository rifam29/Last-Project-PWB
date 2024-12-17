<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route untuk form registrasi (GET)
Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/login', [AuthController::class, 'viewlogin'])->name('login.view');

// Route untuk proses registrasi (POST)

// Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');