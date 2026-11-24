@extends('layouts.admin')

@section('title', 'Moderasi Barang - Lapak Kampus')

@section('content')
    <!-- Judul & Subjudul Halaman -->
    <div class="mb-5">
        <h1 class="text-[22px] font-bold text-[#111827] tracking-tight">Moderasi barang</h1>
        <p class="text-[12px] text-[#374151] mt-1">
            Tinjau barang yang baru dipublikasikan mahasiswa.
        </p>
    </div>

    <!-- Pesan Flash -->
    @if(session('success'))
        <div class="mb-4 px-4 py-2.5 rounded-xl bg-green-100 border border-green-300 text-green-800 text-[12px] font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tab Filter Status -->
    <form method="GET" action="{{ route('admin.moderasi.index') }}" class="mb-6">
        @if(!empty($search))
            <input type="hidden" name="search" value="{{ $search }}">
        @endif

        <div class="flex flex-wrap items-center gap-2.5">
            @foreach($counts as $label => $total)
                @php
                    $isActive = $activeTab === $label;
                    $tabText = $label === 'Menunggu' ? "Menunggu ({$total})" : $label;
                @endphp
                <button type="submit"
                        name="status"
                        value="{{ $label }}"
                        class="px-3.5 py-1.5 rounded-full text-[12px] border transition-colors
                        {{ $isActive
                            ? 'bg-white border-gray-400 font-bold text-[#111827] shadow-2xs'
                            : 'bg-[#F3F4F6] border-gray-300 font-medium text-[#374151] hover:bg-white' }}">
                    {{ $tabText }}
                </button>
            @endforeach
        </div>
    </form>

    <!-- Tabel / Daftar Moderasi Barang -->
    <div class="overflow-x-auto">
        <div class="min-w-[760px]">
            <!-- Header Kolom -->
            <div class="grid grid-cols-12 items-center px-2 pb-3 text-[11px] text-[#374151] font-medium">
                <div class="col-span-1">Foto</div>
                <div class="col-span-3">Barang</div>
                <div class="col-span-2">Penjual</div>
                <div class="col-span-2">Kategori</div>
                <div class="col-span-2">Tanggal</div>
                <div class="col-span-2 text-left pl-2">Aksi</div>
            </div>

            <!-- Baris Data -->
            <div class="divide-y divide-gray-300 border-t border-gray-300">
                @forelse($items as $item)
                    <div class="grid grid-cols-12 items-center px-2 py-3.5 text-[12px] text-[#111827]">

                        <!-- Kolom 1: Foto / Thumbnail -->
                        <div class="col-span-1">
                            @if(!empty($item['foto']))
                                <img src="{{ asset('storage/' . $item['foto']) }}"
                                     alt="{{ $item['barang'] }}"
                                     class="w-10 h-10 rounded-xl object-cover">
                            @else
                                <div class="w-10 h-10 rounded-xl {{ $item['thumb_bg'] }} flex items-center justify-center text-white">
                                    @if($item['icon_type'] === 'shirt')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 4l3 2h6l3-2 3 4-2.5 2L17 9v11H7V9L5.5 10 3 8l3-4z"/>
                                        </svg>
                                    @elseif($item['icon_type'] === 'grid')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="4" y="4" width="6" height="6" rx="1"/>
                                            <rect x="14" y="4" width="6" height="6" rx="1"/>
                                            <rect x="4" y="14" width="6" height="6" rx="1"/>
                                            <rect x="14" y="14" width="6" height="6" rx="1"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="7" y="7" width="10" height="10" rx="1.5"/>
                                            <path stroke-linecap="round" d="M9 4v3M15 4v3M9 17v3M15 17v3M4 9h3M4 15h3M17 9h3M17 15h3"/>
                                        </svg>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Kolom 2: Nama Barang -->
                        <div class="col-span-3 pr-3 font-bold text-[#111827] leading-snug">
                            {{ $item['barang'] }}
                        </div>

                        <!-- Kolom 3: Penjual -->
                        <div class="col-span-2 pr-3 text-[#1F2937]">
                            {{ $item['penjual'] }}
                        </div>

                        <!-- Kolom 4: Kategori -->
                        <div class="col-span-2">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10.5px] font-medium {{ $item['kategori_style'] }}">
                                {{ $item['kategori'] }}
                            </span>
                        </div>

                        <!-- Kolom 5: Tanggal -->
                        <div class="col-span-2 text-[#111827] font-normal">
                            {{ $item['tanggal'] }}
                        </div>

                        <!-- Kolom 6: Aksi (Setujui & X) -->
                        <div class="col-span-2 flex items-center gap-2 pl-2">
                            <form action="{{ route('admin.moderasi.approve', $item['id']) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-3.5 py-1 rounded-full bg-[#1E1B4B] hover:bg-[#111827] text-white text-[10.5px] font-semibold transition-colors">
                                    Setujui
                                </button>
                            </form>

                            <form action="{{ route('admin.moderasi.reject', $item['id']) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        title="Tolak barang"
                                        class="w-6 h-6 rounded-full bg-[#E5E7EB] hover:bg-red-100 text-[#1F2937] hover:text-red-700 flex items-center justify-center text-[11px] font-semibold transition-colors">
                                    &times;
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="py-10 text-center text-[13px] text-gray-500">
                        Tidak ada barang yang perlu dimoderasi pada filter ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection