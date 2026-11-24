@extends('layouts.mahasiswa')

@section('title', 'Laporan Pendapatan - Lapak Kampus')

@section('content')
    <h1 class="text-4xl font-extrabold">Laporan Pendapatan</h1>
    <p class="mt-3 text-lg">Ringkasan penjualan dan riwayat transaksi barang kamu di Lapak Kampus.</p>

    {{-- Kartu Ringkasan --}}
    <div class="mt-6 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-neutral-300 bg-white p-6">
            <div class="text-sm font-medium text-neutral-500">Total Pendapatan</div>
            <div class="mt-2 text-2xl font-extrabold text-[#111827]">
                Rp.{{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-300 bg-white p-6">
            <div class="text-sm font-medium text-neutral-500">Barang Terjual</div>
            <div class="mt-2 text-2xl font-extrabold text-[#111827]">
                {{ $ringkasan['barang_terjual'] }}
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-300 bg-white p-6">
            <div class="text-sm font-medium text-neutral-500">Barang Aktif</div>
            <div class="mt-2 text-2xl font-extrabold text-[#111827]">
                {{ $ringkasan['barang_aktif'] }}
            </div>
        </div>

        <div class="rounded-2xl border border-neutral-300 bg-white p-6">
            <div class="text-sm font-medium text-neutral-500">Menunggu Moderasi</div>
            <div class="mt-2 text-2xl font-extrabold text-[#111827]">
                {{ $ringkasan['menunggu_moderasi'] }}
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Penjualan --}}
    <div class="mt-8 overflow-hidden rounded-2xl border border-neutral-300 bg-white">
        <div class="border-b border-neutral-200 px-6 py-4">
            <h2 class="text-xl font-bold">Riwayat Penjualan</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-neutral-200 bg-neutral-50 text-neutral-600">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold">Tanggal</th>
                        <th class="px-6 py-3.5 font-semibold">Nama Barang</th>
                        <th class="px-6 py-3.5 font-semibold">Kategori</th>
                        <th class="px-6 py-3.5 font-semibold">Pembeli</th>
                        <th class="px-6 py-3.5 font-semibold">Nominal</th>
                        <th class="px-6 py-3.5 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-200">
                    @forelse ($riwayat as $row)
                        <tr>
                            <td class="px-6 py-4 text-neutral-600">{{ $row['tanggal'] }}</td>
                            <td class="px-6 py-4 font-semibold text-[#111827]">{{ $row['barang'] }}</td>
                            <td class="px-6 py-4 text-neutral-600">{{ $row['kategori'] }}</td>
                            <td class="px-6 py-4 text-neutral-600">{{ $row['pembeli'] }}</td>
                            <td class="px-6 py-4 font-bold text-[#111827]">
                                Rp.{{ number_format($row['harga'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-neutral-500">
                                Belum ada riwayat pendapatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection