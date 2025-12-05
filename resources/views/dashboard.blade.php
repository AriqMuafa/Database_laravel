<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Selamat Datang --}}
            <p class="mb-10 text-2xl font-semibold text-gray-900 dark:text-gray-100 text-center">
                Selamat Datang di Sistem Manajemen Perpustakaan!
            </p>

            {{-- Container Card Menu --}}
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg p-10">
                
                {{-- Grid menu --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- Buku --}}
                    <a href="{{ route('menu.buku') }}"
                        class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-500 hover:text-white transition-all duration-200 p-6 rounded-xl shadow hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100">

                        <div class="text-4xl mb-3 group-hover:scale-110 transition">
                            📘
                        </div>
                        <div class="text-lg font-semibold">Buku</div>
                    </a>

                    {{-- Anggota --}}
                    @if(auth()->user()->hasPermission('view_members'))
                        <a href="{{ route('menu.anggota') }}"
                            class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-500 hover:text-white transition-all duration-200 p-6 rounded-xl shadow hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100">

                            <div class="text-4xl mb-3 group-hover:scale-110 transition">
                                🧑‍🤝‍🧑
                            </div>
                            <div class="text-lg font-semibold">Anggota</div>
                        </a>
                    @endif

                    {{-- Manajemen --}}
                    @if(
                        auth()->user()->hasPermission('manage_books') ||
                        auth()->user()->hasPermission('manage_fines') ||
                        auth()->user()->hasPermission('manage_users') ||
                        auth()->user()->hasPermission('manage_reservations')
                    )
                        <a href="{{ route('menu.manajemen') }}"
                            class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-500 hover:text-white transition-all duration-200 p-6 rounded-xl shadow hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100">

                            <div class="text-4xl mb-3 group-hover:scale-110 transition">
                                🛠️
                            </div>
                            <div class="text-lg font-semibold">Manajemen Perpustakaan</div>
                        </a>
                    @endif

                    {{-- Laporan --}}
                    @if(auth()->user()->hasPermission('view_reports'))
                        <a href="{{ route('menu.laporan') }}"
                            class="group bg-gray-50 dark:bg-gray-700 hover:bg-blue-500 hover:text-white transition-all duration-200 p-6 rounded-xl shadow hover:shadow-lg flex flex-col items-center text-gray-900 dark:text-gray-100">

                            <div class="text-4xl mb-3 group-hover:scale-110 transition">
                                📊
                            </div>
                            <div class="text-lg font-semibold">Menu Laporan</div>
                        </a>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
