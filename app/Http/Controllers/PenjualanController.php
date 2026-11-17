<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

/**
 * Menandai barang sebagai terjual dan mencatat data penjualannya
 * (nama pembeli, harga jual, tanggal) untuk Laporan Pendapatan.
 */
class PenjualanController extends Controller
{
    public function create(Barang $barang)
    {
        $this->pastikanBisaDitandaiTerjual($barang);

        return view('barang.terjual', compact('barang'));
    }

    public function store(Request $request, Barang $barang)
    {
        $this->pastikanBisaDitandaiTerjual($barang);

        // "Rp.60.000" -> "60000"
        $request->merge(['harga_jual' => preg_replace('/\D/', '', (string) $request->harga_jual)]);

        $data = $request->validate([
            'nama_pembeli' => ['required', 'string', 'max:255'],
            'harga_jual' => ['required', 'integer', 'min:0'],
            // 'tomorrow' sebagai toleransi selisih zona waktu (server UTC vs WITA)
            'terjual_pada' => ['required', 'date', 'before_or_equal:tomorrow'],
        ], [
            'nama_pembeli.required' => 'Nama pembeli wajib diisi.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.integer' => 'Harga jual harus berupa angka.',
            'terjual_pada.required' => 'Tanggal terjual wajib diisi.',
            'terjual_pada.date' => 'Tanggal terjual tidak valid.',
            'terjual_pada.before_or_equal' => 'Tanggal terjual tidak boleh di masa depan.',
        ]);

        $barang->update($data + ['status' => 'terjual']);

        return redirect()->route('laporan.index')
            ->with('sukses', 'Barang ditandai terjual dan masuk ke laporan pendapatan.');
    }

    private function pastikanBisaDitandaiTerjual(Barang $barang): void
    {
        abort_unless($barang->user_id === auth()->id(), 403);
        abort_unless($barang->status === 'aktif', 403, 'Hanya barang berstatus aktif yang bisa ditandai terjual.');
    }
}
