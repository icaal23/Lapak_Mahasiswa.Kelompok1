<?php

namespace App\Http\Controllers;

use App\Models\ChatWa;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatWaController extends Controller
{
    // Menampilkan halaman Chat WA (Kosong jika belum ada yang chat)
  public function index()
{
    $chats = ChatWa::with(['pembeli', 'barang'])
        ->where('penjual_id', Auth::id())
        ->latest()
        ->get();

    // TAMBAHKAN BARIS INI UNTUK MENGECEK APAKAH DATA ADA
    // dd($chats, Auth::id());

    return view('chat.index', compact('chats'));
}

    // Dipanggil saat pembeli klik tombol "Chat Penjual" di halaman barang
    public function mulaiChat(Request $request, $barang_id)
    {
        $barang = Barang::with('user')->findOrFail($barang_id);
        $pesan = $request->input('pesan', 'Halo, apakah barang "' . $barang->nama_barang . '" masih ada kak?');

        // Simpan atau perbarui riwayat chat agar muncul di menu Chat Wa penjual
        ChatWa::updateOrCreate(
            [
                'penjual_id' => $barang->user_id,
                'pembeli_id' => Auth::id(),
                'barang_id'  => $barang->id,
            ],
            [
                'pesan' => $pesan,
            ]
        );

        // Format nomor HP penjual ke format internasional (62...)
        $no_wa = preg_replace('/^0/', '62', $barang->user->no_hp ?? '628123456789');
        $url_wa = "https://wa.me/{$no_wa}?text=" . urlencode($pesan);

        return redirect()->away($url_wa);
    }
}