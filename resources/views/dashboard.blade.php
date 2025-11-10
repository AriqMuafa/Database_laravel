<x-app-layout>
    @vite('resources/css/dashboard.css')
    {{-- 
    Kita gunakan logic @if untuk mengecek hak akses.
    Jika user punya SALAH SATU permission manajemen, kita anggap dia admin/pustakawan.
--}}
    @if (auth()->user()->hasPermission('manage_books') ||
            auth()->user()->hasPermission('manage_fines') ||
            auth()->user()->hasPermission('manage_users') ||
            auth()->user()->hasPermission('manage_reservations'))

        //TAMPILAN ADMIN PUSTAKAWAN

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                {{-- Pesan selamat datang --}}
                <p class="mb-8 text-lg text-gray-900 dark:text-gray-100 text-center">
                    Selamat datang di sistem manajemen perpustakaan
                </p>

                {{-- Kontainer menu --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8">
                    <div class="flex flex-col">
                        {{-- Buku --}}
                        <a href="{{ route('menu.buku') }}"
                            class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition mb-5">
                            <div class="font-semibold text-lg text-center">Buku</div>
                        </a>

                        {{-- Anggota --}}
                        @if (auth()->user()->hasPermission('view_members'))
                            <a href="{{ route('menu.anggota') }}"
                                class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition mb-5">
                                <div class="font-semibold text-lg text-center">Anggota</div>
                            </a>
                        @endif

                        {{-- Manajemen --}}
                        @if (auth()->user()->hasPermission('manage_books') ||
                                auth()->user()->hasPermission('manage_fines') ||
                                auth()->user()->hasPermission('manage_users') ||
                                auth()->user()->hasPermission('manage_reservations'))
                            <a href="{{ route('menu.manajemen') }}"
                                class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition mb-5">
                                <div class="font-semibold text-lg text-center">Manajemen Perpustakaan</div>
                            </a>
                        @endif

                        {{-- Laporan --}}
                        @if (auth()->user()->hasPermission('view_reports'))
                            <a href="{{ route('menu.laporan') }}"
                                class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition">
                                <div class="font-semibold text-lg text-center">Menu Laporan</div>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        //TAMPILAN ANGGOTA DAN GUEST

        {{-- Konten Utama Dashboard "Perpustakaan Digital" --}}
        <div class="dashboard">
            {{-- 
                CATATAN: Pastikan CSS untuk '.dashboard' 
                sudah ada di 'resources/css/app.css'
            --}}

            <div class="dashboard-container">
                {{-- Teks Judul --}}
                <div class="text-container">
                    <h1 class="title">PERPUSTAKAAN DIGITAL</h1>
                    <p class="subtitle">
                        Menjelajahi pengetahuan tanpa batas, kapan pun dan di mana pun
                    </p>
                </div>

                {{-- Kotak Pencarian --}}
                <div class="search-container">
                    <form action="{{ route('books.index') }}" method="GET"
                        style="width: 100%; display: flex; align-items: center; padding-right: 5px;">
                        {{-- Input Pencarian --}}
                        <input type="text" name="search" class="search-input"
                            placeholder="e.g Library and Information" autocomplete="off">

                        {{-- Tombol Cari (Ikon Kaca Pembesar) --}}
                        <button type="submit" style="background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="search-icon"
                                style="width: 50px; height: 50px; color: #4C72AF;" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>


    @endif

</x-app-layout>
