<x-app-layout>
    {{-- 
      LOGIKA UTAMA:
      1. Jika ADMIN/PUSTAKAWAN -> Tampilkan Dashboard Grid Menu.
      2. Jika MEMBER/GUEST -> Tampilkan Halaman "Hero" Search (Sesuai Desain High-Fi).
    --}}

    {{-- ======================= BAGIAN 1: TAMPILAN ADMIN ======================= --}}
    @if (auth()->check() && (
        auth()->user()->hasPermission('manage_books') ||
        auth()->user()->hasPermission('manage_fines') ||
        auth()->user()->hasPermission('manage_users') ||
        auth()->user()->hasPermission('manage_reservations')
    ))

        <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Header Admin --}}
                <div class="mb-10 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                        Dashboard Manajemen
                    </h2>
                    <p class="text-gray-500 mt-2">Selamat datang kembali, {{ auth()->user()->name }} 👋</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        
                        {{-- Menu Admin: Buku --}}
                        <a href="{{ route('menu.buku') }}"
                            class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-blue-500 dark:hover:border-blue-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                            <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">📘</div>
                            <h3 class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-blue-600 transition-colors">Data Buku</h3>
                            <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Kelola katalog pustaka</p>
                        </a>

                        {{-- Menu Admin: Anggota --}}
                        @if (auth()->check() && auth()->user()->hasPermission('view_members'))
                            <a href="{{ route('menu.anggota') }}"
                                class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                <div class="absolute inset-0 bg-green-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">👥</div>
                                <h3 class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-green-600 transition-colors">Anggota</h3>
                                <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Data user & member</p>
                            </a>
                        @endif

                        {{-- Menu Admin: Manajemen --}}
                        @if (auth()->check() && auth()->user()->hasPermission('manage_books'))
                            <a href="{{ route('menu.manajemen') }}"
                                class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-orange-500 dark:hover:border-orange-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                <div class="absolute inset-0 bg-orange-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">🛠️</div>
                                <h3 class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-orange-600 transition-colors">Utilitas</h3>
                                <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Pengaturan sistem</p>
                            </a>
                        @endif

                        {{-- Menu Admin: Laporan --}}
                        @if (auth()->check() && auth()->user()->hasPermission('view_reports'))
                            <a href="{{ route('menu.laporan') }}"
                                class="group relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 hover:border-purple-500 dark:hover:border-purple-400 p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center cursor-pointer overflow-hidden">
                                <div class="absolute inset-0 bg-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative z-10 text-5xl mb-4 transform group-hover:scale-110 transition-transform duration-300">📊</div>
                                <h3 class="relative z-10 text-lg font-bold text-gray-700 dark:text-gray-200 group-hover:text-purple-600 transition-colors">Laporan</h3>
                                <p class="relative z-10 text-xs text-gray-400 mt-2 text-center">Statistik peminjaman</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    {{-- ======================= BAGIAN 2: TAMPILAN MEMBER (GRADIENT & GRID PATTERN) ======================= --}}
    @else
        {{-- Container Utama: Background Gradient Biru --}}
        {{-- Menggunakan bg-gradient-to-br (Bottom Right) dari biru agak terang ke biru utama Anda --}}
        <div class="relative min-h-[calc(100vh-65px)] bg-gradient-to-br from-[#5fa0eb] to-[#3C64A3] flex flex-col justify-between text-white overflow-hidden font-sans">

            {{-- BACKGROUND PATTERN: GRID (KOTAK-KOTAK) --}}
            {{-- Menggantikan titik-titik dengan garis grid putih tipis (opacity rendah) --}}
            <div class="absolute inset-0 pointer-events-none"
                style="background-image: 
                    linear-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px), 
                    linear-gradient(90deg, rgba(255, 255, 255, 0.1) 1px, transparent 1px); 
                    background-size: 50px 50px;">
            </div>

            {{-- Efek Cahaya (Glow) Tambahan di Pojok (Opsional, mempercantik gradasi) --}}
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-white/5 to-transparent pointer-events-none"></div>

            {{-- 1. KONTEN TENGAH (HERO) --}}
            <div class="relative z-10 flex flex-col items-center justify-start pt-16 flex-grow px-4 text-center">

                {{-- Judul Besar --}}
                <h1 class="text-4xl md:text-5xl font-bold tracking-wide mb-4 drop-shadow-lg uppercase">
                    Perpustakaan Digital
                </h1>

                {{-- Subjudul --}}
                <p class="text-blue-50 text-lg md:text-xl font-light mb-10 opacity-95 max-w-2xl drop-shadow-sm">
                    Menjelajahi pengetahuan tanpa batas, kapan pun dan di mana pun
                </p>

                {{-- Search Bar Putih --}}
                <div class="w-full max-w-3xl mb-16">
                    <form action="{{ route('books.index') }}" method="GET" class="relative w-full">
                        <input type="text" name="search"
                            class="w-full h-16 pl-8 pr-16 rounded-full border-none shadow-xl text-gray-700 text-lg placeholder-gray-400 focus:ring-4 focus:ring-white/30 transition-all outline-none"
                            placeholder="Cari buku, penulis, atau topik..." autocomplete="off">
                        
                        <button type="submit"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-blue-50 rounded-full transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#3C64A3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- Kategori Populer (3 Kategori dengan Gambar) --}}
                <div class="w-full max-w-5xl text-left">
                    <h3 class="text-xl font-semibold mb-4 ml-1 drop-shadow-md">Kategori Populer</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Kartu 1: Fiksi Ilmiah --}}
                        <a href="{{ route('books.index', ['category' => 'Fiksi Ilmiah']) }}" class="group bg-white rounded-2xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 cursor-pointer border border-white/20">
                            <div class="overflow-hidden rounded-xl h-48 mb-4 bg-gray-200 relative">
                                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=400" 
                                     alt="Fiksi Ilmiah" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-blue-900/10 group-hover:bg-transparent transition-colors"></div>
                            </div>
                            <h4 class="text-gray-800 text-center font-bold text-lg group-hover:text-[#3C64A3] transition-colors">Fiksi Ilmiah</h4>
                        </a>

                        {{-- Kartu 2: Novel Sejarah --}}
                        <a href="{{ route('books.index', ['category' => 'Novel Sejarah']) }}" class="group bg-white rounded-2xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 cursor-pointer border border-white/20">
                            <div class="overflow-hidden rounded-xl h-48 mb-4 bg-gray-200 relative">
                                <img src="https://images.unsplash.com/photo-1461360370896-922624d12aa1?auto=format&fit=crop&q=80&w=400" 
                                     alt="Novel Sejarah" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-blue-900/10 group-hover:bg-transparent transition-colors"></div>
                            </div>
                            <h4 class="text-gray-800 text-center font-bold text-lg group-hover:text-[#3C64A3] transition-colors">Novel Sejarah</h4>
                        </a>

                        {{-- Kartu 3: Teknologi --}}
                        <a href="{{ route('books.index', ['category' => 'Teknologi']) }}" class="group bg-white rounded-2xl p-4 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 cursor-pointer border border-white/20">
                            <div class="overflow-hidden rounded-xl h-48 mb-4 bg-gray-200 relative">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=400" 
                                     alt="Teknologi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-blue-900/10 group-hover:bg-transparent transition-colors"></div>
                            </div>
                            <h4 class="text-gray-800 text-center font-bold text-lg group-hover:text-[#3C64A3] transition-colors">Teknologi</h4>
                        </a>
                    </div>
                </div>
            </div>

            {{-- 2. FOOTER --}}
            <div class="relative z-10 bg-[#1e293b] w-full py-8 border-t-4 border-blue-500 mt-20">
                <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center">
                    <div class="flex items-center gap-2 mb-4">
                        {{-- Pastikan file SVG ada, jika tidak, teks tetap muncul --}}
                        <img src="{{ asset('img/digilib.svg') }}" alt="Logo" class="h-8 w-8 brightness-0 invert opacity-80" onerror="this.style.display='none'">
                        <span class="text-2xl font-bold text-white tracking-wider">DigiLib</span>
                    </div>  
                    <div class="flex space-x-6 text-gray-400 text-sm font-medium mb-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-white hover:underline transition">Home</a>
                        <a href="{{ route('menu.buku') }}" class="hover:text-white hover:underline transition">Book</a>
                        <a href="#" class="hover:text-white hover:underline transition">About Us</a>
                        <a href="#" class="hover:text-white hover:underline transition">Contact Us</a>
                    </div>
                    <div class="text-gray-500 text-xs">
                        &copy; 2025 by Kelompok 7. All rights reserved.
                    </div>
                </div>
            </div>

        </div>
    @endif
</x-app-layout>