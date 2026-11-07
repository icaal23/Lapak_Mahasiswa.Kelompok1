<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Lapak Kampus</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-page font-sans antialiased">
<div class="grid min-h-screen lg:grid-cols-2">

    {{-- PANEL KIRI --}}
    <aside class="hidden flex-col justify-between bg-navy p-8 text-white lg:flex">
        <a href="{{ route('beranda') }}" class="flex items-center gap-2">
            <img src="{{ asset('assets/image/logo_lapak.png') }}" alt="Lapak Kampus" class="h-12">
            <span class="text-3xl font-bold">Lapak Kampus</span>
        </a>

        <p class="max-w-lg text-3xl font-bold leading-snug">
            "Daftar sekali pakai email kampus, langsung bisa jualan dan cari barang di lapak."
        </p>

        <div class="flex gap-3">
            @foreach (['Verifikasi NIM', 'Khusus 1 Kampus', 'Gratis'] as $badge)
                <span class="rounded-full border border-white/30 bg-white/10 px-5 py-2 text-sm font-bold">{{ $badge }}</span>
            @endforeach
        </div>
    </aside>

    {{-- PANEL KANAN --}}
    <main class="flex items-center justify-center px-6 py-10 lg:px-12">
        <div class="w-full max-w-[620px]">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1 font-semibold text-neutral-500 hover:text-black">
                <x-icon name="chevron" class="size-4 rotate-90" /> Kembali
            </a>

            <h1 class="mt-4 text-3xl font-bold">Buat akun mahasiswa</h1>
            <p class="mt-4 max-w-md text-neutral-500">Data ini dipakai admin untuk verifikasi keanggotaan kampus.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                {{-- Nama --}}
                <div>
                    <label for="name" class="block font-semibold text-neutral-500">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                           placeholder="Nama Sesuai KTM"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 bg-white px-6 py-4 focus:border-brand focus:ring-brand">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- NIM + Prodi --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="nim" class="block font-semibold text-neutral-500">NIM</label>
                        <input id="nim" name="nim" type="text" value="{{ old('nim') }}" required
                               placeholder="D0223XXX"
                               class="mt-3 w-full rounded-2xl border border-neutral-400 bg-white px-6 py-4 focus:border-brand focus:ring-brand">
                        @error('nim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="program_studi" class="block font-semibold text-neutral-500">Program Studi</label>
                        <input id="program_studi" name="program_studi" type="text" value="{{ old('program_studi') }}" required
                               placeholder="Informatika"
                               class="mt-3 w-full rounded-2xl border border-neutral-400 bg-white px-6 py-4 focus:border-brand focus:ring-brand">
                        @error('program_studi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block font-semibold text-neutral-500">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                           placeholder="namamahasiswa@gmail.com"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 bg-white px-6 py-4 focus:border-brand focus:ring-brand">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Sandi --}}
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="password" class="block font-semibold text-neutral-500">Kata Sandi</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               placeholder="Minimal 8 Karakter"
                               class="mt-3 w-full rounded-2xl border border-neutral-400 bg-white px-6 py-4 focus:border-brand focus:ring-brand">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block font-semibold text-neutral-500">Konfirmasi Sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               placeholder="Ulangi Kata Sandi"
                               class="mt-3 w-full rounded-2xl border border-neutral-400 bg-white px-6 py-4 focus:border-brand focus:ring-brand">
                    </div>
                </div>

                {{-- Persetujuan --}}
                <div>
                    <label class="flex items-start gap-3 text-neutral-500">
                        <input type="checkbox" name="setuju" value="1" @checked(old('setuju')) required
                               class="mt-1 size-5 rounded border-neutral-500 text-brand focus:ring-brand">
                        <span>Saya setuju barang yang saya unggah adalah barang bekas milik saya sendiri dan mengikuti ketentuan Lapak Kampus.</span>
                    </label>
                    @error('setuju') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full rounded-full bg-brand py-4 font-bold text-white transition hover:opacity-90">
                    Daftar
                </button>

                <p class="text-center text-neutral-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-red-600 hover:underline">Masuk di sini</a>
                </p>
            </form>
        </div>
    </main>
</div>
</body>
</html>