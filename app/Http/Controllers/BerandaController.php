<?php

namespace App\Http\Controllers;

class BerandaController extends Controller
{
    public function index()
    {
        $statistik = [
            ['angka' => 223, 'label' => 'Barang Aktif'],
            ['angka' => 53,  'label' => 'Mahasiswa Terdaftar'],
            ['angka' => 5,   'label' => 'Kategori Barang'],
        ];

        $kategori = [
            ['nama' => 'Buku',                 'jumlah' => 18, 'ikon' => 'buku',       'warna' => 'c-buku'],
            ['nama' => 'Elektronik',           'jumlah' => 31, 'ikon' => 'elektronik', 'warna' => 'c-elektronik'],
            ['nama' => 'Pakaian',              'jumlah' => 48, 'ikon' => 'pakaian',    'warna' => 'c-pakaian'],
            ['nama' => 'Perlengkapan Kuliah',  'jumlah' => 55, 'ikon' => 'tas',        'warna' => 'c-kuliah'],
            ['nama' => 'Lainnya',              'jumlah' => 71, 'ikon' => 'lainnya',    'warna' => 'c-lain'],
        ];

        $barang = [
            ['kategori' => 'Buku',                'nama' => 'Buku Algoritma',     'harga' => 60000,   'kondisi' => 'Bekas - Baik', 'penjual' => 'Mutmainnah Talib', 'ikon' => 'buku',       'warna' => 'c-buku'],
            ['kategori' => 'Elektronik',          'nama' => 'Laptop Lenovo',      'harga' => 3500000, 'kondisi' => 'Bekas - Baik', 'penjual' => 'Melisa',           'ikon' => 'elektronik', 'warna' => 'c-elektronik'],
            ['kategori' => 'Pakaian',             'nama' => 'Almamater Unsulbar', 'harga' => 95000,   'kondisi' => 'Bekas - Baik', 'penjual' => 'Muhammad Faisal',  'ikon' => 'pakaian',    'warna' => 'c-pakaian'],
            ['kategori' => 'Perlengkapan Kuliah', 'nama' => 'Tas Ransel Laptop',  'harga' => 60000,   'kondisi' => 'Bekas - Baik', 'penjual' => 'Zaskia',           'ikon' => 'tas',        'warna' => 'c-kuliah'],
        ];

        $langkah = [
            ['no' => '01', 'judul' => 'Daftar dengan akun kampus',  'isi' => 'Gunakan email kampus dan NIM supaya sesama mahasiswa saling percaya.'],
            ['no' => '02', 'judul' => 'Unggah atau cari barang',    'isi' => 'Jual barang yang sudah tidak dipakai, atau cari kebutuhanmu lewat kategori dan filter.'],
            ['no' => '03', 'judul' => 'Sepakati & ambil di kampus', 'isi' => 'Chat penjual, sepakati harga dan lokasi bertemu di kampus'],
        ];

        return view('beranda', compact('statistik', 'kategori', 'barang', 'langkah'));
    }
}