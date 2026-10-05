<?php

use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CashbackController as AdminCashbackController;
use App\Http\Controllers\Admin\CallbackRequestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PengajuanBantuanController;
use App\Http\Controllers\Admin\TahunAjarController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserImportController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\ImageUploadController;
use App\Http\Controllers\Api\MataKuliahController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BantuanPendanaanController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CashbackController;
use App\Http\Controllers\KonversiController;
use App\Http\Controllers\Admin\PengajuanUbahNimController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/prodi/{slug}', [PageController::class, 'prodi'])->name('prodi');

/*
|--------------------------------------------------------------------------
| Konversi Mata Kuliah (RPL)
|--------------------------------------------------------------------------
*/

Route::get('/konversi-mata-kuliah', [KonversiController::class, 'index'])->name('konversi');
Route::post('/konversi-mata-kuliah', [KonversiController::class, 'process'])->name('konversi.process');
Route::get('/konversi-mata-kuliah/laporan', [KonversiController::class, 'laporan'])->name('konversi.laporan');

/*
|--------------------------------------------------------------------------
| Bantuan Pendanaan
|--------------------------------------------------------------------------
*/

Route::get('/bantuan-pendanaan', [BantuanPendanaanController::class, 'index'])->name('bantuan');
Route::get('/bantuan-pendanaan/ajukan', [BantuanPendanaanController::class, 'ajukan'])->name('bantuan.ajukan');
Route::post('/bantuan-pendanaan/ajukan', [BantuanPendanaanController::class, 'store'])->name('bantuan.store');

/*
|--------------------------------------------------------------------------
| Blog
|--------------------------------------------------------------------------
*/

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| API (no CSRF)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class)->group(function () {
    Route::post('/callback', [CallbackController::class, 'store'])->name('api.callback');
    Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('api.upload-image');
    Route::get('/mata-kuliah', [MataKuliahController::class, 'search'])->name('api.mata-kuliah');
});

/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
*/

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Profil akun sendiri (admin maupun mahasiswa)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/foto', [ProfilController::class, 'hapusFoto'])->name('profil.foto.hapus');
    Route::post('/profil/ubah-nim', [ProfilController::class, 'ajukanUbahNim'])->name('profil.ubah-nim');
    Route::delete('/profil/ubah-nim/{pengajuan}', [ProfilController::class, 'batalkanPengajuan'])
        ->name('profil.ubah-nim.batal');

    // Pengajuan cashback oleh mahasiswa
    Route::get('/cashback', [CashbackController::class, 'index'])->name('cashback.index');
    Route::post('/cashback', [CashbackController::class, 'store'])->name('cashback.store');
    Route::delete('/cashback/{cashback}', [CashbackController::class, 'batal'])->name('cashback.batal');
    Route::get('/cashback/{cashback}/bukti', [CashbackController::class, 'bukti'])->name('cashback.bukti');
});

/*
|--------------------------------------------------------------------------
| Admin (authenticated)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Blog CRUD
    Route::resource('blog', BlogPostController::class)->except(['show'])->names([
        'index' => 'blog.index',
        'create' => 'blog.create',
        'store' => 'blog.store',
        'edit' => 'blog.edit',
        'update' => 'blog.update',
        'destroy' => 'blog.destroy',
    ]);

    // Callback requests
    Route::get('/callback', [CallbackRequestController::class, 'index'])->name('callback.index');
    Route::patch('/callback/{id}/contacted', [CallbackRequestController::class, 'markContacted'])->name('callback.contacted');
    Route::delete('/callback/{id}', [CallbackRequestController::class, 'destroy'])->name('callback.destroy');

    // Pengajuan bantuan pendanaan
    Route::get('/bantuan', [PengajuanBantuanController::class, 'index'])->name('bantuan.index');
    Route::get('/bantuan/{id}/berkas/{jenis}', [PengajuanBantuanController::class, 'berkas'])->name('bantuan.berkas');
    Route::patch('/bantuan/{id}/status', [PengajuanBantuanController::class, 'updateStatus'])->name('bantuan.status');
    Route::delete('/bantuan/{id}', [PengajuanBantuanController::class, 'destroy'])->name('bantuan.destroy');

    // Cashback: verifikasi, pembayaran, penolakan
    Route::get('/cashback', [AdminCashbackController::class, 'index'])->name('cashback.index');
    Route::patch('/cashback/{cashback}/verifikasi', [AdminCashbackController::class, 'verifikasi'])
        ->name('cashback.verifikasi');
    Route::post('/cashback/{cashback}/bayar', [AdminCashbackController::class, 'bayar'])->name('cashback.bayar');
    Route::patch('/cashback/{cashback}/tolak', [AdminCashbackController::class, 'tolak'])->name('cashback.tolak');
    Route::get('/cashback/{cashback}/bukti', [AdminCashbackController::class, 'bukti'])->name('cashback.bukti');

    // Pengajuan ubah NIM dari mahasiswa
    Route::get('/pengajuan-nim', [PengajuanUbahNimController::class, 'index'])->name('pengajuan-nim.index');
    Route::patch('/pengajuan-nim/{pengajuan}/setujui', [PengajuanUbahNimController::class, 'setujui'])
        ->name('pengajuan-nim.setujui');
    Route::patch('/pengajuan-nim/{pengajuan}/tolak', [PengajuanUbahNimController::class, 'tolak'])
        ->name('pengajuan-nim.tolak');

    // Impor massal peserta (didaftarkan sebelum resource agar tidak tertangkap users/{user})
    Route::get('users/import', [UserImportController::class, 'form'])->name('users.import');
    Route::get('users/import/template', [UserImportController::class, 'template'])->name('users.import.template');
    Route::post('users/import', [UserImportController::class, 'store'])->name('users.import.store');

    // Manajemen pengguna
    Route::resource('users', UserController::class)->except(['show']);

    // Manajemen tahun ajar (form tambah & edit lewat modal di halaman index)
    Route::resource('tahun-ajar', TahunAjarController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->parameters(['tahun-ajar' => 'tahunAjar']);

    // Events CRUD
    Route::resource('events', EventController::class)->except(['show']);
    Route::get('/events/{id}/registrations', [EventController::class, 'registrations'])->name('events.registrations');
    Route::post('/events/{id}/send-zoom', [EventController::class, 'sendZoom'])->name('events.send-zoom');
    Route::post('/events/{id}/send-sertif', [EventController::class, 'sendSertif'])->name('events.send-sertif');
});
