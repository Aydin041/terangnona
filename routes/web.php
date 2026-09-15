<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Peserta\AuthController as PesertaAuthController;
use App\Http\Controllers\Peserta\PengajuanController as PesertaPengajuanController;
use App\Http\Controllers\Panitia\AuthController as PanitiaAuthController;
use App\Http\Controllers\Panitia\PengajuanController as PanitiaPengajuanController;
use App\Http\Controllers\Panitia\RankingController as PanitiaRankingController;
use App\Http\Controllers\Juri\AuthController as JuriAuthController;
use App\Http\Controllers\Juri\PenilaianController as JuriPenilaianController;
use App\Http\Controllers\Juri\KoreksiController as JuriKoreksiController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\KoreksiController as AdminKoreksiController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;

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
        Route::get('/dashboard', [PesertaPengajuanController::class, 'dashboard'])->name('dashboard');

        Route::get('/pengajuan/step1', [PesertaPengajuanController::class, 'step1Form'])->name('pengajuan.step1');
        Route::post('/pengajuan/step1', [PesertaPengajuanController::class, 'step1Store'])->name('pengajuan.step1.submit');
        Route::get('/pengajuan/step1/edit/{id}', [PesertaPengajuanController::class, 'step1Form'])->name('pengajuan.step1.edit');
        Route::post('/pengajuan/step1/edit/{id}', [PesertaPengajuanController::class, 'step1Store'])->name('pengajuan.step1.update');

        Route::get('/pengajuan/step2/{id}', [PesertaPengajuanController::class, 'step2Form'])->name('pengajuan.step2');
        Route::post('/pengajuan/step2/{id}', [PesertaPengajuanController::class, 'step2Store'])->name('pengajuan.step2.submit');
        Route::get('/pengajuan/step3/{id}', [PesertaPengajuanController::class, 'step3Form'])->name('pengajuan.step3');
        Route::post('/pengajuan/step3/{id}', [PesertaPengajuanController::class, 'step3Store'])->name('pengajuan.step3.submit');
        Route::get('/pengajuan/step4/{id}', [PesertaPengajuanController::class, 'step4Form'])->name('pengajuan.step4');
        Route::post('/pengajuan/step4/{id}', [PesertaPengajuanController::class, 'step4Store'])->name('pengajuan.step4.submit');
        Route::get('/pengajuan/step5/{id}', [PesertaPengajuanController::class, 'step5Form'])->name('pengajuan.step5');
        Route::post('/pengajuan/step5/{id}', [PesertaPengajuanController::class, 'step5Store'])->name('pengajuan.step5.submit');
    });
});

// Panitia
Route::prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/login', [PanitiaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PanitiaAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [PanitiaAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:panitia')->group(function () {
        Route::get('/dashboard', [PanitiaPengajuanController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan', [PanitiaPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{id}', [PanitiaPengajuanController::class, 'detail'])->name('pengajuan.detail');
        Route::post('/pengajuan/{id}/setujui', [PanitiaPengajuanController::class, 'setujui'])->name('pengajuan.setujui');
        Route::post('/pengajuan/{id}/kembalikan', [PanitiaPengajuanController::class, 'kembalikan'])->name('pengajuan.kembalikan');
        Route::get('/ranking', [PanitiaRankingController::class, 'index'])->name('ranking.index');
    });
});

// Juri
Route::prefix('juri')->name('juri.')->group(function () {
    Route::get('/login', [JuriAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [JuriAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [JuriAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:juri')->group(function () {
        Route::get('/dashboard', [JuriPenilaianController::class, 'index'])->name('dashboard');
        Route::get('/penilaian', [JuriPenilaianController::class, 'index'])->name('penilaian.index');

        Route::get('/penilaian/proposal/{id}', [JuriPenilaianController::class, 'proposalForm'])->name('penilaian.proposal');
        Route::post('/penilaian/proposal/{id}/draft', [JuriPenilaianController::class, 'proposalDraft'])->name('penilaian.proposal.draft');
        Route::post('/penilaian/proposal/{id}/submit', [JuriPenilaianController::class, 'proposalSubmit'])->name('penilaian.proposal.submit');
        Route::post('/penilaian/proposal/{id}/perbaikan', [JuriPenilaianController::class, 'proposalPerbaikanSubmit'])->name('penilaian.proposal.perbaikan');

        Route::get('/penilaian/presentasi/{id}', [JuriPenilaianController::class, 'presentasiForm'])->name('penilaian.presentasi');
        Route::post('/penilaian/presentasi/{id}/draft', [JuriPenilaianController::class, 'presentasiDraft'])->name('penilaian.presentasi.draft');
        Route::post('/penilaian/presentasi/{id}/submit', [JuriPenilaianController::class, 'presentasiSubmit'])->name('penilaian.presentasi.submit');
        Route::post('/penilaian/presentasi/{id}/perbaikan', [JuriPenilaianController::class, 'presentasiPerbaikanSubmit'])->name('penilaian.presentasi.perbaikan');

        Route::get('/koreksi/proposal/{id}', [JuriKoreksiController::class, 'ajukanProposalForm'])->name('koreksi.proposal.form');
        Route::post('/koreksi/proposal/{id}', [JuriKoreksiController::class, 'ajukanProposalSubmit'])->name('koreksi.proposal.submit');

        Route::get('/koreksi/presentasi/{id}', [JuriKoreksiController::class, 'ajukanPresentasiForm'])->name('koreksi.presentasi.form');
        Route::post('/koreksi/presentasi/{id}', [JuriKoreksiController::class, 'ajukanPresentasiSubmit'])->name('koreksi.presentasi.submit');
    });
});

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminKoreksiController::class, 'index'])->name('dashboard');
        Route::get('/koreksi', [AdminKoreksiController::class, 'index'])->name('koreksi.index');
        Route::post('/koreksi/{id}/setujui', [AdminKoreksiController::class, 'setujui'])->name('koreksi.setujui');
        Route::post('/koreksi/{id}/tolak', [AdminKoreksiController::class, 'tolak'])->name('koreksi.tolak');

        Route::get('/akun/panitia', [AdminAkunController::class, 'panitiaIndex'])->name('akun.panitia.index');
        Route::get('/akun/panitia/create', [AdminAkunController::class, 'panitiaCreateForm'])->name('akun.panitia.create');
        Route::post('/akun/panitia', [AdminAkunController::class, 'panitiaStore'])->name('akun.panitia.store');
        Route::get('/akun/panitia/{id}/reset', [AdminAkunController::class, 'panitiaResetForm'])->name('akun.panitia.reset.form');
        Route::post('/akun/panitia/{id}/reset', [AdminAkunController::class, 'panitiaReset'])->name('akun.panitia.reset');

        Route::get('/akun/juri', [AdminAkunController::class, 'juriIndex'])->name('akun.juri.index');
        Route::get('/akun/juri/create', [AdminAkunController::class, 'juriCreateForm'])->name('akun.juri.create');
        Route::post('/akun/juri', [AdminAkunController::class, 'juriStore'])->name('akun.juri.store');
        Route::get('/akun/juri/{id}/reset', [AdminAkunController::class, 'juriResetForm'])->name('akun.juri.reset.form');
        Route::post('/akun/juri/{id}/reset', [AdminAkunController::class, 'juriReset'])->name('akun.juri.reset');
    });
});