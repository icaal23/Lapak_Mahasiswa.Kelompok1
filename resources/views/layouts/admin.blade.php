<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Lapak Kampus')</title>
    <!-- Menggunakan Google Fonts Inter agar tipografi bersih dan presisi -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN (Ganti dengan @vite('resources/css/app.css') jika sudah terkonfigurasi) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #EAEAEA; /* Warna latar abu-abu terang sesuai desain */
        }
    </style>
</head>
<body class="text-[#1A1A1A] antialiased">

    <div class="min-h-screen flex">
        
        <!-- SIDEBAR KIRI -->
        <aside class="w-[270px] bg-white border-r border-gray-300 flex flex-col justify-between shrink-0">
            <div>
                <!-- Brand Logo & Admin Pill -->
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-center gap-2.5">
                        <!-- Ganti src dengan logo asli Lapak Kampus Anda -->
                        <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-[#F97316]" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-[19px] font-bold tracking-tight text-[#111827]">Lapak Kampus</span>
                    </div>

                    <!-- Badge Admin -->
                    <div class="flex justify-end mt-1.5 pr-1">
                        <span class="bg-[#FFA45B] text-[#111827] text-[12px] font-bold px-3.5 py-0.5 rounded-full">
                            Admin
                        </span>
                    </div>
                </div>

                <!-- Menu Navigasi -->
                <nav class="px-3.5 mt-2 space-y-2">
                    <!-- Ringkasan (Active State) -->
                    <a href="{{ route('admin.ringkasan') }}" 
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[15px] font-semibold transition-colors
                       {{ request()->routeIs('admin.ringkasan') ? 'bg-[#FDE4D2] text-[#7C3A16]' : 'text-[#737373] hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z"/>
                        </svg>
                        <span>Ringkasan</span>
                    </a>

                    <!-- Kelola barang -->
                    <a href="{{ route('admin.barang.index') }}" 
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[15px] font-semibold transition-colors
                       {{ request()->routeIs('admin.barang.*') ? 'bg-[#FDE4D2] text-[#7C3A16]' : 'text-[#737373] hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="4" width="4" height="4" rx="1"/>
                            <rect x="10" y="4" width="4" height="4" rx="1"/>
                            <rect x="16" y="4" width="4" height="4" rx="1"/>
                            <rect x="4" y="10" width="4" height="4" rx="1"/>
                            <rect x="10" y="10" width="4" height="4" rx="1"/>
                            <rect x="16" y="10" width="4" height="4" rx="1"/>
                            <rect x="4" y="16" width="4" height="4" rx="1"/>
                            <rect x="10" y="16" width="4" height="4" rx="1"/>
                            <rect x="16" y="16" width="4" height="4" rx="1"/>
                        </svg>
                        <span>Kelola barang</span>
                    </a>

                    <!-- Moderasi Barang -->
                    <a href="{{ route('admin.moderasi.index') }}" 
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[15px] font-semibold transition-colors
                       {{ request()->routeIs('admin.moderasi.*') ? 'bg-[#FDE4D2] text-[#7C3A16]' : 'text-[#737373] hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.5-3 8.5-7 9.5-4-1-7-5-7-9.5V7l7-4z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12.5l1.75 1.75L15 10.5"/>
                        </svg>
                        <span>Moderasi Barang</span>
                    </a>

                    <!-- Kelola Pengguna -->
                    <a href="{{ route('admin.pengguna.index') }}" 
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[15px] font-semibold transition-colors
                       {{ request()->routeIs('admin.pengguna.*') ? 'bg-[#FDE4D2] text-[#7C3A16]' : 'text-[#737373] hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1"/>
                            <circle cx="9" cy="7" r="3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 19v-1a4 4 0 00-3-3.87M16 3.13a3 3 0 010 5.75"/>
                        </svg>
                        <span>Kelola Pengguna</span>
                    </a>

                    <!-- Laporan -->
                    <a href="{{ route('admin.laporan.index') }}" 
                       class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-[15px] font-semibold transition-colors
                       {{ request()->routeIs('admin.laporan.*') ? 'bg-[#FDE4D2] text-[#7C3A16]' : 'text-[#737373] hover:bg-gray-100' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v18M5 4h11l-2 4.5L16 13H5"/>
                        </svg>
                        <span>Laporan</span>
                    </a>
                </nav>
            </div>

            <!-- Tombol Keluar di Bagian Bawah -->
            <div class="px-5 pb-6">
                <div class="border-t border-gray-300 pt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-[15px] font-semibold text-[#737373] hover:text-gray-900 transition-colors">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- KONTEN KANAN (HEADER + MAIN) -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- TOP NAVBAR -->
            <header class="h-[78px] border-b border-gray-300 px-8 flex items-center justify-between bg-[#EAEAEA]">
                <!-- Search Bar -->
                <div class="relative w-full max-w-[520px]">
                    <span class="absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7"/>
                            <path stroke-linecap="round" d="M20 20l-3.5-3.5"/>
                        </svg>
                    </span>
                    <input type="text" 
                           placeholder="Cari barang, pengguna, atau laporan..." 
                           class="w-full bg-white border border-gray-300 rounded-full py-2.5 pl-12 pr-5 text-[14px] text-gray-700 placeholder-gray-400 focus:outline-none focus:border-orange-400">
                </div>

                <!-- Notifikasi & Avatar Admin -->
                <div class="flex items-center gap-5">
                    <!-- Lonceng Notifikasi -->
                    <button type="button" class="relative text-gray-600 hover:text-gray-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <!-- Titik Merah Notifikasi -->
                        <span class="absolute top-0.5 right-0.5 block w-2 h-2 rounded-full bg-red-500 ring-1 ring-white"></span>
                    </button>

                    <!-- Lingkaran Inisial AD -->
                    <div class="w-10 h-10 rounded-full bg-[#FFA45B] flex items-center justify-center text-[#111827] font-bold text-[15px] select-none">
                        AD
                    </div>
                </div>
            </header>

            <!-- ISI HALAMAN -->
            <main class="p-8 flex-1">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>
</html>