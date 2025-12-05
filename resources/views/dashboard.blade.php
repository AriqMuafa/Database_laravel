<x-app-layout>
    {{-- 
      LOGIKA UTAMA:
      1. Jika ADMIN/PUSTAKAWAN -> Tampilkan Dashboard Grid Menu.
      2. Jika MEMBER/GUEST -> Tampilkan Halaman "Hero" Search (Sesuai Desain High-Fi).
    --}}

    {{-- ======================= BAGIAN 1: TAMPILAN ADMIN ======================= --}}
    @if (auth()->user()->hasPermission('manage_books') ||
            auth()->user()->hasPermission('manage_fines') ||
            auth()->user()->hasPermission('manage_users') ||
            auth()->user()->hasPermission('manage_reservations'))

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <p class="mb-8 text-2xl font-semibold text-gray-800 dark:text-gray-100 text-center">
                    Dashboard Manajemen Perpustakaan
                </p>

                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Menu Admin tetap sama (Grid) --}}
                        <a href="{{ route('menu.buku') }}"
                            class="group bg-blue-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center cursor-pointer">
                            <div class="text-4xl mb-3">📘</div>
                            <div class="text-lg font-semibold">Buku</div>
                        </a>

                        @if (auth()->user()->hasPermission('view_members'))
                            <a href="{{ route('menu.anggota') }}"
                                class="group bg-blue-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center cursor-pointer">
                                <div class="text-4xl mb-3">👥</div>
                                <div class="text-lg font-semibold">Anggota</div>
                            </a>
                        @endif

                        @if (auth()->user()->hasPermission('manage_books'))
                            <a href="{{ route('menu.manajemen') }}"
                                class="group bg-blue-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center cursor-pointer">
                                <div class="text-4xl mb-3">🛠️</div>
                                <div class="text-lg font-semibold">Manajemen</div>
                            </a>
                        @endif

                        @if (auth()->user()->hasPermission('view_reports'))
                            <a href="{{ route('menu.laporan') }}"
                                class="group bg-blue-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center cursor-pointer">
                                <div class="text-4xl mb-3">📊</div>
                                <div class="text-lg font-semibold">Laporan</div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================= BAGIAN 2: TAMPILAN MEMBER (HIGH-FI STYLE) ======================= --}}
    @else
        {{-- Container Utama: Menggunakan Background Biru Gradasi --}}
        {{-- Tips: Jika punya gambar pattern, tambahkan class: bg-[url('/img/pattern.png')] --}}
        <div
            class="relative min-h-[calc(100vh-65px)] bg-gradient-to-b from-[#4C72AF] to-[#2B4C85] flex flex-col justify-between">

            {{-- Overlay Pattern (Opsional: Membuat efek tekstur halus) --}}
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;">
            </div>

            {{-- 1. KONTEN TENGAH (HERO) --}}
            <div class="relative z-10 flex flex-col items-center justify-center flex-grow px-4 text-center mt-[-50px]">

                {{-- Judul Besar --}}
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-wide mb-4 uppercase drop-shadow-md">
                    Perpustakaan Digital
                </h1>

                {{-- Subjudul --}}
                <p class="text-white text-lg md:text-xl font-light mb-10 opacity-90 max-w-2xl">
                    Menjelajahi pengetahuan tanpa batas, kapan pun dan di mana pun
                </p>

                {{-- Search Bar Putih Besar --}}
                <div class="w-full max-w-3xl">
                    <form action="{{ route('books.index') }}" method="GET" class="relative w-full">
                        {{-- Input --}}
                        <input type="text" name="search"
                            class="w-full h-16 pl-8 pr-16 rounded-full border-none shadow-xl text-gray-700 text-lg placeholder-gray-400 focus:ring-4 focus:ring-blue-300 transition-all outline-none"
                            placeholder="e.g Library and Information" autocomplete="off">

                        {{-- Ikon Search (Kaca Pembesar) --}}
                        <button type="submit"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 p-2 hover:bg-gray-100 rounded-full transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8 text-[#4C72AF] group-hover:scale-110 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- 2. FOOTER (Sesuai Desain High-Fi) --}}
            <div class="relative z-10 bg-[#1e293b] w-full py-8 border-t border-white/10">
                <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center">

                    {{-- Logo Footer --}}
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('img/digilib.svg') }}" alt="Logo" class="h-8 w-8 brightness-0 invert">
                        <span class="text-2xl font-bold text-white">DigiLib</span>
                    </div>

                    {{-- Link Footer --}}
                    <div class="flex space-x-6 text-gray-300 text-sm font-medium mb-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition">Home</a>
                        <span>|</span>
                        <a href="{{ route('menu.buku') }}" class="hover:text-white transition">Book</a>
                        <span>|</span>
                        <a href="#" class="hover:text-white transition">About Us</a>
                        <span>|</span>
                        <a href="#" class="hover:text-white transition">Contact Us</a>
                    </div>

                    {{-- Copyright --}}
                    <div class="text-gray-500 text-xs">
                        &copy; 2025 by Kelompok 7.
                    </div>
                </div>
            </div>

        </div>
    @endif

</x-app-layout>
