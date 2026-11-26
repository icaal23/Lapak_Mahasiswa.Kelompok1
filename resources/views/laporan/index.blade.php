@extends('layouts.mahasiswa')

@section('title', 'Laporan Pendapatan - Lapak Kampus')

@section('content')
    @php
        $rupiah = fn ($angka) => number_format($angka, 0, ',', '.');
        $bulanSingkat = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Kelas ditulis lengkap di sini supaya terbaca oleh Tailwind
        $warnaBadge = [
            'Buku' => 'bg-c-buku',
            'Elektronik' => 'bg-c-elektronik',
            'Pakaian' => 'bg-c-pakaian',
            'Perlengkapan Kuliah' => 'bg-c-kuliah',
            'Lainnya' => 'bg-c-lain',
        ];
        $warnaBar = [
            'Buku' => 'bg-pink-400',
            'Elektronik' => 'bg-c-elektronik',
            'Pakaian' => 'bg-c-pakaian',
            'Perlengkapan Kuliah' => 'bg-c-kuliah',
            'Lainnya' => 'bg-c-lain',
        ];
        $labelPendek = ['Perlengkapan Kuliah' => 'Perlengkapan'];
    @endphp

    <h1 class="text-4xl font-extrabold">Laporan pendapatan</h1>
    <p class="mt-3 text-lg">Ringkasan hasil penjualan barang bekasmu di Lapak Kampus.</p>

    @if (session('sukses'))
        <div class="mt-6 rounded-xl border border-green-300 bg-green-100 px-5 py-3 font-semibold text-green-800">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Kartu ringkasan --}}
    <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-neutral-300 bg-white p-5">
            <span class="flex size-10 items-center justify-center rounded-lg bg-green-100 text-green-600">
                <x-icon name="chart" class="size-5" />
            </span>
            <p class="mt-6 text-3xl font-extrabold">Rp.{{ $rupiah($totalPendapatan) }}</p>
            <p class="mt-1 text-base text-neutral-700">Total pendapatan</p>
            <p class="mt-3 text-sm font-semibold">{{ $jumlahTerjual }} barang terjual</p>
        </div>

        <div class="rounded-2xl border border-neutral-300 bg-white p-5">
            <span class="flex size-10 items-center justify-center rounded-lg bg-pink-100 text-pink-500">
                <x-icon name="tag" class="size-5" />
            </span>
            <p class="mt-6 text-3xl font-extrabold">{{ $terjualBulanIni }}</p>
            <p class="mt-1 text-base text-neutral-700">Barang terjual <span class="font-bold">Bulan ini</span></p>
        </div>

        <div class="rounded-2xl border border-neutral-300 bg-white p-5">
            <span class="flex size-10 items-center justify-center rounded-lg bg-orange-100 text-orange-400">
                <x-icon name="lainnya" class="size-5" />
            </span>
            <p class="mt-6 text-3xl font-extrabold">{{ $barangAktif }}</p>
            <p class="mt-1 text-base text-neutral-700">Barang masih aktif</p>
            <p class="mt-3 text-sm font-semibold text-amber-900">Menunggu pembeli</p>
        </div>

        <div class="rounded-2xl border border-neutral-300 bg-white p-5">
            <span class="flex size-10 items-center justify-center rounded-lg bg-blue-100 text-blue-500">
                <x-icon name="user" class="size-5" />
            </span>
            <p class="mt-6 text-3xl font-extrabold">Rp.{{ $rupiah($rataRata) }}</p>
            <p class="mt-1 text-base text-neutral-700">Rata-rata harga jual</p>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-5">
        {{-- Pendapatan per bulan --}}
        <div class="rounded-2xl border border-neutral-300 bg-white p-6 lg:col-span-3">
            <h2 class="text-lg font-bold">Pendapatan per bulan</h2>
            <p class="text-sm text-neutral-600">3 bulan terakhir</p>

            <div class="mt-6 space-y-5">
                @foreach ($perBulan as $m)
                    <div class="flex items-center gap-4">
                        <span class="w-24 shrink-0 text-sm font-semibold">{{ $m['label'] }}</span>
                        <div class="h-3 flex-1 overflow-hidden rounded-full bg-neutral-200">
                            <div class="h-full rounded-full bg-neutral-400" style="width: {{ $m['persen'] }}%"></div>
                        </div>
                        <span class="w-28 shrink-0 text-right text-sm font-semibold">Rp.{{ $rupiah($m['jumlah']) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kategori barang terjual --}}
        <div class="rounded-2xl border border-neutral-300 bg-white p-6 lg:col-span-2">
            <h2 class="text-lg font-bold">Kategori barang terjual</h2>
            <p class="text-sm text-neutral-600">Dari seluruh riwayat penjualanmu</p>

            <div class="mt-6 space-y-5">
                @forelse ($perKategori as $kategori => $jumlah)
                    <div class="flex items-center gap-4">
                        <span class="w-28 shrink-0 text-sm font-semibold">{{ $labelPendek[$kategori] ?? $kategori }}</span>
                        <div class="h-3 flex-1 overflow-hidden rounded-full bg-neutral-200">
                            <div class="{{ $warnaBar[$kategori] ?? 'bg-c-lain' }} h-full rounded-full"
                                 style="width: {{ (int) round($jumlah / $maksKategori * 100) }}%"></div>
                        </div>
                        <span class="w-6 shrink-0 text-right text-sm font-semibold">{{ $jumlah }}</span>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500">Belum ada barang terjual.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Riwayat penjualan --}}
    <h2 class="mt-8 text-base font-bold">Riwayat Penjualan</h2>
    <div class="mt-3 overflow-x-auto rounded-2xl border border-neutral-300 bg-white">
        <table class="w-full min-w-[760px] text-left">
            <thead>
                <tr class="border-b border-neutral-300 text-sm text-neutral-600">
                    <th class="px-5 py-4 font-semibold">Barang</th>
                    <th class="px-5 py-4 font-semibold">Pembeli</th>
                    <th class="px-5 py-4 font-semibold">Kategori</th>
                    <th class="px-5 py-4 font-semibold">Harga</th>
                    <th class="px-5 py-4 font-semibold">Tanggal terjual</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayat as $b)
                    @php $tgl = $b->tanggal_terjual; @endphp
                    <tr class="border-t border-neutral-200 text-sm">
                        <td class="px-5 py-4 font-semibold">{{ $b->nama }}</td>
                        <td class="px-5 py-4">{{ $b->nama_pembeli ?: '-' }}</td>
                        <td class="px-5 py-4">
                            <span class="{{ $warnaBadge[$b->kategori] ?? 'bg-c-lain' }} inline-block rounded-full px-3 py-0.5 text-sm font-semibold">
                                {{ $b->kategori }}
                            </span>
                        </td>
                        <td class="px-5 py-4">Rp{{ $rupiah($b->pendapatan) }}</td>
                        <td class="px-5 py-4">{{ $tgl->day }} {{ $bulanSingkat[$tgl->month] }} {{ $tgl->year }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-neutral-500">
                            Belum ada penjualan. Tandai barang aktifmu sebagai terjual lewat halaman
                            <a href="{{ route('barang.index', ['status' => 'aktif']) }}" class="font-semibold text-navy underline">Barang Saya</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
