<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

# Api Wilayah Indonesia =================================================================================
Route::any('/wilayah/provinsi', [\App\Http\Controllers\ApiGlobalController::class, 'dataProvinsi'])->name('wilayah.provinsi');
Route::any('/wilayah/{provinsi}/kabupaten', [\App\Http\Controllers\ApiGlobalController::class, 'dataKabupaten'])->name('wilayah.kabupaten');
Route::any('/wilayah/{kabupaten}/kecamatan', [\App\Http\Controllers\ApiGlobalController::class, 'dataKecamatan'])->name('wilayah.kecamatan');
Route::any('/wilayah/{kecamatan}/kelurahan', [\App\Http\Controllers\ApiGlobalController::class, 'dataKelurahan'])->name('wilayah.kelurahan');
# Api Wilayah Indonesia =================================================================================

# Events List ===========================================================================================
Route::any('/event/search', [\App\Http\Controllers\DiscoverController::class, 'search'])->name('jelajah.api-search');
# Events List ===========================================================================================

# Cart Addition =========================================================================================
Route::any('/cart/action/add', [\App\Http\Controllers\CartController::class, 'cart'])->name('cart.addition');
# Cart Addition =========================================================================================


// Administrator
Route::prefix('administrator')->group(function() {
    Route::any('/event/data', [\App\Http\Controllers\admin\EventAdminController::class, 'datatable'])->name('admin.event-data');
    Route::any('/event/tambah', [\App\Http\Controllers\admin\EventAdminController::class, 'addProcess'])->name('admin.event-addProcess');
    Route::any('/event/edit', [\App\Http\Controllers\admin\EventAdminController::class, 'editData'])->name('admin.event-editProcess');

    Route::any('/event/search-user', [\App\Http\Controllers\admin\EventAdminController::class, 'getUser'])->name('admin.event-suser');
    Route::any('/event/search-category', [\App\Http\Controllers\admin\EventAdminController::class, 'getCategory'])->name('admin.event-scat');
    Route::any('/event/add-category', [\App\Http\Controllers\admin\EventAdminController::class, 'addCategory'])->name('admin.event-cat');

    Route::any('/event/ticket/add/process', [\App\Http\Controllers\admin\EventTicketController::class, 'addTicket'])->name('admin.event-ticket-addProcess');
    Route::any('/event/ticket/edit/process', [\App\Http\Controllers\admin\EventTicketController::class, 'editTicket'])->name('admin.event-ticket-editProcess');
    Route::any('/event/ticket/detail', [\App\Http\Controllers\admin\EventTicketController::class, 'details'])->name('admin.event-ticket-detail');

    Route::any('/pelanggan/data', [\App\Http\Controllers\admin\PelangganAdminController::class, 'datatable'])->name('admin.pelanggan-data');

    Route::any('/category/data', [\App\Http\Controllers\admin\EventCategoryController::class, 'datatable'])->name('admin.category-data');
    Route::any('/category/edit', [\App\Http\Controllers\admin\EventCategoryController::class, 'edit'])->name('admin.category-edit');
    Route::any('/category/add', [\App\Http\Controllers\admin\EventCategoryController::class, 'add'])->name('admin.category-add');
    Route::any('/category/{slug}/delete', [\App\Http\Controllers\admin\EventCategoryController::class, 'delete'])->name('admin.category-delete');
});
// Administrator
