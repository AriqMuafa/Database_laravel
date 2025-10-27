<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            {{-- Dropdown Profil --}}
            <div class="relative inline-block text-left">
                <button id="profileDropdownButton"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-100 hover:bg-gray-50 focus:outline-none">
                    {{ Auth::user()->name }}
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                {{-- Isi Dropdown --}}
                <div id="profileDropdownMenu"
                    class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg z-50">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600">Profile
                        Saya</a>
                    <a href="{{ route('menu.peminjaman') }}"
                        class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600">Peminjaman
                        Saya</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Script Dropdown --}}
        <script>
            const dropdownBtn = document.getElementById('profileDropdownButton');
            const dropdownMenu = document.getElementById('profileDropdownMenu');
            dropdownBtn.addEventListener('click', () => {
                dropdownMenu.classList.toggle('hidden');
            });
        </script>
    </x-slot>

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
                    @if(auth()->user()->hasPermission('view_members'))
                        <a href="{{ route('menu.anggota') }}"
                            class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition mb-5">
                            <div class="font-semibold text-lg text-center">Anggota</div>
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
                            class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition mb-5">
                            <div class="font-semibold text-lg text-center">Manajemen Perpustakaan</div>
                        </a>
                    @endif

                    {{-- Laporan --}}
                    @if(auth()->user()->hasPermission('view_reports'))
                        <a href="{{ route('menu.laporan') }}"
                            class="block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 p-6 rounded-xl shadow transition">
                            <div class="font-semibold text-lg text-center">Menu Laporan</div>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
