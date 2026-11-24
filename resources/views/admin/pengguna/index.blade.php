@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Lapak Kampus')

@section('content')
    <!-- Judul & Subjudul Halaman -->
    <div class="mb-5">
        <h1 class="text-[22px] font-bold text-[#111827] tracking-tight">Kelola pengguna</h1>
        <p class="text-[12px] text-[#374151] mt-1">
            Daftar mahasiswa yang terdaftar di sistem.
        </p>
    </div>

    <!-- Pesan Flash -->
    @if(session('success'))
        <div class="mb-4 px-4 py-2.5 rounded-xl bg-green-100 border border-green-300 text-green-800 text-[12px] font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Kolom Pencarian Nama atau NIM -->
    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="mb-6">
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
                   placeholder="Cari nama atau NIM"
                   class="w-full bg-white border border-gray-300 rounded-full py-2.5 pl-11 pr-5 text-[12.5px] text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-400">
        </div>
    </form>

    <!-- Daftar / Tabel Mahasiswa -->
    <div class="overflow-x-auto">
        <div class="min-w-[680px]">
            <!-- Header Kolom -->
            <div class="grid grid-cols-12 items-center px-2 pb-3 text-[11px] text-[#374151] font-medium">
                <div class="col-span-3">Nama</div>
                <div class="col-span-2">NIM</div>
                <div class="col-span-3">Program Studi</div>
                <div class="col-span-2">Status</div>
                <div class="col-span-2 text-left pl-2">Aksi</div>
            </div>

            <!-- Baris Data -->
            <div class="divide-y divide-gray-300 border-t border-gray-300">
                @forelse($users as $row)
                    @php
                        $isAktif = $row['status'] === 'Aktif';
                    @endphp
                    <div class="grid grid-cols-12 items-center px-2 py-3.5 text-[12px] text-[#111827]">
                        
                        <!-- Nama -->
                        <div class="col-span-3 pr-3 font-bold text-[#111827]">
                            {{ $row['nama'] }}
                        </div>

                        <!-- NIM -->
                        <div class="col-span-2 pr-3 font-normal text-[#1F2937]">
                            {{ $row['nim'] }}
                        </div>

                        <!-- Program Studi -->
                        <div class="col-span-3 pr-3 font-normal text-[#1F2937]">
                            {{ $row['prodi'] }}
                        </div>

                        <!-- Status -->
                        <div class="col-span-2">
                            @if($isAktif)
                                <span class="inline-block px-3 py-0.5 rounded-full text-[10.5px] font-semibold bg-[#A7E3A1] text-[#111827]">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-block px-3 py-0.5 rounded-full text-[10.5px] font-semibold bg-[#D1D5DB] text-[#111827]">
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <!-- Aksi -->
                        <div class="col-span-2 pl-2">
                            <form action="{{ route('admin.pengguna.toggle', $row['id']) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-4 py-1 rounded-full bg-white hover:bg-gray-50 border border-gray-300 text-[10.5px] font-medium text-[#111827] transition-colors">
                                    {{ $isAktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="py-10 text-center text-[13px] text-gray-500">
                        Tidak ada data mahasiswa yang sesuai dengan pencarian.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection