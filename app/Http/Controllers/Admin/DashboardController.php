<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Statistik 4 Kartu Atas
        $stats = [
            'mahasiswa' => [
                'total' => 178,
                'growth' => '+9 minggu ini',
            ],
            'barang_aktif' => [
                'total' => 223,
                'growth' => '+35 minggu ini',
            ],
            'moderasi' => [
                'total' => 5,
                'status' => 'Perlu ditinjau',
            ],
            'laporan' => [
                'total' => 2,
                'status' => 'Perlu ditinjau',
            ],
        ];

        // Data Distribusi Barang per Kategori (Progress Bar)
        $kategoriDistribusi = [
            [
                'nama' => 'Buku',
                'persentase' => 58,
                'warna' => 'bg-[#F8BBD0]',
                'nominal' => 'Rp.60.000',
            ],
            [
                'nama' => 'Perlengkapan',
                'persentase' => 45,
                'warna' => 'bg-[#FFF176]',
                'nominal' => 'Rp.90.000',
            ],
            [
                'nama' => 'Elektronik',
                'persentase' => 34,
                'warna' => 'bg-[#7986CB]',
                'nominal' => 'Rp.205.000',
            ],
            [
                'nama' => 'Pakaian',
                'persentase' => 23,
                'warna' => 'bg-[#EF9A9A]',
                'nominal' => 'Rp.60.000',
            ],
            [
                'nama' => 'Lainnya',
                'persentase' => 15,
                'warna' => 'bg-[#10B981]',
                'nominal' => 'Rp.60.000',
            ],
        ];

        // Data Aktivitas Terbaru
        $aktivitasTerbaru = [
            [
                'bold' => 'Andi Alviansyah',
                'text' => 'mendaftar sebagai mahasiswa baru.',
                'bold_position' => 'start',
            ],
            [
                'bold' => 'Jaket Almamater Prodi',
                'text' => 'menunggu persetujuan moderasi.',
                'bold_position' => 'start',
            ],
            [
                'bold' => '“Laptop Bekas Mulus”.',
                'text' => 'Laporan baru pada barang',
                'bold_position' => 'end',
            ],
            [
                'bold' => 'Setrika Portable',
                'text' => 'ditandai terjual oleh penjual.',
                'bold_position' => 'start',
            ],
        ];

        return view('admin.ringkasan', compact('stats', 'kategoriDistribusi', 'aktivitasTerbaru'));
    }
}