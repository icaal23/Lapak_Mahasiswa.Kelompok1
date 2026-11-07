@extends('layouts.mahasiswa')

@section('title', 'Barang Saya - Lapak Kampus')

@section('content')
    @php
        $tab = [
            'semua' => 'Semua',
            'aktif' => 'Aktif',
            'menunggu_moderasi' => 'Menunggu Moderasi',
            'terjual' => 'Terjual',
        ];
        $warnaStatus = [
            'draft' => ['Draft', 'bg-neutral-300 text-neutral-700'],
            'menunggu_moderasi' => ['Menunggu Moderasi', 'bg-red-200 text-red-900'],
            'aktif' => ['Aktif', 'bg-green-200 text-green-900'],
            'terjual' => ['Terjual', 'bg-neutral-400 text-neutral-800'],
        ];
        $warnaKategori = [
            'Buku' => 'bg-c-buku',
            'Elektronik' => 'bg-c-elektronik',
            'Pakaian' => 'bg-c-pakaian',
            'Perlengkapan Kuliah' => 'bg-c-kuliah',
            'Lainnya' => 'bg-c-lain',
        ];
    @endphp

    <h1 class="text-4xl font-extrabold">Barang saya</h1>
    <p class="mt-3 text-lg">Kelola barang yang sudah kamu publikasikan.</p>

    @if (session('sukses'))
        <div class="mt-6 rounded-xl border border-green-300 bg-green-100 px-5 py-3 font-semibold text-green-800">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Tab status --}}
    <div class="mt-6 flex flex-wrap gap-4">
        @foreach ($tab as $key => $label)
            <a href="{{ route('barang.index', $key === 'semua' ? [] : ['status' => $key]) }}"
               class="rounded-full border px-5 py-2 text-xl font-semibold transition
                      {{ $status === $key ? 'border-brand bg-brand text-white' : 'border-neutral-400 bg-white text-neutral-500 hover:border-neutral-600' }}">
                {{ $label }} ({{ $hitung[$key] }})
            </a>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="mt-8 overflow-x-auto">
        <table class="w-full min-w-[760px] text-left">
            <thead>
                <tr class="text-neutral-500">
                    <th class="pb-5 font-semibold">Barang</th>
                    <th class="pb-5 font-semibold">Kategori</th>
                    <th class="pb-5 font-semibold">Harga</th>
                    <th class="pb-5 font-semibold">Status</th>
                    <th class="pb-5 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang as $b)
                    @php [$labelStatus, $kelasStatus] = $warnaStatus[$b->status] ?? [$b->status, 'bg-neutral-300']; @endphp
                    <tr class="border-t border-neutral-400">
                        <td class="py-5 pr-4 text-lg">{{ $b->nama }}</td>
                        <td class="py-5 pr-4">
                            <span class="{{ $warnaKategori[$b->kategori] ?? 'bg-c-lain' }} inline-block rounded-full px-3 py-1 text-lg">
                                {{ $b->kategori }}
                            </span>
                        </td>
                        <td class="py-5 pr-4 text-lg">Rp.{{ number_format($b->harga, 0, ',', '.') }}</td>
                        <td class="py-5 pr-4">
                            <span class="{{ $kelasStatus }} inline-block rounded-full px-3 py-1 text-lg">{{ $labelStatus }}</span>
                        </td>
                        <td class="py-5">
                            <div class="flex gap-2">
                                <a href="{{ route('barang.edit', $b) }}" aria-label="Ubah"
                                   class="flex h-9 w-14 items-center justify-center rounded-full border border-neutral-500 text-navy hover:bg-white">
                                    <x-icon name="pensil" class="size-4" />
                                </a>
                                <form method="POST" action="{{ route('barang.destroy', $b) }}"
                                      onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Hapus"
                                            class="flex h-9 w-14 items-center justify-center rounded-full border border-neutral-500 text-navy hover:bg-white">
                                        <x-icon name="sampah" class="size-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-neutral-400">
                        <td colspan="5" class="py-10 text-center text-neutral-500">Belum ada barang di tab ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="border-t border-neutral-400"></div>
    </div>

    <div class="mt-8 flex justify-end">
        <a href="{{ route('barang.create') }}"
           class="inline-flex items-center gap-2 rounded-full bg-brand px-6 py-4 text-xl font-bold text-white hover:opacity-90">
            <x-icon name="tambah" class="size-6" /> Tambah barang
        </a>
    </div>
@endsection