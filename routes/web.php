<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Peserta\AuthController as PesertaAuthController;
use App\Http\Controllers\Peserta\PengajuanController as PesertaPengajuanController;
use App\Http\Controllers\Panitia\AuthController as PanitiaAuthController;
use App\Http\Controllers\Panitia\PengajuanController as PanitiaPengajuanController;
use App\Http\Controllers\Panitia\RankingController as PanitiaRankingController;
use App\Http\Controllers\Panitia\LaporanController as PanitiaLaporanController;
use App\Http\Controllers\Juri\AuthController as JuriAuthController;
use App\Http\Controllers\Juri\PenilaianController as JuriPenilaianController;
use App\Http\Controllers\Juri\KoreksiController as JuriKoreksiController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\KoreksiController as AdminKoreksiController;
use App\Http\Controllers\Admin\AkunController as AdminAkunController;
use App\Http\Controllers\Admin\PengaturanController as AdminPengaturanController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Pimpinan\AuthController as PimpinanAuthController;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\PengajuanController as PimpinanPengajuanController;
use App\Http\Controllers\Pimpinan\RankingController as PimpinanRankingController;
use App\Models\Pengajuan;
use App\Models\Panitia;
use App\Models\Juri;
use App\Models\Peserta;
use App\Models\Pimpinan;
use App\Models\PermintaanBukaKunci;
use App\Http\Middleware\BatasiPercobaanLogin;
use App\Http\Middleware\PimpinanReadOnly;

// Kode acak (UUID) di URL pengajuan diubah kembali menjadi id internal sebelum masuk ke controller.
// Alamat dengan angka biasa (misalnya /step4/66) tidak lagi dikenali dan menghasilkan halaman 404.
Route::bind('pengajuan', function (string $uuid) {
    return Pengajuan::where('uuid', $uuid)->value('id') ?? abort(404);
});

Route::bind('permintaan', fn (string $uuid) => PermintaanBukaKunci::where('uuid', $uuid)->value('id') ?? abort(404));
Route::bind('panitia', fn (string $uuid) => Panitia::where('uuid', $uuid)->value('id') ?? abort(404));
Route::bind('juri', fn (string $uuid) => Juri::where('uuid', $uuid)->value('id') ?? abort(404));
Route::bind('peserta', fn (string $uuid) => Peserta::where('uuid', $uuid)->value('id') ?? abort(404));
Route::bind('pimpinan', fn (string $uuid) => Pimpinan::where('uuid', $uuid)->value('id') ?? abort(404));

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Peserta
Route::prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/register', [PesertaAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [PesertaAuthController::class, 'register'])->name('register.submit');
    Route::get('/login', [PesertaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PesertaAuthController::class, 'login'])->middleware(BatasiPercobaanLogin::class . ':peserta')->name('login.submit');
    Route::post('/logout', [PesertaAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:peserta')->group(function () {
        Route::get('/dashboard', [PesertaPengajuanController::class, 'dashboard'])->name('dashboard');

        Route::get('/pengajuan/step1', [PesertaPengajuanController::class, 'step1Form'])->name('pengajuan.step1');
        Route::post('/pengajuan/step1', [PesertaPengajuanController::class, 'step1Store'])->name('pengajuan.step1.submit');
        Route::get('/pengajuan/step1/edit/{pengajuan}', [PesertaPengajuanController::class, 'step1Form'])->name('pengajuan.step1.edit');
        Route::post('/pengajuan/step1/edit/{pengajuan}', [PesertaPengajuanController::class, 'step1Store'])->name('pengajuan.step1.update');
        Route::post('/pengajuan/{pengajuan}/hapus', [PesertaPengajuanController::class, 'hapus'])->name('pengajuan.hapus');

        Route::get('/pengajuan/step2/{pengajuan}', [PesertaPengajuanController::class, 'step2Form'])->name('pengajuan.step2');
        Route::post('/pengajuan/step2/{pengajuan}', [PesertaPengajuanController::class, 'step2Store'])->name('pengajuan.step2.submit');
        Route::get('/pengajuan/step3/{pengajuan}', [PesertaPengajuanController::class, 'step3Form'])->name('pengajuan.step3');
        Route::post('/pengajuan/step3/{pengajuan}', [PesertaPengajuanController::class, 'step3Store'])->name('pengajuan.step3.submit');
        Route::get('/pengajuan/step4/{pengajuan}', [PesertaPengajuanController::class, 'step4Form'])->name('pengajuan.step4');
        Route::post('/pengajuan/step4/{pengajuan}', [PesertaPengajuanController::class, 'step4Store'])->name('pengajuan.step4.submit');
        Route::get('/pengajuan/step5/{pengajuan}', [PesertaPengajuanController::class, 'step5Form'])->name('pengajuan.step5');
        Route::post('/pengajuan/step5/{pengajuan}', [PesertaPengajuanController::class, 'step5Store'])->name('pengajuan.step5.submit');
    });
});

