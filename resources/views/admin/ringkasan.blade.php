@extends('layouts.admin')

@section('title', 'Ringkasan Sistem - Lapak Kampus')

@section('content')
    <!-- Header Judul -->
    <div class="mb-6">
        <h1 class="text-[22px] font-bold text-[#111827] tracking-tight">Ringkasan sistem</h1>
        <p class="text-[13px] text-[#4B5563] mt-0.5">Pantauan aktivitas Lapak Kampus hari ini.</p>
    </div>

    <!-- Grid 4 Kartu Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        
        <!-- Kartu 1: Mahasiswa terdaftar -->
        <div class="bg-white border border-gray-300 rounded-2xl p-5 flex flex-col justify-between min-h-[145px]">
            <div>
                <div class="w-7 h-7 rounded-md bg-[#DBEAFE] text-[#2563EB] flex items-center justify-center mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 19v-1a3 3 0 00-3-3H8a3 3 0 00-3 3v1"/>
                        <circle cx="10.5" cy="8.5" r="2.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 19v-1a3 3 0 00-2.2-2.9M16 6.2a2.5 2.5 0 010 4.6"/>
                    </svg>
                </div>
                <div class="text-[18px] font-bold text-[#111827]">{{ $stats['mahasiswa']['total'] }}</div>
                <div class="text-[11px] text-[#4B5563] mt-0.5">Mahasiswa terdaftar</div>
            </div>
            <div class="text-[11px] font-bold text-[#111827] mt-3">
                {{ $stats['mahasiswa']['growth'] }}
            </div>
        </div>

        <!-- Kartu 2: Barang aktif -->
        <div class="bg-white border border-gray-300 rounded-2xl p-5 flex flex-col justify-between min-h-[145px]">
            <div>
                <div class="w-7 h-7 rounded-md bg-[#DCFCE7] text-[#16A34A] flex items-center justify-center mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div class="text-[18px] font-bold text-[#111827]">{{ $stats['barang_aktif']['total'] }}</div>
                <div class="text-[11px] text-[#4B5563] mt-0.5">
                    Barang aktif <span class="font-bold text-[#111827]">{{ $stats['barang_aktif']['growth'] }}</span>
                </div>
            </div>
            <div class="mt-3"></div>
        </div>

        <!-- Kartu 3: Menunggu moderasi -->
        <div class="bg-white border border-gray-300 rounded-2xl p-5 flex flex-col justify-between min-h-[145px]">
            <div>
                <div class="w-7 h-7 rounded-md bg-[#FEF3C7] text-[#D97706] flex items-center justify-center mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.5-3 8.5-7 9.5-4-1-7-5-7-9.5V7l7-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12.5l1.75 1.75L15 10.5"/>
                    </svg>
                </div>
                <div class="text-[18px] font-bold text-[#111827]">{{ $stats['moderasi']['total'] }}</div>
                <div class="text-[11px] text-[#4B5563] mt-0.5">Menunggu moderasi</div>
            </div>
            <div class="text-[11px] font-bold text-[#7C3A16] mt-3">
                {{ $stats['moderasi']['status'] }}
            </div>
        </div>

        <!-- Kartu 4: Laporan belum ditindak -->
        <div class="bg-white border border-gray-300 rounded-2xl p-5 flex flex-col justify-between min-h-[145px]">
            <div>
                <div class="w-7 h-7 rounded-md bg-[#FEE2E2] text-[#DC2626] flex items-center justify-center mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v18M5 4h11l-2 4.5L16 13H5"/>
                    </svg>
                </div>
                <div class="text-[18px] font-bold text-[#111827]">{{ $stats['laporan']['total'] }}</div>
                <div class="text-[11px] text-[#4B5563] mt-0.5">Laporan belum ditindak</div>
            </div>
            <div class="text-[11px] font-bold text-[#7C3A16] mt-3">
                {{ $stats['laporan']['status'] }}
            </div>
        </div>

    </div>

    <!-- Bagian Bawah: Distribusi Barang (Kiri) & Aktivitas Terbaru (Kanan) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kartu Distribusi Barang per Kategori (7 Kolom) -->
        <div class="lg:col-span-7 bg-white border border-gray-300 rounded-2xl p-6">
            <h2 class="text-[15px] font-bold text-[#111827]">Distribusi barang per kategori</h2>
            <p class="text-[11px] text-[#6B7280] mt-0.5 mb-6">Dari seluruh barang aktif di sistem</p>

            <div class="space-y-4">
                @foreach($kategoriDistribusi as $item)
                    <div class="flex items-center gap-4">
                        <!-- Nama Kategori -->
                        <div class="w-24 text-[12px] font-medium text-[#111827] shrink-0">
                            {{ $item['nama'] }}
                        </div>

                        <!-- Progress Bar -->
                        <div class="flex-1 bg-[#D9D9D9] h-2 rounded-full overflow-hidden">
                            <div class="{{ $item['warna'] }} h-full rounded-full" style="width: {{ $item['persentase'] }}%"></div>
                        </div>

                        <!-- Nominal Harga -->
                        <div class="w-20 text-right text-[12px] font-medium text-[#111827] shrink-0">
                            {{ $item['nominal'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Kartu Aktivitas Terbaru (5 Kolom) -->
        <div class="lg:col-span-5 bg-white border border-gray-300 rounded-2xl p-6">
            <h2 class="text-[15px] font-bold text-[#111827] mb-3">Aktivitas terbaru</h2>

            <div class="divide-y divide-gray-200">
                @foreach($aktivitasTerbaru as $aktivitas)
                    <div class="py-3.5 first:pt-2 last:pb-1 text-[12px] text-[#1F2937] leading-relaxed">
                        @if($aktivitas['bold_position'] === 'start')
                            <span class="font-bold text-[#111827]">{{ $aktivitas['bold'] }}</span> {{ $aktivitas['text'] }}
                        @else
                            {{ $aktivitas['text'] }} <span class="font-bold text-[#111827]">{{ $aktivitas['bold'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection