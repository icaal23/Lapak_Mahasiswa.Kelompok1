@extends('layouts.mahasiswa')

@section('title', 'Profil - Lapak Kampus')

@section('content')
    @php
        $user = Auth::user() ?? (object) [
            'name' => 'Mahasiswa',
            'nim' => '',
            'program_studi' => '',
            'email' => '',
            'no_whatsapp' => '',
            'lokasi_ambil' => '',
        ];

        $namaUser = $user->name ?: 'Mahasiswa';
        $inisial = collect(explode(' ', trim($namaUser)))
            ->filter()
            ->map(fn ($n) => strtoupper(mb_substr($n, 0, 1)))
            ->take(2)
            ->implode('') ?: 'MT';
    @endphp

    <h1 class="text-4xl font-extrabold">Profil saya</h1>
    <p class="mt-3 text-lg">Informasi ini terlihat oleh mahasiswa lain saat kamu berjualan.</p>

    @if (session('sukses'))
        <div class="mt-6 rounded-xl border border-green-300 bg-green-100 px-5 py-3 font-semibold text-green-800">
            {{ session('sukses') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}"
          class="mt-6 rounded-[40px] border border-neutral-400 bg-white p-8 lg:p-12">
        @csrf
        @method('PATCH')

        {{-- Avatar + nama --}}
        <div class="flex items-center gap-6">
            <span class="flex size-20 items-center justify-center rounded-full bg-c-buku text-3xl font-bold">{{ $inisial }}</span>
            <span class="text-3xl font-bold">{{ $namaUser }}</span>
        </div>

        <div class="mt-8 grid gap-x-10 gap-y-8 lg:grid-cols-2">
            <div>
                <label for="name" class="block text-xl font-semibold text-neutral-500">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" required
                       class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="nim" class="block text-xl font-semibold text-neutral-500">Nim</label>
                <input id="nim" type="text" value="{{ $user->nim ?? '' }}" readonly
                       class="mt-3 w-full cursor-not-allowed rounded-2xl border border-neutral-300 bg-neutral-100 px-5 py-4 text-lg text-neutral-500">
            </div>

            <div>
                <label for="program_studi" class="block text-xl font-semibold text-neutral-500">Program Studi</label>
                <input id="program_studi" name="program_studi" type="text" value="{{ old('program_studi', $user->program_studi ?? '') }}" required
                       class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                @error('program_studi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xl font-semibold text-neutral-500">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" required
                       class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="no_whatsapp" class="block text-xl font-semibold text-neutral-500">Nomor WhatsApp</label>
                <input id="no_whatsapp" name="no_whatsapp" type="text" inputmode="tel"
                       value="{{ old('no_whatsapp', $user->no_whatsapp ?? '') }}" placeholder="08xxxxxxxxxx"
                       class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                @error('no_whatsapp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="lokasi_ambil" class="block text-xl font-semibold text-neutral-500">Lokasi biasa ambil barang</label>
                <input id="lokasi_ambil" name="lokasi_ambil" type="text"
                       value="{{ old('lokasi_ambil', $user->lokasi_ambil ?? '') }}" placeholder="Contoh: Perpus"
                       class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                @error('lokasi_ambil') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <button type="submit" class="mt-10 rounded-full bg-brand px-8 py-4 text-xl font-bold text-white hover:opacity-90">
            Simpan
        </button>
    </form>
@endsection