// Panitia
Route::prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/login', [PanitiaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PanitiaAuthController::class, 'login'])->middleware(BatasiPercobaanLogin::class . ':panitia')->name('login.submit');
    Route::post('/logout', [PanitiaAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:panitia')->group(function () {
        Route::get('/dashboard', [PanitiaPengajuanController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan', [PanitiaPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{pengajuan}', [PanitiaPengajuanController::class, 'detail'])->name('pengajuan.detail');
        Route::post('/pengajuan/{pengajuan}/setujui', [PanitiaPengajuanController::class, 'setujui'])->name('pengajuan.setujui');
        Route::post('/pengajuan/{pengajuan}/kembalikan', [PanitiaPengajuanController::class, 'kembalikan'])->name('pengajuan.kembalikan');
        Route::post('/pengajuan/{pengajuan}/tolak', [PanitiaPengajuanController::class, 'tolak'])->name('pengajuan.tolak');
        Route::get('/export/nilai-proposal', [PanitiaPengajuanController::class, 'exportNilaiProposal'])->name('export.nilai.proposal');
        Route::get('/export/nilai-presentasi', [PanitiaPengajuanController::class, 'exportNilaiPresentasi'])->name('export.nilai.presentasi');
        Route::get('/laporan-nilai', [PanitiaLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/ranking', [PanitiaRankingController::class, 'index'])->name('ranking.index');
    });
});

// Juri
Route::prefix('juri')->name('juri.')->group(function () {
    Route::get('/login', [JuriAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [JuriAuthController::class, 'login'])->middleware(BatasiPercobaanLogin::class . ':juri')->name('login.submit');
    Route::post('/logout', [JuriAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:juri')->group(function () {
        Route::get('/dashboard', [JuriPenilaianController::class, 'index'])->name('dashboard');
        Route::get('/penilaian', [JuriPenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/daftar-proposal', [JuriPenilaianController::class, 'indexProposal'])->name('penilaian.daftar.proposal');
        Route::get('/penilaian/daftar-presentasi', [JuriPenilaianController::class, 'indexPresentasi'])->name('penilaian.daftar.presentasi');

        Route::get('/penilaian/proposal/{pengajuan}', [JuriPenilaianController::class, 'proposalForm'])->name('penilaian.proposal');
        Route::post('/penilaian/proposal/{pengajuan}/draft', [JuriPenilaianController::class, 'proposalDraft'])->name('penilaian.proposal.draft');
        Route::post('/penilaian/proposal/{pengajuan}/submit', [JuriPenilaianController::class, 'proposalSubmit'])->name('penilaian.proposal.submit');
        Route::post('/penilaian/proposal/{pengajuan}/perbaikan', [JuriPenilaianController::class, 'proposalPerbaikanSubmit'])->name('penilaian.proposal.perbaikan');

        Route::get('/penilaian/presentasi/{pengajuan}', [JuriPenilaianController::class, 'presentasiForm'])->name('penilaian.presentasi');
        Route::post('/penilaian/presentasi/{pengajuan}/draft', [JuriPenilaianController::class, 'presentasiDraft'])->name('penilaian.presentasi.draft');
        Route::post('/penilaian/presentasi/{pengajuan}/submit', [JuriPenilaianController::class, 'presentasiSubmit'])->name('penilaian.presentasi.submit');
        Route::post('/penilaian/presentasi/{pengajuan}/perbaikan', [JuriPenilaianController::class, 'presentasiPerbaikanSubmit'])->name('penilaian.presentasi.perbaikan');

        Route::get('/koreksi/proposal/{pengajuan}', [JuriKoreksiController::class, 'ajukanProposalForm'])->name('koreksi.proposal.form');
        Route::post('/koreksi/proposal/{pengajuan}', [JuriKoreksiController::class, 'ajukanProposalSubmit'])->name('koreksi.proposal.submit');

        Route::get('/koreksi/presentasi/{pengajuan}', [JuriKoreksiController::class, 'ajukanPresentasiForm'])->name('koreksi.presentasi.form');
        Route::post('/koreksi/presentasi/{pengajuan}', [JuriKoreksiController::class, 'ajukanPresentasiSubmit'])->name('koreksi.presentasi.submit');
    });
});

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware(BatasiPercobaanLogin::class . ':admin')->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminKoreksiController::class, 'index'])->name('dashboard');
        Route::get('/koreksi', [AdminKoreksiController::class, 'index'])->name('koreksi.index');
        Route::post('/koreksi/{permintaan}/setujui', [AdminKoreksiController::class, 'setujui'])->name('koreksi.setujui');
        Route::post('/koreksi/{permintaan}/tolak', [AdminKoreksiController::class, 'tolak'])->name('koreksi.tolak');

        Route::get('/akun/panitia', [AdminAkunController::class, 'panitiaIndex'])->name('akun.panitia.index');
        Route::get('/akun/panitia/create', [AdminAkunController::class, 'panitiaCreateForm'])->name('akun.panitia.create');
        Route::post('/akun/panitia', [AdminAkunController::class, 'panitiaStore'])->name('akun.panitia.store');
        Route::get('/akun/panitia/{panitia}/reset', [AdminAkunController::class, 'panitiaResetForm'])->name('akun.panitia.reset.form');
        Route::post('/akun/panitia/{panitia}/reset', [AdminAkunController::class, 'panitiaReset'])->name('akun.panitia.reset');
        Route::post('/akun/panitia/{panitia}/hapus', [AdminAkunController::class, 'panitiaHapus'])->name('akun.panitia.hapus');

        Route::get('/akun/juri', [AdminAkunController::class, 'juriIndex'])->name('akun.juri.index');
        Route::get('/akun/juri/create', [AdminAkunController::class, 'juriCreateForm'])->name('akun.juri.create');
        Route::post('/akun/juri', [AdminAkunController::class, 'juriStore'])->name('akun.juri.store');
        Route::get('/akun/juri/{juri}/reset', [AdminAkunController::class, 'juriResetForm'])->name('akun.juri.reset.form');
        Route::post('/akun/juri/{juri}/reset', [AdminAkunController::class, 'juriReset'])->name('akun.juri.reset');
        Route::post('/akun/juri/{juri}/hapus', [AdminAkunController::class, 'juriHapus'])->name('akun.juri.hapus');

        Route::get('/akun/peserta', [AdminAkunController::class, 'pesertaIndex'])->name('akun.peserta.index');
        Route::get('/akun/peserta/{peserta}/reset', [AdminAkunController::class, 'pesertaResetForm'])->name('akun.peserta.reset.form');
        Route::post('/akun/peserta/{peserta}/reset', [AdminAkunController::class, 'pesertaReset'])->name('akun.peserta.reset');
        Route::post('/akun/peserta/{peserta}/hapus', [AdminAkunController::class, 'pesertaHapus'])->name('akun.peserta.hapus');

        Route::get('/akun/pimpinan', [AdminAkunController::class, 'pimpinanIndex'])->name('akun.pimpinan.index');
        Route::get('/akun/pimpinan/create', [AdminAkunController::class, 'pimpinanCreateForm'])->name('akun.pimpinan.create');
        Route::post('/akun/pimpinan', [AdminAkunController::class, 'pimpinanStore'])->name('akun.pimpinan.store');
        Route::get('/akun/pimpinan/{pimpinan}/reset', [AdminAkunController::class, 'pimpinanResetForm'])->name('akun.pimpinan.reset.form');
        Route::post('/akun/pimpinan/{pimpinan}/reset', [AdminAkunController::class, 'pimpinanReset'])->name('akun.pimpinan.reset');
        Route::post('/akun/pimpinan/{pimpinan}/hapus', [AdminAkunController::class, 'pimpinanHapus'])->name('akun.pimpinan.hapus');

        Route::get('/pengaturan', [AdminPengaturanController::class, 'form'])->name('pengaturan.form');
        Route::post('/pengaturan', [AdminPengaturanController::class, 'update'])->name('pengaturan.update');

        Route::get('/laporan-nilai', [AdminLaporanController::class, 'index'])->name('laporan.index');
    });
});

// Pimpinan (hanya lihat — semua rute di dalam grup auth hanya boleh GET)
Route::prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('/login', [PimpinanAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PimpinanAuthController::class, 'login'])->middleware(BatasiPercobaanLogin::class . ':pimpinan')->name('login.submit');
    Route::post('/logout', [PimpinanAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth:pimpinan', PimpinanReadOnly::class])->group(function () {
        Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan', [PimpinanPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{pengajuan}', [PimpinanPengajuanController::class, 'detail'])->name('pengajuan.detail');
        Route::get('/ranking', [PimpinanRankingController::class, 'index'])->name('ranking.index');
    });
});