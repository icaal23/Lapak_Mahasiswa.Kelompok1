@extends('layouts.mahasiswa')

@section('title', 'Tambah Barang - Lapak Kampus')

@section('content')
    <h1 class="text-4xl font-extrabold">Tambah barang</h1>
    <p class="mt-3 text-lg">Isi detail barang bekas yang ingin kamu tawarkan.</p>

    @if (session('sukses'))
        <div class="mt-6 rounded-xl border border-green-300 bg-green-100 px-5 py-3 font-semibold text-green-800">
            {{ session('sukses') }}
        </div>
    @endif

    <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data"
          class="mt-6 rounded-[40px] border border-neutral-400 bg-white p-8 lg:p-12">
        @csrf

        <div class="grid gap-x-12 gap-y-8 lg:grid-cols-2">

            {{-- KOLOM KIRI --}}
            <div class="space-y-8">
                <div>
                    <label for="nama" class="block text-xl font-semibold text-neutral-500">Nama Barang</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama') }}" placeholder="Contoh: Buku Algoritma"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                    @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="kategori" class="block text-xl font-semibold text-neutral-500">Kategori</label>
                        <select id="kategori" name="kategori"
                                class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategoriList as $k)
                                <option value="{{ $k }}" @selected(old('kategori') === $k)>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="harga" class="block text-xl font-semibold text-neutral-500">Harga</label>
                        <input id="harga" name="harga" type="text" inputmode="numeric" value="{{ old('harga') }}" placeholder="Rp.60.000"
                               class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                        @error('harga') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <span class="block text-xl font-semibold text-neutral-500">Kondisi Barang</span>
                    <div class="mt-3 flex flex-wrap gap-3">
                        @foreach ($kondisiList as $kd)
                            <label class="cursor-pointer">
                                <input type="radio" name="kondisi" value="{{ $kd }}" class="peer sr-only" @checked(old('kondisi') === $kd)>
                                <span class="block rounded-full border border-neutral-400 px-4 py-3 text-lg text-neutral-500 transition
                                             peer-checked:border-brand peer-checked:bg-brand peer-checked:text-white">
                                    {{ $kd }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('kondisi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-xl font-semibold text-neutral-500">Deskripsi Barang</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Ceritakan kondisi, kelengkapan, dan alasan menjual"
                              class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- KOLOM KANAN --}}
            <div class="space-y-8">
                {{-- Foto --}}
                <div x-data="{
                        files: [], drag: false,
                        pilih(list) {
                            const dt = new DataTransfer();
                            [...list].slice(0, 5).forEach(f => dt.items.add(f));
                            $refs.input.files = dt.files;
                            this.files = [...dt.files].map(f => ({ nama: f.name, url: URL.createObjectURL(f) }));
                        }
                     }">
                    <span class="block text-xl font-semibold text-neutral-500">Foto Barang</span>

                    <label @dragover.prevent="drag = true" @dragleave.prevent="drag = false" @drop.prevent="drag = false; pilih($event.dataTransfer.files)"
                           :class="drag ? 'border-brand bg-orange-50' : 'border-neutral-400 bg-neutral-300'"
                           class="mt-3 flex min-h-[220px] cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed p-6 text-center">
                        <input x-ref="input" type="file" name="foto[]" accept="image/*" multiple class="hidden"
                               @change="pilih($event.target.files)">

                        <template x-if="files.length === 0">
                            <div class="flex flex-col items-center">
                                <x-icon name="upload" class="size-9 text-navy" />
                                <p class="mt-3 text-xl font-bold">Seret foto ke sini</p>
                                <p class="mt-2 text-sm text-neutral-500">atau klik untuk memilih file, maksimal 5 foto</p>
                            </div>
                        </template>

                        <template x-if="files.length > 0">
                            <div class="grid w-full grid-cols-3 gap-3">
                                <template x-for="f in files" :key="f.url">
                                    <img :src="f.url" :alt="f.nama" class="aspect-square w-full rounded-xl object-cover">
                                </template>
                            </div>
                        </template>
                    </label>
                    @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    @error('foto.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="lokasi" class="block text-xl font-semibold text-neutral-500">Lokasi Ambil Barang</label>
                    <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi') }}" placeholder="Contoh: Perpustakaan"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                    @error('lokasi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Peringatan --}}
                <div class="flex gap-3 rounded-2xl border border-red-300 bg-red-200/70 p-4 text-sm text-red-800/70">
                    <x-icon name="peringatan" class="mt-0.5 size-5 shrink-0" />
                    <p>Pembayaran dan pengambilan barang dilakukan langsung sesuai kesepakatan antara kamu dan pembeli — Lapak Kampus tidak menangani pembayaran.</p>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-wrap gap-3">
                    <button type="submit" name="aksi" value="draft"
                            class="rounded-full border border-neutral-400 bg-white px-6 py-3 text-lg font-bold hover:bg-neutral-100">
                        Simpan Draft
                    </button>
                    <button type="submit" name="aksi" value="publikasi"
                            class="rounded-full bg-brand px-6 py-3 text-lg font-bold text-white hover:opacity-90">
                        Publikasikan Barang
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection