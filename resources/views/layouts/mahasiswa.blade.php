<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lapak Kampus')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-page font-sans antialiased">
@php
    $menu = [
        ['Beranda',            'home',      route('dashboard'),     request()->routeIs('dashboard')],
        ['Tambah Barang', 'tambah', route('barang.create'), request()->routeIs('barang.create')],
        ['Barang Saya', 'tag', route('barang.index'), request()->routeIs('barang.index', 'barang.edit')],
        ['Laporan Pendapatan', 'chart',     '#',                    false],
        ['Chat Wa',            'chat',      '#',                    false],
        ['Keranjang',          'keranjang', '#',                    false],
        ['Profil',             'user',      route('profile.edit'),  request()->routeIs('profile.*')],
    ];
    $inisial = collect(explode(' ', Auth::user()->name))->map(fn ($n) => strtoupper(mb_substr($n, 0, 1)))->take(2)->implode('');
@endphp

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="hidden w-[270px] shrink-0 flex-col border-r border-neutral-400 bg-white lg:flex">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-6 py-6">
            <img src="{{ asset('assets/image/logo_lapak.png') }}" alt="" class="h-12">
            <span class="text-2xl font-bold">Lapak Kampus</span>
        </a>

        <nav class="mt-4 flex-1 space-y-2 px-3">
            @foreach ($menu as [$label, $ikon, $url, $aktif])
                <a href="{{ $url }}"
                   class="flex items-center gap-4 rounded-xl px-4 py-3 text-xl font-semibold transition
                          {{ $aktif ? 'bg-brand/25 text-amber-900' : 'text-neutral-500 hover:bg-neutral-100' }}">
                    <x-icon name="{{ $ikon }}" class="size-7" />
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mx-8 border-t border-neutral-300 py-6">
            @csrf
            <button type="submit" class="pl-[72px] text-xl font-semibold text-neutral-500 hover:text-black">Keluar</button>
        </form>
    </aside>

    {{-- KONTEN --}}
    <div class="flex min-w-0 flex-1 flex-col">
        <header class="flex items-center justify-between gap-4 border-b border-neutral-400 px-6 py-5 lg:px-11">
            <form action="{{ route('dashboard') }}" method="GET"
                  class="flex w-full max-w-[760px] items-center gap-4 rounded-2xl border border-neutral-400 bg-white px-5 py-3">
                <x-icon name="cari" class="size-7 text-neutral-500" />
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari barang di kampusmu..."
                       class="min-w-0 flex-1 border-0 bg-transparent p-0 text-xl placeholder:text-neutral-500 focus:ring-0">
                <span class="hidden text-neutral-400 sm:block">⌘K</span>
            </form>

            <div class="flex items-center gap-5">
                <button type="button" class="relative text-neutral-600" aria-label="Notifikasi">
                    <x-icon name="bell" class="size-7" />
                    <span class="absolute right-0 top-0 size-2 rounded-full bg-red-500"></span>
                </button>
                <a href="{{ route('profile.edit') }}"
                   class="flex size-14 items-center justify-center rounded-full bg-c-buku text-xl font-bold">{{ $inisial }}</a>
            </div>
        </header>

        <main class="px-6 py-8 lg:px-11">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>