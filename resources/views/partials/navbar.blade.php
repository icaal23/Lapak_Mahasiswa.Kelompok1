<header class="border-b border-neutral-400 bg-page">
    <div class="mx-auto flex max-w-[1440px] items-center justify-between px-6 py-5 lg:px-9">
        <a href="{{ route('beranda') }}" class="flex items-center gap-2">
            <img src="{{ asset('assets/image/logo_lapak.png') }}" alt="" class="h-12">
            <span class="text-2xl font-bold text-neutral-800">Lapak Kampus</span>
        </a>

        <nav class="hidden gap-12 text-xl font-semibold text-neutral-500 md:flex">
            <a href="{{ route('beranda') }}" class="hover:text-black">Beranda</a>
            <a href="#kategori" class="hover:text-black">Kategori</a>
            <a href="#cara-kerja" class="hover:text-black">Cara Kerja</a>
            <a href="#tentang" class="hover:text-black">Tentang</a>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="rounded-full border border-neutral-600 px-4 py-1.5 text-xl font-semibold text-neutral-800">Masuk</a>
            <a href="{{ route('register') }}" class="rounded-full bg-brand px-4 py-1.5 text-xl font-semibold text-white">Daftar</a>
            <button type="button" class="ml-4 text-neutral-700" aria-label="Menu">
                <x-icon name="menu" class="size-7" />
            </button>
        </div>
    </div>
</header>