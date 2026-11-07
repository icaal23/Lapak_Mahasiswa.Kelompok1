<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = ['Semua', 'Buku', 'Elektronik', 'Pakaian', 'Perlengkapan Kuliah', 'Lainnya'];

        $tema = [
            'Buku'                => ['ikon' => 'buku',       'warna' => 'bg-c-buku'],
            'Elektronik'          => ['ikon' => 'elektronik', 'warna' => 'bg-c-elektronik'],
            'Pakaian'             => ['ikon' => 'pakaian',    'warna' => 'bg-c-pakaian'],
            'Perlengkapan Kuliah' => ['ikon' => 'tas',        'warna' => 'bg-c-kuliah'],
            'Lainnya'             => ['ikon' => 'lainnya',    'warna' => 'bg-c-lain'],
        ];

        $semua = collect([
            ['kategori' => 'Buku',                'nama' => 'Buku Algoritma',      'harga' => 60000,   'penjual' => 'Mutmainnah Talib'],
            ['kategori' => 'Elektronik',          'nama' => 'Laptop Lenovo',       'harga' => 3500000, 'penjual' => 'Melisa'],
            ['kategori' => 'Pakaian',             'nama' => 'Almamater Unsulbar',  'harga' => 95000,   'penjual' => 'Muhammad Faisal'],
            ['kategori' => 'Perlengkapan Kuliah', 'nama' => 'Tas Ransel Laptop',   'harga' => 60000,   'penjual' => 'Zaskia'],
            ['kategori' => 'Perlengkapan Kuliah', 'nama' => 'Kalkulator Scientific', 'harga' => 45000,  'penjual' => 'Mutmainnah Talib'],
            ['kategori' => 'Elektronik',          'nama' => 'Setrika Portable',    'harga' => 90000,   'penjual' => 'Melisa'],
            ['kategori' => 'Buku',                'nama' => 'Modul Praktikum BD',  'harga' => 35000,   'penjual' => 'Muhammad Faisal'],
            ['kategori' => 'Lainnya',             'nama' => 'Rak Buku Kayu Kecil', 'harga' => 55000,   'penjual' => 'Zaskia'],
        ])->map(fn ($b) => $b + $tema[$b['kategori']] + ['kondisi' => 'Bekas - Baik']);

        $aktif = $request->query('kategori', 'Semua');
        $q = trim((string) $request->query('q', ''));

        $barang = $semua
            ->when($aktif !== 'Semua', fn ($c) => $c->where('kategori', $aktif))
            ->when($q !== '', fn ($c) => $c->filter(fn ($b) => str_contains(strtolower($b['nama']), strtolower($q))))
            ->values();

        return view('dashboard', compact('kategoriList', 'barang', 'aktif', 'q'));
    }
}