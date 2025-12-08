<x-app-layout>
    {{-- 
      LOGIKA UTAMA:
      1. Jika ADMIN/PUSTAKAWAN -> Tampilkan Dashboard Grid Menu.
      2. Jika MEMBER/GUEST -> Tampilkan Halaman "Hero" Search (Sesuai Desain High-Fi).
    --}}

    {{-- ======================= BAGIAN 1: TAMPILAN ADMIN ======================= --}}
    @if (auth()->check() &&
            (auth()->user()->hasPermission('manage_books') ||
                auth()->user()->hasPermission('manage_fines') ||
                auth()->user()->hasPermission('manage_users') ||
                auth()->user()->hasPermission('manage_reservations')))

        <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                {{-- Header Admin --}}
                <div class="mb-10 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                        Dashboard Manajemen
                    </h2>
                    <p class="text-gray-500 mt-2">Selamat datang kembali, {{ auth()->user()->name }} 👋</p>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        {{-- Menu Admin: Buku --}}
                        <a href="{{ route('menu.buku') }}"
                            class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                            <div
                                class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">
                                📘</div>
                            <h3
                                class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-blue-600 transition-colors">
                                Data Buku</h3>
                            <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Kelola katalog pustaka</p>
                        </a>

                        {{-- Menu Admin: Anggota --}}
                        @if (auth()->check() && auth()->user()->hasPermission('view_members'))
                            <a href="{{ route('menu.anggota') }}"
                                class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-green-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">
                                    👥</div>
                                <h3
                                    class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-green-600 transition-colors">
                                    Anggota</h3>
                                <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Data user & member</p>
                            </a>
                        @endif

                        {{-- Menu Admin: Manajemen --}}
                        @if (auth()->check() && auth()->user()->hasPermission('manage_books'))
                            <a href="{{ route('menu.manajemen') }}"
                                class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-orange-500 dark:hover:border-orange-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">
                                    🛠️</div>
                                <h3
                                    class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-orange-600 transition-colors">
                                    Utilitas</h3>
                                <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Pengaturan sistem</p>
                            </a>
                        @endif

                        {{-- Menu Admin: Laporan --}}
                        @if (auth()->check() && auth()->user()->hasPermission('view_reports'))
                            <a href="{{ route('menu.laporan') }}"
                                class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-purple-500 dark:hover:border-purple-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">
                                    📊</div>
                                <h3
                                    class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-purple-600 transition-colors">
                                    Laporan</h3>
                                <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Statistik peminjaman</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================= BAGIAN 2: TAMPILAN MEMBER (GRADIENT & GRID PATTERN) ======================= --}}
    @else
        <div
            class="relative min-h-[calc(100vh-65px)] w-full bg-gradient-to-b from-[#4C72AF] to-[#213555] font-sans flex flex-col justify-between overflow-x-hidden">

            {{-- 1. TEXTURE BACKGROUND --}}
            {{-- Layer ini berada di atas gradient tapi di bawah konten --}}
            {{-- Menggunakan mix-blend-overlay agar tekstur menyatu dengan warna biru --}}
            <div class="absolute inset-0 opacity-20 z-0 pointer-events-none mix-blend-overlay"
                style="background-image: url('{{ asset('img/texture3.svg') }}'); 
                       background-repeat: repeat; 
                       background-size: 900px;">
            </div>

            {{-- 2. HERO SECTION (Konten Tengah) --}}
            <div class="relative z-10 flex-grow flex flex-col items-center pt-24 px-4 sm:px-6 lg:px-8">

                {{-- Badge Kecil --}}
                <div
                    class="mb-8 inline-flex items-center px-4 py-1.5 rounded-full border border-blue-100 bg-white/80 backdrop-blur-sm text-blue-600 text-sm font-semibold shadow-sm animate-fade-in-up hover:shadow-md transition-all cursor-default">
                    <span class="flex h-2 w-2 relative mr-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Selamat Datang di DigiLib
                </div>

                {{-- Judul Besar --}}
                <h1
                    class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-50 to-blue-200 tracking-tight mb-6 text-center drop-shadow-md max-w-4xl leading-tight">

                    Jelajahi Dunia Lewat <br>

                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-blue-50 drop-shadow-md">Buku

                        Digital</span>

                </h1>

                {{-- Subjudul --}}
                <p class="text-white text-lg md:text-xl font-light text-center mb-16 max-w-2xl mx-auto">
                    Menjelajahi pengetahuan tanpa batas, kapan pun dan di mana pun
                </p>

                {{-- Search Bar (Bentuk Pill / Lonjong) --}}
                <div class="w-full max-w-4xl mb-40">
                    <form action="{{ route('books.index') }}" method="GET" class="relative">
                        <input type="text" name="search"
                            class="w-full h-16 pl-8 pr-16 rounded-full border-none shadow-2xl text-gray-700 text-lg placeholder-gray-400 focus:ring-4 focus:ring-blue-300/50 transition-all outline-none"
                            placeholder="Cari buku, penulis, atau topik..." autocomplete="off">

                        <button type="submit"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- KATEGORI GRID (Floating Glass Cards) --}}
                <div class="w-full max-w-6xl px-4">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-[1px] flex-grow bg-gradient-to-r from-transparent via-slate-300 to-transparent">
                        </div>
                        <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">Kategori Populer</span>
                        <div class="h-[1px] flex-grow bg-gradient-to-r from-transparent via-slate-300 to-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">

                        {{-- Card 1: Fiksi Ilmiah --}}
                        <a href="{{ route('books.index', ['category' => 'Fiksi Ilmiah']) }}"
                            class="group relative h-64 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 cursor-pointer">
                            {{-- Background Image --}}
                            <div class="absolute inset-0">
                                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=600"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0"
                                    alt="Sci-Fi">
                            </div>
                            {{-- Gradient Overlay --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-90 group-hover:opacity-70 transition-opacity">
                            </div>
                            {{-- Content --}}
                            <div
                                class="absolute bottom-0 left-0 p-8 w-full translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <div
                                    class="w-10 h-1 bg-blue-500 mb-4 rounded-full w-0 group-hover:w-10 transition-all duration-500">
                                </div>
                                <h3 class="text-white text-2xl font-bold mb-1">Fiksi Ilmiah</h3>
                                <p
                                    class="text-gray-300 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Masa depan & imajinasi</p>
                            </div>
                        </a>

                        {{-- Card 2: Novel Sejarah --}}
                        <a href="{{ route('books.index', ['category' => 'Novel Sejarah']) }}"
                            class="group relative h-64 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 cursor-pointer">
                            <div class="absolute inset-0">
                                <img src="https://images.unsplash.com/photo-1461360370896-922624d12aa1?auto=format&fit=crop&q=80&w=600"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0"
                                    alt="History">
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-90 group-hover:opacity-70 transition-opacity">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 p-8 w-full translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <div
                                    class="w-10 h-1 bg-yellow-500 mb-4 rounded-full w-0 group-hover:w-10 transition-all duration-500">
                                </div>
                                <h3 class="text-white text-2xl font-bold mb-1">Novel Sejarah</h3>
                                <p
                                    class="text-gray-300 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Lorong waktu masa lalu</p>
                            </div>
                        </a>

                        {{-- Card 3: Teknologi --}}
                        <a href="{{ route('books.index', ['category' => 'Teknologi']) }}"
                            class="group relative h-64 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 cursor-pointer">
                            <div class="absolute inset-0">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=600"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 grayscale group-hover:grayscale-0"
                                    alt="Tech">
                            </div>
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-90 group-hover:opacity-70 transition-opacity">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 p-8 w-full translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <div
                                    class="w-10 h-1 bg-green-500 mb-4 rounded-full w-0 group-hover:w-10 transition-all duration-500">
                                </div>
                                <h3 class="text-white text-2xl font-bold mb-1">Teknologi</h3>
                                <p
                                    class="text-gray-300 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    Inovasi dunia digital</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            {{-- 3. FOOTER (Warna Gelap di Bawah) --}}
            <footer class="relative z-10 bg-[#1A202C] text-white py-10 border-t border-white/10 mt-auto">
                <div class="max-w-7xl mx-auto px-4 flex flex-col items-center">

                    {{-- Logo --}}
                    <div class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('img/digilib.svg') }}" alt="Logo" class="h-8 w-8 brightness-0 invert"
                            onerror="this.style.display='none'">
                        <span class="text-2xl font-bold tracking-wider">DigiLib</span>
                    </div>

                    {{-- Links --}}
                    <div class="flex flex-wrap justify-center gap-8 text-gray-400 text-sm font-medium mb-8">
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition">Home</a>
                        <a href="{{ route('menu.buku') }}" class="hover:text-white transition">Book</a>
                        <a href="#" class="hover:text-white transition">About Us</a>
                        <a href="#" class="hover:text-white transition">Contact Us</a>
                    </div>

                    {{-- Copyright --}}
                    <div class="text-gray-500 text-xs">
                        &copy; 2025 by Kelompok 7. All rights reserved.
                    </div>
                </div>
            </footer>

        </div>
    @endif
</x-app-layout>
