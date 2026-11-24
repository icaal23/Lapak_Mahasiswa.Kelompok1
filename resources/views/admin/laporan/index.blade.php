@extends('layouts.admin')

@section('title', 'Laporan - Lapak Kampus')

@section('content')
    <!-- Judul & Subjudul Halaman -->
    <div class="mb-6">
        <h1 class="text-[22px] font-bold text-[#111827] tracking-tight">Laporan</h1>
        <p class="text-[12px] text-[#374151] mt-1">
            Barang atau pengguna yang dilaporkan mahasiswa lain.
        </p>
    </div>

    <!-- Pesan Flash -->
    @if(session('success'))
        <div class="mb-4 px-4 py-2.5 rounded-xl bg-green-100 border border-green-300 text-green-800 text-[12px] font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Kartu Putih Daftar Laporan -->
    <div class="bg-white rounded-2xl p-6 max-w-[650px] space-y-6">
        @forelse($reports as $report)
            <div class="flex items-start gap-4">
                
                <!-- Kotak Ikon Bendera Merah Muda -->
                <div class="w-11 h-11 rounded-xl bg-[#F9D8D6] text-[#111827] flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 4v17M5 5h11l-2 4.5L16 14H5"/>
                    </svg>
                </div>

                <!-- Konten Laporan & Tombol Aksi -->
                <div class="flex-1 min-w-0">
                    <!-- Judul & Pelapor -->
                    <div class="text-[12px] text-[#111827] leading-snug">
                        <span class="font-bold">{{ $report['judul'] }}</span>
                        <span class="mx-1 text-[#4B5563]">&mdash;</span>
                        <span class="text-[#1F2937]">dilaporkan oleh {{ $report['pelapor'] }}</span>
                    </div>

                    <!-- Alasan & Tanggal -->
                    <p class="text-[10.5px] text-[#4B5563] mt-1 leading-normal">
                        Alasan: {{ $report['alasan'] }} &middot; {{ $report['tanggal'] }}
                    </p>

                    <!-- Tombol Tindak Lanjuti & Tolak Laporan -->
                    <div class="flex flex-wrap items-center gap-2.5 mt-3">
                        <form action="{{ route('admin.laporan.followup', $report['id']) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-3.5 py-1 rounded-full bg-[#1E1B4B] hover:bg-[#111827] text-white text-[10.5px] font-semibold transition-colors">
                                Tindak Lanjuti
                            </button>
                        </form>

                        <form action="{{ route('admin.laporan.reject', $report['id']) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-3.5 py-1 rounded-full bg-white hover:bg-gray-50 border border-gray-300 text-[#111827] text-[10.5px] font-medium transition-colors">
                                Tolak Laporan
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="py-8 text-center text-[13px] text-gray-500">
                Tidak ada laporan masuk saat ini.
            </div>
        @endforelse
    </div>
@endsection