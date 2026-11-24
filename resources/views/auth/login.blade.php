<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($isAdmin) && $isAdmin ? 'Masuk Admin - Lapak Kampus' : 'Masuk - Lapak Kampus' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .bg-navy-lapak {
            background-color: #030058;
        }
        .bg-gray-lapak {
            background-color: #EAEAEA;
        }
        .bg-orange-lapak {
            background-color: #FF944D;
        }
        .bg-orange-lapak:hover {
            background-color: #f38338;
        }
        .pill-category {
            background-color: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.35);
            transition: all 0.2s ease;
        }
        .pill-category:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body class="bg-gray-lapak min-h-dvh w-full overflow-x-hidden antialiased">

    <!-- Container Responsif (1 kolom di HP/tablet kecil, 2 kolom penuh dari md ke atas) -->
    <div class="w-full min-h-dvh grid grid-cols-1 md:grid-cols-2">
        
        <!-- PANEL KIRI (Biru Tua) -->
        <div class="bg-navy-lapak text-white min-h-[360px] sm:min-h-[400px] md:min-h-dvh px-5 py-6 sm:px-8 sm:py-8 md:px-12 md:py-12 lg:px-16 lg:py-14 flex flex-col justify-between gap-6">
            
            <!-- Header Logo -->
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5 sm:gap-3 w-fit group">
                <div class="relative flex flex-col items-center shrink-0">
                    <svg class="w-9 h-9 sm:w-10 sm:h-10 lg:w-11 lg:h-11 drop-shadow-md group-hover:scale-105 transition-transform" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 24H14M4 31H12M8 38H15" stroke="#FF944D" stroke-width="3" stroke-linecap="round"/>
                        <path d="M16 18H22L27 40H49L54 23H24" fill="#FF7A00" stroke="#FFB800" stroke-width="2.5" stroke-linejoin="round"/>
                        <rect x="29" y="13" width="8" height="9" rx="1.5" transform="rotate(-12 29 13)" fill="#38BDF8"/>
                        <rect x="38" y="12" width="9" height="10" rx="1.5" transform="rotate(10 38 12)" fill="#FACC15"/>
                        <circle cx="29" cy="46" r="3.5" fill="#FFFFFF"/>
                        <circle cx="46" cy="46" r="3.5" fill="#FFFFFF"/>
                    </svg>
                    <span class="text-[7px] font-extrabold tracking-tight text-orange-400 -mt-1">Lapak Kampus</span>
                </div>
                <span class="text-lg sm:text-xl lg:text-2xl font-bold tracking-tight text-white">Lapak Kampus</span>
            </a>

            <!-- Kutipan Utama -->
            <div class="my-2 md:my-0 max-w-xl">
                <h1 class="text-xl sm:text-2xl lg:text-[30px] xl:text-[32px] font-bold leading-[1.35] tracking-tight text-white">
                    "Barang di kos numpuk, tapi masih ada yang butuh — tinggal titip di Lapak Kampus."
                </h1>
            </div>

            <!-- Pil Kategori -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                <a href="{{ route('beranda', ['kategori' => 'elektronik']) }}" class="pill-category text-white text-[11px] sm:text-xs lg:text-sm font-medium px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full">
                    Elektronik
                </a>
                <a href="{{ route('beranda', ['kategori' => 'perlengkapan-kuliah']) }}" class="pill-category text-white text-[11px] sm:text-xs lg:text-sm font-medium px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full">
                    Perlengkapan Kuliah
                </a>
                <a href="{{ route('beranda', ['kategori' => 'buku']) }}" class="pill-category text-white text-[11px] sm:text-xs lg:text-sm font-medium px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full">
                    Buku
                </a>
                <a href="{{ route('beranda', ['kategori' => 'pakaian']) }}" class="pill-category text-white text-[11px] sm:text-xs lg:text-sm font-medium px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full">
                    Pakaian
                </a>
            </div>
        </div>

        <!-- PANEL KANAN (Form Login) -->
        <div class="bg-gray-lapak md:min-h-dvh px-5 py-7 sm:px-8 sm:py-9 md:px-12 md:py-12 lg:px-20 xl:px-24 flex flex-col justify-between gap-8">
            
            <!-- Bagian Atas: Kembali + Judul + Input -->
            <div class="w-full max-w-md lg:max-w-lg mx-auto">
                <!-- Tombol Kembali -->
                <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors mb-4 sm:mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>

                <!-- Heading -->
                <h2 class="text-2xl sm:text-[26px] lg:text-3xl font-bold text-black tracking-tight">
                    {{ isset($isAdmin) && $isAdmin ? 'Masuk ke akun Admin' : 'Masuk ke akunmu' }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1.5">
                    {{ isset($isAdmin) && $isAdmin ? 'Gunakan kredensial administrator kampus yang terdaftar.' : 'Gunakan email kampus yang sudah terdaftar.' }}
                </p>

                <!-- Alert Error Validasi -->
                @if ($errors->any())
                    <div class="mt-4 p-3 rounded-lg bg-red-100 border border-red-300 text-red-700 text-xs">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Alert Status -->
                @if (session('status'))
                    <div class="mt-4 p-3 rounded-lg bg-green-100 border border-green-300 text-green-700 text-xs">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Login -->
                <form id="loginForm" method="POST" action="{{ isset($isAdmin) && $isAdmin ? url('/admin/login') : url('/login') }}" class="mt-6 sm:mt-7 space-y-4 sm:space-y-5">
                    @csrf

                    <!-- Input Email -->
                    <div>
                        <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-600 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="namamahasiswa@gmail.com" 
                            required 
                            autofocus
                            class="w-full bg-white text-gray-800 text-sm sm:text-[15px] px-4 py-3 sm:py-3.5 rounded-xl border border-gray-400 focus:outline-none focus:border-[#030058] focus:ring-1 focus:ring-[#030058] placeholder-gray-400 transition-all"
                        >
                    </div>

                    <!-- Input Kata Sandi -->
                    <div>
                        <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-600 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="•••••••••" 
                                required
                                class="w-full bg-white text-gray-800 text-sm sm:text-[15px] px-4 py-3 sm:py-3.5 pr-11 rounded-xl border border-gray-400 focus:outline-none focus:border-[#030058] focus:ring-1 focus:ring-[#030058] placeholder-gray-400 transition-all"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword()" 
                                title="Tampilkan/Sembunyikan Kata Sandi"
                                class="absolute inset-y-0 right-3.5 flex items-center text-gray-400 hover:text-gray-700 focus:outline-none"
                            >
                                <svg id="eyeIcon" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bagian Bawah: Ingatkan Saya, Lupa Sandi, Tombol Submit, & Link Bawah -->
            <div class="w-full max-w-md lg:max-w-lg mx-auto pt-2">
                <div class="flex flex-wrap items-center justify-between gap-2 text-xs sm:text-sm mb-4">
                    <label for="remember" class="inline-flex items-center gap-2 cursor-pointer select-none text-gray-600">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            form="loginForm"
                            {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-400 text-[#030058] focus:ring-[#030058] bg-white cursor-pointer"
                        >
                        <span>Ingatkan saya</span>
                    </label>

                    <a href="{{ url('/forgot-password') }}" class="font-semibold text-red-500 hover:text-red-600 transition-colors">
                        Lupa kata sandi?
                    </a>
                </div>

                <button 
                    type="submit" 
                    form="loginForm"
                    class="w-full bg-orange-lapak text-white font-bold text-sm sm:text-base py-3 sm:py-3.5 rounded-full shadow-sm hover:shadow transition-all cursor-pointer active:scale-[0.99]"
                >
                    Masuk
                </button>

                <div class="mt-4 text-center space-y-2 text-xs sm:text-sm">
                    <p class="text-gray-500">
                        Belum punya akun? 
                        <a href="{{ url('/register') }}" class="font-semibold text-red-500 hover:text-red-600 transition-colors">
                            Daftar sekarang
                        </a>
                    </p>

                    <div>
                        @if(isset($isAdmin) && $isAdmin)
                            <a href="{{ url('/login') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">
                                Masuk sebagai mahasiswa
                            </a>
                        @else
                            <a href="{{ url('/admin/login') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">
                                Masuk sebagai admin kampus
                            </a>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</body>
</html>