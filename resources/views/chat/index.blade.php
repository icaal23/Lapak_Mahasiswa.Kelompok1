
@extends('layouts.mahasiswa')

@section('title', 'Chat WA - Lapak Kampus')

@section('content')

    {{-- JUDUL HALAMAN --}}
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-gray-900">
            Chat WA
        </h1>

        <p class="mt-2 text-sm text-gray-600">
            Kelola percakapan dengan pembeli melalui WhatsApp.
        </p>
    </div>

    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-100 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- DAFTAR CHAT --}}
    <div class="overflow-hidden rounded-2xl border border-neutral-300 bg-white shadow-sm">

        {{-- HEADER DAFTAR CHAT --}}
        <div class="flex flex-col gap-2 border-b border-neutral-200 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Daftar Percakapan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Percakapan dengan pembeli yang menghubungi penjual.
                </p>
            </div>

            <span class="w-fit rounded-full bg-brand/20 px-4 py-2 text-xs font-semibold text-amber-900">
                {{ $chats->count() }} Percakapan
            </span>
        </div>

        @forelse($chats as $chat)

            {{-- ITEM CHAT --}}
            <div class="flex flex-col gap-4 border-b border-neutral-200 p-5 transition hover:bg-neutral-50 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">

                {{-- INFORMASI PEMBELI --}}
                <div class="flex min-w-0 items-start gap-4">

                    {{-- FOTO / INISIAL PEMBELI --}}
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-orange-100 text-sm font-bold text-orange-800">
                        {{ strtoupper(substr($chat->pembeli->name ?? 'U', 0, 2)) }}
                    </div>

                    {{-- DETAIL CHAT --}}
                    <div class="min-w-0 flex-1">

                        <h3 class="break-words font-bold text-gray-900">
                            {{ $chat->pembeli->name ?? 'Pengguna' }}
                        </h3>

                        <p class="mt-1 break-words text-sm text-neutral-500">
                            Barang:
                            <span class="font-medium text-neutral-700">
                                {{ $chat->barang->nama_barang ?? 'Produk' }}
                            </span>
                        </p>

                        <p class="mt-2 break-words text-sm text-neutral-600">
                            {{ $chat->pesan ?? 'Belum ada pesan.' }}
                        </p>

                        @if($chat->created_at)
                            <p class="mt-2 text-xs text-neutral-400">
                                {{ $chat->created_at->format('d M Y, H:i') }}
                            </p>
                        @endif

                    </div>
                </div>

                {{-- TOMBOL WHATSAPP --}}
                @php
                    $nomor = preg_replace(
                        '/\D/',
                        '',
                        $chat->pembeli->no_hp ?? ''
                    );

                    if (str_starts_with($nomor, '0')) {
                        $nomor = '62' . substr($nomor, 1);
                    }
                @endphp

                <div class="shrink-0">

                    @if($nomor)

                        <a
                            href="https://wa.me/{{ $nomor }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex w-full items-center justify-center gap-2 rounded-full bg-green-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-600 sm:w-auto"
                        >
                            <span class="text-base">☏</span>
                            Chat WhatsApp
                        </a>

                    @else

                        <span class="block rounded-full bg-neutral-100 px-5 py-3 text-center text-xs font-medium text-neutral-400">
                            Nomor WA belum tersedia
                        </span>

                    @endif

                </div>

            </div>

        @empty

            {{-- JIKA BELUM ADA CHAT --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto mb-5 flex size-20 items-center justify-center rounded-full bg-green-50">
                    <span class="text-4xl">💬</span>
                </div>

                <h3 class="text-lg font-bold text-gray-800">
                    Belum Ada Percakapan
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-gray-500">
                    Percakapan dari pembeli akan muncul di sini
                    ketika mereka menghubungi penjual melalui
                    tombol Chat Penjual.
                </p>

            </div>

        @endforelse

    </div>

    {{-- BANNER TIPS TRANSAKSI --}}
    <div class="mt-6 rounded-2xl border border-[#E5A3AC] bg-[#F8C8CE] p-5 text-[#7A2E38] md:p-6">

        <div class="flex items-start gap-3">

            <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-white/60">
                <span class="text-xl">🛡️</span>
            </div>

            <div>
                <p class="text-sm font-bold">
                    Tips Transaksi Aman di Lapak Kampus
                </p>

                <p class="mt-2 text-xs leading-relaxed">
                    Selalu lakukan COD di area kampus yang ramai
                    dan periksa kondisi barang sebelum melakukan pembayaran.
                    Hindari memberikan informasi pribadi yang bersifat rahasia.
                </p>
            </div>

        </div>

    </div>

@endsection
