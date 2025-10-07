<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            @if(auth()->user()->hasPermission('manage_roles'))
                <a href="{{ route('roles.index') }}"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition">
                    Kelola Role
                </a>
            @endif
        </div>
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