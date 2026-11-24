<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $initials = 'AD';
        if ($user && !empty($user->name)) {
            $parts = preg_split('/\s+/', trim($user->name));
            $initials = strtoupper(
                substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : substr($parts[0], 1, 1))
            );
        }

        // Data laporan sesuai tampilan pada gambar
        $allReports = collect([
            [
                'id' => 1,
                'judul' => 'Laptop Bekas Mulus',
                'pelapor' => 'Andi Alviansyah S',
                'alasan' => 'harga dan kondisi barang di deskripsi tidak sesuai foto',
                'tanggal' => '13 Sep 2026',
                'status' => 'Menunggu',
            ],
            [
                'id' => 2,
                'judul' => 'Percakapan dengan penjual "ML23"',
                'pelapor' => 'Melisa',
                'alasan' => 'harga dan kondisi barang di deskripsi tidak sesuai foto',
                'tanggal' => '13 Sep 2026',
                'status' => 'Menunggu',
            ],
        ]);

        $search = trim((string) $request->get('search', ''));

        $reports = $allReports
            ->when($search !== '', function ($collection) use ($search) {
                $lower = mb_strtolower($search);
                return $collection->filter(function ($item) use ($lower) {
                    return str_contains(mb_strtolower($item['judul']), $lower)
                        || str_contains(mb_strtolower($item['pelapor']), $lower)
                        || str_contains(mb_strtolower($item['alasan']), $lower);
                });
            })
            ->values();

        return view('admin.laporan.index', compact('reports', 'search', 'initials'));
    }

    public function followUp($id)
    {
        return redirect()
            ->route('admin.laporan.index')
            ->with('success', "Laporan #{$id} sedang ditindaklanjuti.");
    }

    public function reject($id)
    {
        return redirect()
            ->route('admin.laporan.index')
            ->with('success', "Laporan #{$id} telah ditolak.");
    }
}