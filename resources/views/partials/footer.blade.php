<footer id="tentang" class="mx-auto max-w-[1440px] px-6 pb-10 pt-4 lg:px-[77px]">
    <div class="grid gap-8 border-t border-neutral-400 pt-8 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
        <div>
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-12">
                <span class="text-2xl font-bold text-neutral-800">Lapak Kampus</span>
            </div>
            <p class="mt-3 max-w-xs text-neutral-500">Marketplace barang bekas internal, khusus untuk lingkungan mahasiswa.</p>
        </div>

        @foreach ([
            'Produk'  => ['Cara kerja', 'Kategori', 'Keamanan'],
            'Bantuan' => ['Pusat bantuan', 'Lapor barang', 'Kontak admin'],
            'Kampus'  => ['Tentang proyek', 'Program studi'],
        ] as $judul => $links)
            <div>
                <h4 class="font-semibold text-neutral-500">{{ $judul }}</h4>
                <ul class="mt-4 space-y-3">
                    @foreach ($links as $link)
                        <li><a href="#" class="text-neutral-700 hover:text-black">{{ $link }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</footer>