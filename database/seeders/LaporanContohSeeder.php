<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Data contoh untuk mencoba halaman Laporan Pendapatan.
 *
 *   php artisan db:seed --class=LaporanContohSeeder
 *
 * Pemilik data: user dengan email dari env SEED_EMAIL, atau user pertama.
 * Aman dijalankan berulang (updateOrCreate berdasarkan user + nama barang).
 */
class LaporanContohSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', env('SEED_EMAIL'))->first() ?? User::first();

        if (! $user) {
            $this->command?->warn('Belum ada user. Daftar dulu lewat halaman register, lalu jalankan seeder ini lagi.');

            return;
        }

        $awalBulan = now()->startOfMonth();

        // nama, kategori, harga tawar, harga jual, pembeli, tanggal terjual
        $terjual = [
            ['Setrika Portable', 'Elektronik', 95000, 90000, 'Muhammad Faisal', $awalBulan->copy()],
            ['Modul Praktikum Basis Data', 'Buku', 35000, 35000, 'Zaskia', $awalBulan->copy()],
            ['Kalkulator Scientific', 'Perlengkapan Kuliah', 85000, 80000, 'Andi Alviansyah S', $awalBulan->copy()],
            ['Almamater Unsulbar', 'Pakaian', 95000, 90000, 'Mutmainnah Talib', $awalBulan->copy()->subMonth()->addDays(14)],
            ['Buku Algoritma', 'Buku', 60000, 60000, 'Melisa', $awalBulan->copy()->subMonths(2)->addDays(9)],
        ];

        foreach ($terjual as [$nama, $kategori, $harga, $hargaJual, $pembeli, $tanggal]) {
            Barang::updateOrCreate(
                ['user_id' => $user->id, 'nama' => $nama],
                [
                    'kategori' => $kategori,
                    'harga' => $harga,
                    'kondisi' => 'Bekas-Baik',
                    'lokasi' => 'Kampus Unsulbar',
                    'status' => 'terjual',
                    'nama_pembeli' => $pembeli,
                    'harga_jual' => $hargaJual,
                    'terjual_pada' => $tanggal,
                ]
            );
        }

        // Barang yang masih aktif (menunggu pembeli)
        foreach ([
            ['Laptop Lenovo', 'Elektronik', 3500000],
            ['Tas Ransel Laptop', 'Perlengkapan Kuliah', 60000],
        ] as [$nama, $kategori, $harga]) {
            Barang::updateOrCreate(
                ['user_id' => $user->id, 'nama' => $nama],
                [
                    'kategori' => $kategori,
                    'harga' => $harga,
                    'kondisi' => 'Bekas-Baik',
                    'lokasi' => 'Kampus Unsulbar',
                    'status' => 'aktif',
                ]
            );
        }

        $this->command?->info("Data contoh laporan dibuat untuk {$user->email}.");
    }
}
