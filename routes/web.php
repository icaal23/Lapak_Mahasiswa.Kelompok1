<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ChatWaController;
use App\Http\Controllers\AuthController;


// ==========================================
// HALAMAN UTAMA (PUBLIK)
// ==========================================

Route::get('/', [BerandaController::class, 'index'])
    ->name('beranda');

Route::redirect('/home', '/')->name('home');


// ==========================================
// ROUTE LOGIN KUSTOM & ADMIN LAPAK KAMPUS
// ==========================================

Route::middleware('guest')->group(function () {
    // Login Mahasiswa (Lapak Kampus)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Login Admin Kampus
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==========================================
// HALAMAN DASHBOARD & ROUTE TERPROTEKSI LOGIN
// ==========================================

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

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
// ROUTE AUTENTIKASI LARAVEL (REGISTER, RESET PASSWORD, DLL.)
// ==========================================

require __DIR__.'/auth.php';