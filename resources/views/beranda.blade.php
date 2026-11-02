@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-[1440px] px-6 lg:px-[69px]">

    {{-- HERO --}}
    <section class="grid items-start gap-10 pt-12 lg:grid-cols-2">
        <div>
            <h1 class="text-5xl font-extrabold leading-tight tracking-tight">
                Barangmu Masih Berguna.<br>Jangan Biarkan Terlupakan.
            </h1>
            <p class="mt-5 max-w-xl text-2xl leading-snug text-neutral-500">
                Titip barang bekas yang masih layak pakai ke papan Lapak Kampus, atau temukan barang yang kamu cari langsung dari mahasiswa lain — tanpa ongkir, tanpa ribet.
            </p>

            {{-- Search --}}
            <form action="#" method="GET"
                  class="mt-8 flex max-w-[675px] items-center rounded-full border-neutral-500 bg-white/40 py-2 pl-5 pr-3">
                <x-icon name="cari" class="size-7 text-neutral-800" />
                <input type="text" name="q" placeholder="Search"
                       class="min-w-0 flex-1 bg-transparent px-4 py-2 text-xl outline-none placeholder:text-neutral-500">
                <div class="relative flex items-center border-l border-neutral-400 pl-4 pr-2">
                    <select name="kategori" class="appearance-none bg-transparent pr-6 text-xl text-neutral-500 outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $k)
                            <option>{{ $k['nama'] }}</option>
                        @endforeach
                    </select>
                    <x-icon name="chevron" class="pointer-events-none absolute right-3 size-4 text-neutral-500" />
                </div>
                <button class="rounded-full bg-brand px-6 py-2 text-xl font-bold text-white">Cari</button>
            </form>

            {{-- Statistik --}}
            <div class="mt-12 flex gap-12">
                @foreach ($statistik as $s)
                    <div>
                        <div class="text-3xl font-semibold">{{ $s['angka'] }}</div>
                        <div class="mt-1 text-xl text-neutral-500">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kartu produk melayang --}}
        <div class="relative hidden h-[450px] lg:block">
            @php
                $hero = [
                    ['nama' => 'Almamater Unsulbar', 'harga' => 'Rp95.000',    'gambar' => 'almet.png',      'bg' => 'bg-c-pakaian',     'border' => 'border-c-pakaian',     'pos' => 'left-[30px] top-[0px] -rotate-6'],
                    ['nama' => 'Buku Algoritma',     'harga' => 'Rp60.000',    'gambar' => 'buku_algoritma.png', 'bg' => 'bg-c-buku',        'border' => 'border-c-buku',        'pos' => 'left-[250px] top-[40px] rotate-6'],
                    ['nama' => 'Tas Ransel Laptop',  'harga' => 'Rp60.000',    'gambar' => 'tasransel.png',     'bg' => 'bg-c-kuliah',      'border' => 'border-c-kuliah',      'pos' => 'left-[10px] top-[190px] -rotate-[15deg]'],
                    ['nama' => 'Laptop Lenovo',      'harga' => 'Rp3.500.000', 'gambar' => 'laptop.png',  'bg' => 'bg-c-elektronik',  'border' => 'border-c-elektronik',  'pos' => 'left-[270px] top-[260px]'],
                ];
            @endphp

            @foreach ($hero as $h)
                <div class="absolute w-[230px] rounded-2xl border-t-[10px] {{ $h['border'] }} bg-white p-3 shadow-lg {{ $h['pos'] }}">
                    <div class="{{ $h['bg'] }} flex h-[100px] items-center justify-center rounded-xl shadow-inner">
                        <img src="{{ asset('assets/image/produk/' . $h['gambar']) }}"
                            alt="{{ $h['nama'] }}"
                            class="h-[90px] object-contain drop-shadow-md">
                    </div>
                    <p class="mt-2 font-bold leading-tight text-neutral-800">
                        {{ $h['nama'] }}<br>{{ $h['harga'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- KATEGORI --}}
    <section id="kategori" class="mt-16 px-2">
        <h2 class="text-4xl font-bold">Kategori</h2>
        <div class="mt-8 flex flex-wrap gap-[33px]">
            @foreach ($kategori as $k)
                <a href="#" class="flex h-[180px] w-[170px] flex-col justify-between rounded-2xl border border-neutral-500 bg-white p-4 transition hover:shadow-md">
                    <span class="bg-{{ $k['warna'] }} flex size-11 items-center justify-center rounded-lg text-white/80">
                        <x-icon name="{{ $k['ikon'] }}" />
                    </span>
                    <div>
                        <div class="text-xl font-bold leading-tight">{{ $k['nama'] }}</div>
                        <div class="mt-1 text-sm text-neutral-500">{{ $k['jumlah'] }} Barang</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- BARANG TERBARU --}}
    <section class="mt-16 px-2">
        <div class="flex items-center justify-between">
            <h2 class="text-4xl font-bold">Barang terbaru dipublikasikan</h2>
            <a href="#" class="text-xl font-semibold text-neutral-500 hover:text-black">Lihat semua barang</a>
        </div>

        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($barang as $b)
                <article class="overflow-hidden rounded-sm border border-neutral-300 bg-white">
                    <div class="bg-{{ $b['warna'] }} relative flex h-[90px] items-center justify-center text-white">
                        <x-icon name="{{ $b['ikon'] }}" class="size-10" />
                        <span class="absolute right-3 top-3 flex size-4 items-center justify-center rounded-full bg-white text-red-600">
                            <x-icon name="hati" class="size-2.5" />
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="text-sm text-neutral-500">{{ $b['kategori'] }}</div>
                        <div class="font-semibold">{{ $b['nama'] }}</div>
                        <div class="mt-1 flex items-center justify-between">
                            <span class="text-lg font-bold">Rp.{{ number_format($b['harga'], 0, ',', '.') }}</span>
                            <span class="rounded-full bg-neutral-300 px-2 py-0.5 text-[10px] font-bold text-neutral-600">{{ $b['kondisi'] }}</span>
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-[11px] text-neutral-500">
                            <span class="bg-{{ $b['warna'] }} flex size-5 items-center justify-center rounded-full text-[8px] font-bold text-black">
                                {{ collect(explode(' ', $b['penjual']))->map(fn ($n) => strtoupper($n[0]))->take(2)->implode('') }}
                            </span>
                            {{ $b['penjual'] }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- CARA KERJA --}}
    <section id="cara-kerja" class="mt-16 px-2">
        <h2 class="text-4xl font-bold">Cara Kerjanya</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($langkah as $l)
                <div class="rounded-2xl border border-neutral-500 bg-white p-8">
                    <div class="text-sm text-neutral-500">{{ $l['no'] }}</div>
                    <h3 class="mt-3 font-bold">{{ $l['judul'] }}</h3>
                    <p class="mt-3 text-sm text-neutral-500">{{ $l['isi'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-2 mt-14 flex flex-col items-start justify-between gap-6 rounded-3xl bg-navy px-12 py-10 text-white md:flex-row md:items-center">
        <div>
            <h2 class="max-w-md text-3xl font-bold leading-tight">Punya barang yang sudah tidak dipakai?</h2>
            <p class="mt-2 max-w-md text-sm">Foto, unggah, dan tawarkan ke ribuan mahasiswa satu kampus hari ini juga.</p>
        </div>
        <a href="#" class="rounded-full bg-brand px-10 py-5 text-sm font-bold text-white">Daftar dan Mulai Jualan</a>
    </section>
</div>
@endsection