<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminModerasiController extends Controller
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

        // Item utama yang ditampilkan pada daftar antrean moderasi
        $moderasiItems = collect([
            [
                'id' => 1,
                'barang' => 'Jaket Almamater Prodi',
                'penjual' => 'Mutmainnah Talib',
                'kategori' => 'Pakaian',
                'kategori_style' => 'bg-[#F9D8D6] text-[#9B2C2C]',
                'tanggal' => '13 Sep 2026',
                'status' => 'Menunggu',
                'icon_type' => 'shirt',
                'thumb_bg' => 'bg-[#FF6B6B]',
                'foto' => null,
            ],
            [
                'id' => 2,
                'barang' => 'Laptop Bekas Mulus',
                'penjual' => 'Muhammad Faisal',
                'kategori' => 'Elektronik',
                'kategori_style' => 'bg-[#DBEAFE] text-[#1D4ED8]',
                'tanggal' => '13 Sep 2026',
                'status' => 'Menunggu',
                'icon_type' => 'chip',
                'thumb_bg' => 'bg-[#60A5FA]',
                'foto' => null,
            ],
            [
                'id' => 3,
                'barang' => 'Rak Buku Kayu Kecil',
                'penjual' => 'Melisa',
                'kategori' => 'Lainnya',
                'kategori_style' => 'bg-[#E5E7EB] text-[#374151]',
                'tanggal' => '12 Sep 2026',
                'status' => 'Menunggu',
                'icon_type' => 'grid',
                'thumb_bg' => 'bg-[#86EFAC]',
                'foto' => null,
            ],
        ]);

        // Hitungan tab sesuai tampilan gambar (Menunggu (5))
        $counts = [
            'Menunggu' => 5,
            'Disetujui' => 0,
            'Ditolak' => 0,
            'Semua' => 5,
        ];

        $activeTab = $request->get('status', 'Menunggu');
        $search = trim((string) $request->get('search', ''));

        $items = $moderasiItems
            ->when($activeTab !== 'Semua', function ($collection) use ($activeTab) {
                return $collection->where('status', $activeTab);
            })
            ->when($search !== '', function ($collection) use ($search) {
                $lower = mb_strtolower($search);
                return $collection->filter(function ($item) use ($lower) {
                    return str_contains(mb_strtolower($item['barang']), $lower)
                        || str_contains(mb_strtolower($item['penjual']), $lower)
                        || str_contains(mb_strtolower($item['kategori']), $lower);
                });
            })
            ->values();

        return view('admin.moderasi.index', compact(
            'items',
            'counts',
            'activeTab',
            'search',
            'initials'
        ));
    }

    public function approve($id)
    {
        // Jika sudah pakai Eloquent Model Barang:
        // $barang = Barang::findOrFail($id);
        // $barang->update(['status' => 'Aktif']);

        return redirect()
            ->route('admin.moderasi.index')
            ->with('success', "Barang #{$id} berhasil disetujui.");
    }

    public function reject($id)
    {
        // Jika sudah pakai Eloquent Model Barang:
        // $barang = Barang::findOrFail($id);
        // $barang->update(['status' => 'Ditolak']);

        return redirect()
            ->route('admin.moderasi.index')
            ->with('success', "Barang #{$id} ditolak.");
    }
}