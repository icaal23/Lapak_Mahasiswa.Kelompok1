@extends('layouts.mahasiswa')

@section('title', 'Ubah Barang - Lapak Kampus')

@section('content')
    <h1 class="text-4xl font-extrabold">Ubah barang</h1>
    <p class="mt-3 text-lg">Perbarui detail barang yang kamu tawarkan.</p>

    <form method="POST" action="{{ route('barang.update', $barang) }}" enctype="multipart/form-data"
          class="mt-6 rounded-[40px] border border-neutral-400 bg-white p-8 lg:p-12">
        @csrf
        @method('PUT')

        <div class="grid gap-x-12 gap-y-8 lg:grid-cols-2">
            <div class="space-y-8">
                <div>
                    <label for="nama" class="block text-xl font-semibold text-neutral-500">Nama Barang</label>
                    <input id="nama" name="nama" type="text" value="{{ old('nama', $barang->nama) }}"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                    @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="kategori" class="block text-xl font-semibold text-neutral-500">Kategori</label>
                        <select id="kategori" name="kategori"
                                class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                            @foreach ($kategoriList as $k)
                                <option value="{{ $k }}" @selected(old('kategori', $barang->kategori) === $k)>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="harga" class="block text-xl font-semibold text-neutral-500">Harga</label>
                        <input id="harga" name="harga" type="text" inputmode="numeric" value="{{ old('harga', $barang->harga) }}"
                               class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                        @error('harga') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <span class="block text-xl font-semibold text-neutral-500">Kondisi Barang</span>
                    <div class="mt-3 flex flex-wrap gap-3">
                        @foreach ($kondisiList as $kd)
                            <label class="cursor-pointer">
                                <input type="radio" name="kondisi" value="{{ $kd }}" class="peer sr-only"
                                       @checked(old('kondisi', $barang->kondisi) === $kd)>
                                <span class="block rounded-full border border-neutral-400 px-4 py-3 text-lg text-neutral-500 transition
                                             peer-checked:border-brand peer-checked:bg-brand peer-checked:text-white">{{ $kd }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('kondisi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-xl font-semibold text-neutral-500">Deskripsi Barang</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3"
                              class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="space-y-8">
                <div>
                    <span class="block text-xl font-semibold text-neutral-500">Foto Barang</span>
                    @if (! empty($barang->foto))
                        <div class="mt-3 grid grid-cols-5 gap-2">
                            @foreach ($barang->foto as $f)
                                <img src="{{ asset('storage/' . $f) }}" alt="" class="aspect-square w-full rounded-lg object-cover">
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="foto[]" accept="image/*" multiple
                           class="mt-3 w-full rounded-2xl border border-dashed border-neutral-500 bg-neutral-100 p-4">
                    <p class="mt-1 text-sm text-neutral-500">Kosongkan jika tidak ingin mengganti foto. Foto baru akan menggantikan semua foto lama (maksimal 5).</p>
                    @error('foto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    @error('foto.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="lokasi" class="block text-xl font-semibold text-neutral-500">Lokasi Ambil Barang</label>
                    <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi', $barang->lokasi) }}"
                           class="mt-3 w-full rounded-2xl border border-neutral-400 px-5 py-4 text-lg focus:border-brand focus:ring-brand">
                    @error('lokasi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('barang.index') }}"
                       class="rounded-full border border-neutral-400 bg-white px-6 py-3 text-lg font-bold hover:bg-neutral-100">Batal</a>
                    <button type="submit" class="rounded-full bg-brand px-6 py-3 text-lg font-bold text-white hover:opacity-90">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection