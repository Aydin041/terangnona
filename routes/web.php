<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Peserta\AuthController as PesertaAuthController;
use App\Http\Controllers\Peserta\PengajuanController;
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
        Route::get('/dashboard', [PengajuanController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengajuan/step1', [PengajuanController::class, 'step1Form'])->name('pengajuan.step1');
        Route::post('/pengajuan/step1', [PengajuanController::class, 'step1Store'])->name('pengajuan.step1.submit');
        Route::get('/pengajuan/step2/{id}', [PengajuanController::class, 'step2Form'])->name('pengajuan.step2');
        Route::post('/pengajuan/step2/{id}', [PengajuanController::class, 'step2Store'])->name('pengajuan.step2.submit');
        Route::get('/pengajuan/step3/{id}', [PengajuanController::class, 'step3Form'])->name('pengajuan.step3');
        Route::post('/pengajuan/step3/{id}', [PengajuanController::class, 'step3Store'])->name('pengajuan.step3.submit');
        Route::get('/pengajuan/step4/{id}', [PengajuanController::class, 'step4Form'])->name('pengajuan.step4');
        Route::post('/pengajuan/step4/{id}', [PengajuanController::class, 'step4Store'])->name('pengajuan.step4.submit');
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