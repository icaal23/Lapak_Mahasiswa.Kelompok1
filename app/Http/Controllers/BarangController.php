<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    private const KATEGORI = ['Buku', 'Elektronik', 'Pakaian', 'Perlengkapan Kuliah', 'Lainnya'];
    private const KONDISI = ['Bekas-Baik', 'Bekas-Cukup', 'Baru'];

    public function create()
    {
        return view('barang.create', [
            'kategoriList' => self::KATEGORI,
            'kondisiList' => self::KONDISI,
        ]);
    }

    public function store(Request $request)
    {
        // "Rp.60.000" -> "60000"
        $request->merge(['harga' => preg_replace('/\D/', '', (string) $request->harga)]);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(self::KATEGORI)],
            'harga' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', Rule::in(self::KONDISI)],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'lokasi' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'array', 'max:5'],
            'foto.*' => ['image', 'max:2048'],
            'aksi' => ['required', Rule::in(['draft', 'publikasi'])],
        ], [
            'foto.max' => 'Maksimal 5 foto.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.max' => 'Ukuran tiap foto maksimal 2 MB.',
        ]);

        $paths = [];
        foreach ($request->file('foto', []) as $file) {
            $paths[] = $file->store('barang', 'public');
        }

        Barang::create([
            'user_id' => $request->user()->id,
            'nama' => $data['nama'],
            'kategori' => $data['kategori'],
            'harga' => $data['harga'],
            'kondisi' => $data['kondisi'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'lokasi' => $data['lokasi'],
            'foto' => $paths,
            'status' => $data['aksi'] === 'publikasi' ? 'menunggu_moderasi' : 'draft',
        ]);

        $pesan = $data['aksi'] === 'publikasi'
            ? 'Barang dikirim dan menunggu moderasi admin.'
            : 'Barang disimpan sebagai draft.';

        return redirect()->route('barang.index')->with('sukses', $pesan);
    }

    public function index(Request $request)
    {
        $semua = Barang::where('user_id', $request->user()->id)->latest()->get();

        $status = $request->query('status', 'semua');
        if (! in_array($status, ['semua', 'aktif', 'menunggu_moderasi', 'terjual'])) {
            $status = 'semua';
        }

        $hitung = [
            'semua' => $semua->count(),
            'aktif' => $semua->where('status', 'aktif')->count(),
            'menunggu_moderasi' => $semua->where('status', 'menunggu_moderasi')->count(),
            'terjual' => $semua->where('status', 'terjual')->count(),
        ];

        $barang = $status === 'semua' ? $semua : $semua->where('status', $status);

        return view('barang.index', compact('barang', 'hitung', 'status'));
    }

    public function edit(Barang $barang)
    {
        abort_unless($barang->user_id === auth()->id(), 403);

        return view('barang.edit', [
            'barang' => $barang,
            'kategoriList' => self::KATEGORI,
            'kondisiList' => self::KONDISI,
        ]);
    }

    public function update(Request $request, Barang $barang)
    {
        abort_unless($barang->user_id === auth()->id(), 403);

        $request->merge(['harga' => preg_replace('/\D/', '', (string) $request->harga)]);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in(self::KATEGORI)],
            'harga' => ['required', 'integer', 'min:0'],
            'kondisi' => ['required', Rule::in(self::KONDISI)],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'lokasi' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'array', 'max:5'],
            'foto.*' => ['image', 'max:2048'],
        ]);

        // Kalau ada foto baru, foto lama diganti
        if ($request->hasFile('foto')) {
            foreach ($barang->foto ?? [] as $lama) {
                Storage::disk('public')->delete($lama);
            }
            $data['foto'] = collect($request->file('foto'))
                ->map(fn ($f) => $f->store('barang', 'public'))
                ->all();
        } else {
            unset($data['foto']);
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('sukses', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        abort_unless($barang->user_id === auth()->id(), 403);

        foreach ($barang->foto ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }
        $barang->delete();

        return redirect()->route('barang.index')->with('sukses', 'Barang dihapus.');
    }
}