@extends('layouts.admin')

@section('title', 'Kelola Barang - Lapak Kampus')

@section('content')
    <!-- Judul & Deskripsi Halaman -->
    <div class="mb-5">
        <h1 class="text-[22px] font-bold text-[#111827] tracking-tight">Kelola Barang</h1>
        <p class="text-[12px] text-[#374151] mt-1 leading-relaxed">
            Lihat dan kelola seluruh barang yang terdaftar di sistem, termasuk menghapus barang yang melanggar<br>
            aturan atau sudah tidak relevan.
        </p>
    </div>

    <!-- Pesan Flash (jika ada aksi edit/hapus) -->
    @if(session('success'))
        <div class="mb-4 px-4 py-2.5 rounded-xl bg-green-100 border border-green-300 text-green-800 text-[12px] font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Filter Tab + Pencarian -->
    <form method="GET" action="{{ route('admin.barang.index') }}" class="space-y-4 mb-6">
        <!-- Tab Filter Status -->
        <div class="flex flex-wrap items-center gap-2.5">
            @foreach($counts as $label => $total)
                @php
                    $isActive = $activeStatus === $label;
                @endphp
                <button type="submit"
                        name="status"
                        value="{{ $label }}"
                        class="px-3.5 py-1.5 rounded-full text-[12px] border transition-colors
                        {{ $isActive
                            ? 'bg-white border-gray-400 font-bold text-[#111827] shadow-2xs'
                            : 'bg-[#F3F4F6] border-gray-300 font-medium text-[#374151] hover:bg-white' }}">
                    {{ $label }} ({{ $total }})
                </button>
            @endforeach
        </div>

        <!-- Kolom Pencarian Nama Barang atau Penjual -->
        <div class="relative w-full">
            <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" d="M20 20l-3.5-3.5"/>
                </svg>
            </span>
            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Cari nama barang atau penjual..."
                   class="w-full bg-white border border-gray-300 rounded-full py-2.5 pl-11 pr-5 text-[12.5px] text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-400">
        </div>
    </form>

    <!-- Daftar / Tabel Barang -->
    <div class="overflow-x-auto">
        <div class="min-w-[780px]">
            <!-- Header Kolom -->
            <div class="grid grid-cols-12 items-center px-2 pb-3 text-[11px] text-[#374151] font-medium">
                <div class="col-span-1">Foto</div>
                <div class="col-span-3">Barang</div>
                <div class="col-span-2">Penjual</div>
                <div class="col-span-1">Kategori</div>
                <div class="col-span-2">Harga</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-1 text-center">Aksi</div>
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
                                        <!-- Ikon Kaos / Jaket -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 4l3 2h6l3-2 3 4-2.5 2L17 9v11H7V9L5.5 10 3 8l3-4z"/>
                                        </svg>
                                    @elseif($item['icon_type'] === 'grid')
                                        <!-- Ikon Rak / Grid -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <rect x="4" y="4" width="6" height="6" rx="1"/>
                                            <rect x="14" y="4" width="6" height="6" rx="1"/>
                                            <rect x="4" y="14" width="6" height="6" rx="1"/>
                                            <rect x="14" y="14" width="6" height="6" rx="1"/>
                                        </svg>
                                    @else
                                        <!-- Ikon Chip / Elektronik -->
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
                        <div class="col-span-1">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10.5px] font-medium {{ $item['kategori_style'] }}">
                                {{ $item['kategori'] }}
                            </span>
                        </div>

                        <!-- Kolom 5: Harga -->
                        <div class="col-span-2 font-medium text-[#111827]">
                            {{ $item['harga'] }}
                        </div>

                        <!-- Kolom 6: Status -->
                        <div class="col-span-2">
                            <span class="inline-block px-3 py-1 rounded-full text-[10.5px] font-semibold {{ $item['status_style'] }}">
                                {{ $item['status'] }}
                            </span>
                        </div>

                        <!-- Kolom 7: Aksi (Edit & Hapus) -->
                        <div class="col-span-1 flex items-center justify-center gap-2">
                            <a href="{{ route('admin.barang.edit', $item['id']) }}"
                               title="Edit barang"
                               class="w-7 h-7 rounded-lg bg-[#F3F4F6] border border-gray-300 flex items-center justify-center text-[#374151] hover:bg-gray-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H7v-3.414a2 2 0 01.586-1.414z"/>
                                </svg>
                            </a>

                            <form action="{{ route('admin.barang.destroy', $item['id']) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        title="Hapus barang"
                                        class="w-7 h-7 rounded-lg bg-[#F3F4F6] border border-gray-300 flex items-center justify-center text-[#374151] hover:bg-red-100 hover:text-red-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="py-10 text-center text-[13px] text-gray-500">
                        Tidak ada data barang yang sesuai dengan filter atau pencarian.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection