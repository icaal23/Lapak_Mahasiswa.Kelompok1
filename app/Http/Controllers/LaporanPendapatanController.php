<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class LaporanPendapatanController extends Controller
{
    private const NAMA_BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $sekarang = now();

        // Riwayat penjualan milik user ini, terbaru di atas
        $riwayat = Barang::where('user_id', $userId)
            ->terjual()
            ->get()
            ->sortByDesc(fn (Barang $b) => $b->tanggal_terjual->timestamp)
            ->values();

        // --- Kartu ringkasan ---
        $jumlahTerjual = $riwayat->count();
        $totalPendapatan = $riwayat->sum(fn (Barang $b) => $b->pendapatan);
        $rataRata = $jumlahTerjual > 0 ? (int) round($totalPendapatan / $jumlahTerjual) : 0;

        $terjualBulanIni = $riwayat
            ->filter(fn (Barang $b) => $b->tanggal_terjual->format('Y-m') === $sekarang->format('Y-m'))
            ->count();

        $barangAktif = Barang::where('user_id', $userId)->aktif()->count();

        // --- Pendapatan per bulan (3 bulan terakhir, yang terlama di atas) ---
        $perBulan = collect([2, 1, 0])->map(function (int $mundur) use ($riwayat, $sekarang) {
            $bulan = $sekarang->copy()->startOfMonth()->subMonths($mundur);

            $jumlah = $riwayat
                ->filter(fn (Barang $b) => $b->tanggal_terjual->format('Y-m') === $bulan->format('Y-m'))
                ->sum(fn (Barang $b) => $b->pendapatan);

            return ['label' => self::NAMA_BULAN[$bulan->month], 'jumlah' => $jumlah];
        });

        $maksBulan = max(1, $perBulan->max('jumlah'));
        $perBulan = $perBulan->map(fn (array $m) => $m + [
            'persen' => (int) round($m['jumlah'] / $maksBulan * 100),
        ]);

        // --- Kategori barang terjual (dari seluruh riwayat) ---
        $perKategori = $riwayat
            ->groupBy('kategori')
            ->map(fn ($grup) => $grup->count())
            ->sortDesc();

        $maksKategori = max(1, (int) $perKategori->max());

        return view('laporan.index', compact(
            'riwayat',
            'jumlahTerjual',
            'totalPendapatan',
            'rataRata',
            'terjualBulanIni',
            'barangAktif',
            'perBulan',
            'perKategori',
            'maksKategori',
        ));
    }
}
