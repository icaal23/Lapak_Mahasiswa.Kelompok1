<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBarangController extends Controller
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

        // Data barang sesuai tampilan pada gambar
        $allItems = collect([
            [
                'id' => 1,
                'barang' => 'Jaket Almamater Prodi',
                'penjual' => 'Mutmsinnah Talib',
                'kategori' => 'Pakaian',
                'kategori_style' => 'bg-[#F9D8D6] text-[#9B2C2C]',
                'harga' => 'Rp120.000',
                'status' => 'Aktif',
                'status_style' => 'bg-[#16A34A] text-white',
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
                'harga' => 'Rp3500000',
                'status' => 'Terjual',
                'status_style' => 'bg-[#6B7280] text-white',
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
                'harga' => 'Rp55.000',
                'status' => 'Ditolak',
                'status_style' => 'bg-[#991B1B] text-white',
                'icon_type' => 'grid',
                'thumb_bg' => 'bg-[#86EFAC]',
                'foto' => null,
            ],
            [
                'id' => 4,
                'barang' => 'Setrika Portable',
                'penjual' => 'Mutmainnah Thalib',
                'kategori' => 'Elektronik',
                'kategori_style' => 'bg-[#DBEAFE] text-[#1D4ED8]',
                'harga' => 'Rp90.000',
                'status' => 'Menunggu Moderasi',
                'status_style' => 'bg-[#7C2D12] text-white leading-tight text-center',
                'icon_type' => 'chip',
                'thumb_bg' => 'bg-[#60A5FA]',
                'foto' => null,
            ],
        ]);

        // Hitung jumlah tiap tab status
        $counts = [
            'Semua' => $allItems->count(),
            'Aktif' => $allItems->where('status', 'Aktif')->count(),
            'Terjual' => $allItems->where('status', 'Terjual')->count(),
            'Menunggu Moderasi' => $allItems->where('status', 'Menunggu Moderasi')->count(),
            'Ditolak' => $allItems->where('status', 'Ditolak')->count(),
        ];

        $activeStatus = $request->get('status', 'Semua');
        $search = trim((string) $request->get('search', ''));

        $items = $allItems
            ->when($activeStatus !== 'Semua', function ($collection) use ($activeStatus) {
                return $collection->where('status', $activeStatus);
            })
            ->when($search !== '', function ($collection) use ($search) {
                $lower = mb_strtolower($search);
                return $collection->filter(function ($item) use ($lower) {
                    return str_contains(mb_strtolower($item['barang']), $lower)
                        || str_contains(mb_strtolower($item['penjual']), $lower);
                });
            })
            ->values();

        return view('admin.barang.index', compact(
            'items',
            'counts',
            'activeStatus',
            'search',
            'initials'
        ));
    }

    public function edit($id)
    {
        return "Form Edit Barang Admin ID: {$id}";
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}