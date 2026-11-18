
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ChatWaController;


// ==========================================
// HALAMAN UTAMA (PUBLIK)
// ==========================================

Route::get('/', [BerandaController::class, 'index'])
    ->name('beranda');


// ==========================================
// HALAMAN DASHBOARD
// ==========================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


// ==========================================
// ROUTE YANG MEMERLUKAN LOGIN
// ==========================================

Route::middleware('auth')->group(function () {

    // --------------------------------------
    // MANAJEMEN BARANG
    // --------------------------------------

    Route::get('/barang/tambah', [BarangController::class, 'create'])
        ->name('barang.create');

    Route::post('/barang', [BarangController::class, 'store'])
        ->name('barang.store');

    Route::get('/barang', [BarangController::class, 'index'])
        ->name('barang.index');

    Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])
        ->name('barang.edit');

    Route::put('/barang/{barang}', [BarangController::class, 'update'])
        ->name('barang.update');

    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])
        ->name('barang.destroy');


    // --------------------------------------
    // MANAJEMEN PROFIL
    // --------------------------------------

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // --------------------------------------
    // FITUR CHAT WHATSAPP
    // --------------------------------------

    // Menampilkan daftar percakapan
    Route::get('/chat', [ChatWaController::class, 'index'])
        ->name('chat.index');

    // Memulai percakapan dengan penjual
    Route::get('/chat/mulai/{barang_id}', [ChatWaController::class, 'mulaiChat'])
        ->name('chat.mulai');

});


// ==========================================
// ROUTE AUTENTIKASI LARAVEL
// ==========================================

require __DIR__.'/auth.php';
