<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPenggunaController extends Controller
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

        // Data mahasiswa sesuai tampilan pada gambar
        $allUsers = collect([
            [
                'id' => 1,
                'nama' => 'Mutmainnah Talib',
                'nim' => 'D0223008',
                'prodi' => 'Informatika',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'nama' => 'Andi Alviansyah S',
                'nim' => 'D0223007',
                'prodi' => 'Informatika',
                'status' => 'Aktif',
            ],
            [
                'id' => 3,
                'nama' => 'Muhammad Faisal',
                'nim' => 'D0223003',
                'prodi' => 'Informatika',
                'status' => 'Aktif',
            ],
            [
                'id' => 4,
                'nama' => 'Zaskia',
                'nim' => 'D0223311',
                'prodi' => 'Informatika',
                'status' => 'Nonaktif',
            ],
        ]);

        $search = trim((string) $request->get('search', ''));

        $users = $allUsers
            ->when($search !== '', function ($collection) use ($search) {
                $lower = mb_strtolower($search);
                return $collection->filter(function ($row) use ($lower) {
                    return str_contains(mb_strtolower($row['nama']), $lower)
                        || str_contains(mb_strtolower($row['nim']), $lower)
                        || str_contains(mb_strtolower($row['prodi']), $lower);
                });
            })
            ->values();

        return view('admin.pengguna.index', compact('users', 'search', 'initials'));
    }

    public function toggleStatus($id)
    {
        // Jika sudah terhubung ke model User:
        // $mahasiswa = User::findOrFail($id);
        // $mahasiswa->update(['is_active' => !$mahasiswa->is_active]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('success', "Status pengguna #{$id} berhasil diperbarui.");
    }
}