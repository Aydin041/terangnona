<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Peserta\AuthController as PesertaAuthController;
use App\Http\Controllers\Panitia\AuthController as PanitiaAuthController;
use App\Http\Controllers\Juri\AuthController as JuriAuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Peserta
Route::prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/register', [PesertaAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PesertaAuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [PesertaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PesertaAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [PesertaAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:peserta')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Peserta — halaman ini masih sementara.';
        })->name('dashboard');
    });
});

// Panitia
Route::prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/login', [PanitiaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PanitiaAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [PanitiaAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:panitia')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Panitia — halaman ini masih sementara.';
        })->name('dashboard');
    });
});

// Juri
Route::prefix('juri')->name('juri.')->group(function () {
    Route::get('/login', [JuriAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [JuriAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [JuriAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:juri')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Juri — halaman ini masih sementara.';
        })->name('dashboard');
    });
});

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Admin — halaman ini masih sementara.';
        })->name('dashboard');
    });
});