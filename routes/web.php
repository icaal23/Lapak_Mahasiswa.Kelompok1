<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ChatWaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminModerasiController;
use App\Http\Controllers\Admin\AdminPenggunaController;
use App\Http\Controllers\Admin\AdminLaporanController;

use App\Http\Controllers\LaporanPendapatanController;
use App\Http\Controllers\PenjualanController;


// ==========================================
// HALAMAN UTAMA (PUBLIK)
// ==========================================

Route::get('/', [BerandaController::class, 'index'])
    ->name('beranda');

Route::redirect('/home', '/')->name('home');


// ==========================================
// AKSES LANGSUNG DASHBOARD & MENU USER (MODE PRESENTASI)
// Kembalikan ke Route::middleware('auth') setelah presentasi selesai
// ==========================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// --------------------------------------
// MANAJEMEN BARANG
// --------------------------------------

Route::get('/barang/tambah', [BarangController::class, 'create'])
    ->name('barang.create');

// --------------------------------------
// BARANG
// --------------------------------------

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
// TANDAI BARANG TERJUAL
// --------------------------------------

Route::get('/barang/{barang}/terjual', [PenjualanController::class, 'create'])
    ->name('barang.terjual.create');

Route::post('/barang/{barang}/terjual', [PenjualanController::class, 'store'])
    ->name('barang.terjual.store');

// --------------------------------------
// LAPORAN PENDAPATAN
// --------------------------------------

Route::get('/laporan-pendapatan', [LaporanPendapatanController::class, 'index'])
    ->name('laporan.pendapatan');

// Alias untuk route yang digunakan branch teman
Route::get('/laporan', [LaporanPendapatanController::class, 'index'])
    ->name('laporan.index');

// --------------------------------------
// KERANJANG
// --------------------------------------

Route::get('/keranjang', function () {
    $items = [
        [
            'nama'     => 'Buku Algoritma',
            'kategori' => 'Buku',
            'penjual'  => 'Mutmainnah Talib',
            'lokasi'   => 'Perpustakaan',
            'harga'    => 60000,
            'qty'      => 1,
        ],
        [
            'nama'     => 'Tas Ransel Laptop',
            'kategori' => 'Perlengkapan Kuliah',
            'penjual'  => 'Zaskia',
            'lokasi'   => 'Fakultas Teknik',
            'harga'    => 60000,
            'qty'      => 1,
        ],
    ];

    $subtotal = collect($items)->sum(fn ($i) => $i['harga'] * $i['qty']);

    return view('keranjang.index', compact('items', 'subtotal'));
})->name('keranjang.index');

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

Route::get('/chat', [ChatWaController::class, 'index'])
    ->name('chat.index');

Route::get('/chat/mulai/{barang_id}', [ChatWaController::class, 'mulaiChat'])
    ->name('chat.mulai');

// ==========================================
// HALAMAN ADMIN LAPAK KAMPUS
// ==========================================

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/ringkasan', [AdminDashboardController::class, 'index'])
        ->name('ringkasan');

    // KELOLA BARANG
    Route::get('/kelola-barang', [AdminBarangController::class, 'index'])
        ->name('barang.index');

    Route::get('/kelola-barang/{id}/edit', [AdminBarangController::class, 'edit'])
        ->whereNumber('id')
        ->name('barang.edit');

    Route::put('/kelola-barang/{id}', [AdminBarangController::class, 'update'])
        ->whereNumber('id')
        ->name('barang.update');

    Route::delete('/kelola-barang/{id}', [AdminBarangController::class, 'destroy'])
        ->whereNumber('id')
        ->name('barang.destroy');

    // MODERASI BARANG
    Route::get('/moderasi-barang', [AdminModerasiController::class, 'index'])
        ->name('moderasi.index');

    Route::post('/moderasi-barang/{id}/setujui', [AdminModerasiController::class, 'approve'])
        ->whereNumber('id')
        ->name('moderasi.approve');

    Route::post('/moderasi-barang/{id}/tolak', [AdminModerasiController::class, 'reject'])
        ->whereNumber('id')
        ->name('moderasi.reject');

    // KELOLA PENGGUNA
    Route::get('/kelola-pengguna', [AdminPenggunaController::class, 'index'])
        ->name('pengguna.index');

    Route::patch('/kelola-pengguna/{id}/toggle-status', [AdminPenggunaController::class, 'toggleStatus'])
        ->whereNumber('id')
        ->name('pengguna.toggle');

    // LAPORAN ADMIN
    Route::get('/laporan', [AdminLaporanController::class, 'index'])
        ->name('laporan.index');

    Route::post('/laporan/{id}/tindak-lanjuti', [AdminLaporanController::class, 'followUp'])
        ->whereNumber('id')
        ->name('laporan.followup');

    Route::post('/laporan/{id}/tolak', [AdminLaporanController::class, 'reject'])
        ->whereNumber('id')
        ->name('laporan.reject');

});



// ==========================================
// ROUTE AUTENTIKASI LARAVEL (REGISTER, RESET PASSWORD, DLL.)
// ==========================================

require __DIR__.'/auth.php';


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