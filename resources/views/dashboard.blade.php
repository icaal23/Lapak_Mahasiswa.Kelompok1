@extends('layouts.mahasiswa')

@section('title', 'Beranda - Lapak Kampus')

@section('content')
    <h1 class="text-4xl font-extrabold">Halo, {{ Auth::user()->name }}</h1>
    <p class="mt-3 text-lg">Ini barang-barang terbaru di lapak kampusmu hari ini.</p>

    {{-- Filter kategori --}}
    <div class="mt-6 flex flex-wrap gap-4">
        @foreach ($kategoriList as $k)
            <a href="{{ route('dashboard', array_filter(['kategori' => $k === 'Semua' ? null : $k, 'q' => $q])) }}"
               class="rounded-full border px-5 py-2 text-xl font-semibold transition
                      {{ $aktif === $k ? 'border-brand bg-brand text-white' : 'border-neutral-400 bg-white text-neutral-500 hover:border-neutral-600' }}">
                {{ $k }}
            </a>
        @endforeach
    </div>

    {{-- Grid barang --}}
    <div class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        @forelse ($barang as $b)
            <article class="overflow-hidden rounded-lg border border-neutral-300 bg-white">
                <div class="{{ $b['warna'] }} relative flex h-[90px] items-center justify-center text-white">
                    <x-icon name="{{ $b['ikon'] }}" class="size-10" />
                    <span class="absolute right-3 top-3 flex size-4 items-center justify-center rounded-full bg-white text-red-600">
                        <x-icon name="hati" class="size-2.5" />
                    </span>
                </div>
                <div class="p-4">
                    <div class="text-sm text-neutral-500">{{ $b['kategori'] }}</div>
                    <div class="font-semibold">{{ $b['nama'] }}</div>
                    <div class="mt-1 flex items-center justify-between gap-2">
                        <span class="font-bold">Rp.{{ number_format($b['harga'], 0, ',', '.') }}</span>
                        <span class="rounded-full bg-neutral-300 px-2 py-0.5 text-[10px] font-bold text-neutral-600">{{ $b['kondisi'] }}</span>
                    </div>
                    <div class="mt-2 flex items-center gap-2 text-[11px] text-neutral-500">
                        <span class="{{ $b['warna'] }} flex size-5 items-center justify-center rounded-full text-[8px] font-bold text-black">
                            {{ collect(explode(' ', $b['penjual']))->map(fn ($n) => strtoupper($n[0]))->take(2)->implode('') }}
                        </span>
                        {{ $b['penjual'] }}
                    </div>
                </div>
            </article>
        @empty
            <p class="col-span-full text-neutral-500">Belum ada barang yang cocok.</p>
        @endforelse
    </div>
@endsection