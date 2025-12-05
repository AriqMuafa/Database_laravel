<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- 
                LOGIKA PERMISSION:
                Cek apakah user punya salah satu hak akses manajemen.
                Jika YA -> Tampilkan Menu Admin (Grid).
                Jika TIDAK -> Tampilkan Menu Member (Pencarian Buku).
            --}}
            @if (auth()->user()->hasPermission('manage_books') ||
                    auth()->user()->hasPermission('manage_fines') ||
                    auth()->user()->hasPermission('manage_users') ||
                    auth()->user()->hasPermission('manage_reservations'))

                {{-- ======================= TAMPILAN ADMIN/PUSTAKAWAN ======================= --}}

                <p class="mb-8 text-2xl font-semibold text-gray-900 dark:text-gray-100 text-center">
                    Dashboard Manajemen Perpustakaan
                </p>

                <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        {{-- Menu 1: Buku --}}
                        <a href="{{ route('menu.buku') }}"
                            class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100 cursor-pointer">
                            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200">
                                📘
                            </div>
                            <div class="text-lg font-semibold">Buku</div>
                        </a>

                        {{-- Menu 2: Anggota (Jika punya izin) --}}
                        @if (auth()->user()->hasPermission('view_members'))
                            <a href="{{ route('menu.anggota') }}"
                                class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100 cursor-pointer">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200">
                                    🧑‍🤝‍🧑
                                </div>
                                <div class="text-lg font-semibold">Anggota</div>
                            </a>
                        @endif

                        {{-- Menu 3: Manajemen (Jika punya izin) --}}
                        @if (auth()->user()->hasPermission('manage_books') ||
                                auth()->user()->hasPermission('manage_fines') ||
                                auth()->user()->hasPermission('manage_users') ||
                                auth()->user()->hasPermission('manage_reservations'))
                            <a href="{{ route('menu.manajemen') }}"
                                class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100 cursor-pointer">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200">
                                    🛠️
                                </div>
                                <div class="text-lg font-semibold">Manajemen</div>
                            </a>
                        @endif

                        {{-- Menu 4: Laporan (Jika punya izin) --}}
                        @if (auth()->user()->hasPermission('view_reports'))
                            <a href="{{ route('menu.laporan') }}"
                                class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-600 hover:text-white transition-all duration-200 p-6 rounded-xl shadow-sm hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100 cursor-pointer">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200">
                                    📊
                                </div>
                                <div class="text-lg font-semibold">Laporan</div>
                            </a>
                        @endif

                    </div>
                </div>
            @else
                {{-- ======================= TAMPILAN MEMBER/GUEST ======================= --}}

                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg min-h-[400px] flex flex-col justify-center items-center p-6 text-center">

                    {{-- Judul Hero --}}
                    <h1 class="text-4xl font-extrabold text-blue-600 dark:text-blue-400 tracking-tight mb-2">
                        PERPUSTAKAAN DIGITAL
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-8 max-w-2xl">
                        Menjelajahi pengetahuan tanpa batas, kapan pun dan di mana pun.
                    </p>

                    {{-- Search Box Modern (Tailwind) --}}
                    <div class="w-full max-w-2xl">
                        <form action="{{ route('books.index') }}" method="GET" class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-6 h-6 text-gray-400 group-focus-within:text-blue-500 transition"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <input type="text" name="search"
                                class="block w-full p-4 pl-12 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 shadow-sm transition-all hover:shadow-md"
                                placeholder="Cari judul buku, penulis, atau topik..." autocomplete="off" required>

                            <button type="submit"
                                class="absolute right-2.5 bottom-2.5 bg-blue-600 hover:bg-blue-700 text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm px-6 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                                Cari
                            </button>
                        </form>
                    </div>

                </div>

            @endif
        </div>
    </div>
</x-app-layout>
