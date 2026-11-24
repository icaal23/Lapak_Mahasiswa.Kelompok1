@extends('layouts.mahasiswa')

@section('title', 'Keranjang - Lapak Kampus')

@section('content')
    <h1 class="text-4xl font-extrabold">Keranjang</h1>
    <p class="mt-3 text-lg">Daftar barang pilihan kamu sebelum koordinasi pengambilan di kampus.</p>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        {{-- Daftar Item Keranjang --}}
        <div class="space-y-4 lg:col-span-2">
            @forelse ($items as $item)
                <div class="flex flex-col justify-between gap-4 rounded-2xl border border-neutral-300 bg-white p-6 sm:flex-row sm:items-center">
                    <div>
                        <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-600">
                            {{ $item['kategori'] }}
                        </span>
                        <h2 class="mt-2 text-xl font-bold text-[#111827]">{{ $item['nama'] }}</h2>
                        <p class="mt-1 text-sm text-neutral-500">
                            Penjual: <span class="font-medium text-neutral-700">{{ $item['penjual'] }}</span> · Lokasi ambil: {{ $item['lokasi'] }}
                        </p>
                    </div>

                    <div class="text-left sm:text-right">
                        <div class="text-lg font-extrabold text-[#111827]">
                            Rp.{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                        </div>
                        <div class="mt-1 text-xs text-neutral-500">Jumlah: {{ $item['qty'] }}</div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-neutral-300 bg-white p-8 text-center text-neutral-500">
                    Keranjang kamu masih kosong.
                </div>
            @endforelse
        </div>

        {{-- Ringkasan --}}
        <div class="h-fit rounded-2xl border border-neutral-300 bg-white p-6">
            <h2 class="text-xl font-bold text-[#111827]">Ringkasan</h2>
            <div class="mt-4 flex items-center justify-between border-t border-neutral-200 pt-4 text-base">
                <span class="text-neutral-600">Total Perkiraan</span>
                <span class="text-xl font-extrabold text-[#111827]">
                    Rp.{{ number_format($subtotal, 0, ',', '.') }}
                </span>
            </div>
            <p class="mt-4 rounded-xl bg-amber-50 p-3 text-xs leading-relaxed text-amber-900">
                Pembayaran dan pengambilan barang dilakukan langsung sesuai kesepakatan antara pembeli dan penjual di area kampus.
            </p>
            <a href="{{ route('dashboard') }}"
               class="mt-5 block w-full rounded-full bg-brand px-5 py-3 text-center text-sm font-bold text-white hover:opacity-90">
                Lanjut Cari Barang
            </a>
        </div>
    </div>
@endsection