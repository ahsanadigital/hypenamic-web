<?php

use App\Models\Event;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# Home =====================================================================
Route::get('/', [\App\Http\Controllers\HomeController::class, 'main'])->name('home');
Route::get('/pricing', [\App\Http\Controllers\HomeController::class, 'pricing'])->name('pricing');
Route::get('/kebijakan-privasi', [\App\Http\Controllers\HomeController::class, 'privasi'])->name('privasi');
Route::get('/syarat-dan-ketentuan', [\App\Http\Controllers\HomeController::class, 'tos'])->name('tos');
Route::get('/keluar', [\App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
# Home =====================================================================

# Discover Section =========================================================
Route::prefix('event')->group(function () {
    Route::get('/', [\App\Http\Controllers\DiscoverController::class, 'main'])->name('jelajah');
    Route::get('/kategori/{slug}', [\App\Http\Controllers\DiscoverController::class, 'kategori'])->name('jelajah.kategori');
    Route::get('/details/{id}', [\App\Http\Controllers\DiscoverController::class, 'show'])->name('jelajah.show');

    Route::get('/o/{username}', [\App\Http\Controllers\DiscoverController::class, 'organization'])->name('organization-events.main');
});
# Organization or Personal Event List ======================================

# Pengumuman ===============================================================
Route::prefix('pengumuman')->group(function () {
    Route::get('/', [\App\Http\Controllers\Pengumuman::class, 'main'])->name('pengumuman');
    Route::get('/{slug}', [\App\Http\Controllers\Pengumuman::class, 'view'])->name('pengumuman.show');
});
# Pengumuman ===============================================================

# Keranjang Belanjaan ======================================================
Route::prefix('checkout')->group(function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
    Route::get('/hapus-semua', [\App\Http\Controllers\CartController::class, 'truncate'])->name('cart.truncate');
    Route::any('/proses', [\App\Http\Controllers\CartController::class, 'proses'])->name('cart.process');
});
# Keranjang Belanjaan ======================================================

# Invoice Pay ==============================================================
Route::prefix('invoice')->group(function () {
    Route::get('/', [\App\Http\Controllers\InvoiceController::class, 'main'])->name('invoice-main');
    Route::get('/pay/{id}', [\App\Http\Controllers\InvoiceController::class, 'pay'])->name('invoice-pay');
    Route::get('/check', [\App\Http\Controllers\InvoiceController::class, 'check'])->name('invoice-check');
});
# Invoice Pay ==============================================================

# Notifikasi ===============================================================
Route::prefix('pay')->group(function () {
    Route::any('/finish', [\App\Http\Controllers\PaymentController::class, 'finish'])->name('pay-finish');
    Route::any('/pending', [\App\Http\Controllers\PaymentController::class, 'pending'])->name('pay-pending');
    Route::any('/error', [\App\Http\Controllers\PaymentController::class, 'error'])->name('pay-error');
});

Route::prefix('notify')->group(function () {
    Route::view('/sukses', 'notifikasi-sukses')->name('notify.success');
    Route::view('/sukses-kirim', 'notifikasi-sukses-alt')->name('notify.success-alt');
    Route::view('/pending', 'notifikasi-pending')->name('notify.pending');
    Route::view('/failure', 'notifikasi-failure')->name('notify.failure');
});
# Notifikasi ===============================================================

# Verifikasi Tiket =========================================================
Route::prefix('detail-tiket')->group(function () {
    Route::any('/{id}', [\App\Http\Controllers\VerifyTicket::class, 'main'])->name('verify-tiket-main');
    Route::any('/verifikasi', [\App\Http\Controllers\VerifyTicket::class, 'verify'])->name('verify-tiket');
});
# Verifikasi Tiket =========================================================

# User Auth ================================================================
Route::any('/register', function () {})->name('user.register');
Route::any('/login', function () {})->name('user.login');
# User Auth ================================================================

# Administrator ============================================================
Route::prefix('administrator')->group(function () {

    // Login ==========
    Route::prefix('auth')->middleware('auth.admin')->group(function () {
        Route::any('/', [\App\Http\Controllers\admin\LoginAdminController::class, 'login'])->name('admin.login');
        Route::post('/process', [\App\Http\Controllers\admin\LoginAdminController::class, 'process'])->name('admin.auth');
    });
    // Login ==========

    Route::middleware('auth.adminloggedin')->group(function() {
        Route::any('/', [\App\Http\Controllers\admin\HomeAdminController::class, 'main'])->name('admin.main');

        Route::prefix('event')->group(function() {
            Route::any('/', [\App\Http\Controllers\admin\EventAdminController::class, 'main'])->name('admin.event-main');
            Route::any('/{id}/edit', [\App\Http\Controllers\admin\EventAdminController::class, 'edit'])->name('admin.event-edit');
            Route::any('/{id}/view', [\App\Http\Controllers\admin\EventAdminController::class, 'view'])->name('admin.event-detail');
            Route::any('/{id}/delete', [\App\Http\Controllers\admin\EventAdminController::class, 'delete'])->name('admin.event-delete');
            Route::any('/tambah', [\App\Http\Controllers\admin\EventAdminController::class, 'add'])->name('admin.event-add');
        });

        Route::prefix('pelanggan')->group(function() {
            Route::any('/', [\App\Http\Controllers\admin\PelangganAdminController::class, 'main'])->name('admin.pelanggan-main');
            Route::any('/add', [\App\Http\Controllers\admin\PelangganAdminController::class, 'add'])->name('admin.pelanggan-add');
            Route::any('/{id}/view', [\App\Http\Controllers\admin\PelangganAdminController::class, 'view'])->name('admin.pelanggan-view');
        });

        Route::prefix('event/category')->group(function() {
            Route::any('/', [\App\Http\Controllers\admin\EventCategoryController::class, 'main'])->name('admin.event-category-main');
        });
    });
});
# Administrator ============================================================
