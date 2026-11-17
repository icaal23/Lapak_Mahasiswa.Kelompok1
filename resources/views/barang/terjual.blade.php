@extends('layouts.mahasiswa')

@section('title', 'Tandai Terjual - Lapak Kampus')

@section('content')
    <h1 class="text-4xl font-extrabold">Tandai terjual</h1>
    <p class="mt-3 text-lg">Catat penjualan supaya masuk ke laporan pendapatanmu.</p>

    <form method="POST" action="{{ route('barang.terjual.store', $barang) }}"
          class="mt-6 max-w-2xl rounded-[40px] border border-neutral-400 bg-white p-8 lg:p-12">
        @csrf

        <div class="space-y-8">
            <div>
                <span class="block text-xl font-semibold text-neutral-500">Barang</span>
                <p class="mt-3 rounded-2xl border border-neutral-300 bg-neutral-100 px-5 py-4 text-lg font-semibold">
                    {{ $barang->nama }}
                    <span class="font-normal text-neutral-500">· Harga tawar Rp.{{ number_format($barang->harga, 0, ',', '.') }}</span>
                </p>
            </div>

            <div>
                <label for="nama_pembeli" class="block text-xl font-semibold text-neutral-500">Nama Pembeli</label>
                <input id="nama_pembeli" name="nama_pembeli" type="text" value="{{ old('nama_pembeli') }}"
                       class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                @error('nama_pembeli') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="harga_jual" class="block text-xl font-semibold text-neutral-500">Harga Jual</label>
                    <input id="harga_jual" name="harga_jual" type="text" inputmode="numeric"
                           value="{{ old('harga_jual', $barang->harga) }}"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                    @error('harga_jual') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="terjual_pada" class="block text-xl font-semibold text-neutral-500">Tanggal Terjual</label>
                    <input id="terjual_pada" name="terjual_pada" type="date"
                           value="{{ old('terjual_pada', now()->format('Y-m-d')) }}"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                    @error('terjual_pada') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('barang.index') }}"
                   class="rounded-full border border-neutral-400 bg-white px-6 py-3 text-lg font-bold hover:bg-neutral-100">Batal</a>
                <button type="submit" class="rounded-full bg-brand px-6 py-3 text-lg font-bold text-white hover:opacity-90">
                    Tandai Terjual
                </button>
            </div>
        </div>
    </form>
@endsection
