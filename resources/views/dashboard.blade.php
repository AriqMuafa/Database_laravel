<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="mb-4">{{ __("You're logged in!") }}</p>

                    {{-- Dropdown menu sesuai permission --}}
                    <div class="mt-4">
                        <h3 class="font-bold mb-2">Menu Akses:</h3>
                        <ul class="list-disc ml-5 space-y-1">

                            {{-- 📚 Buku --}}
                            @if(auth()->user()->hasPermission('view_books'))
                                <li><a href="{{ route('books.index') }}" class="text-blue-500">Lihat Buku</a></li>
                            @endif

                            @if(auth()->user()->hasPermission('borrow_books'))
                                <li><a href="{{ route('books.borrow') }}" class="text-blue-500">Pinjam Buku</a></li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_books'))
                                <li><a href="{{ route('books.manage') }}" class="text-blue-500">Kelola Buku</a></li>
                            @endif

                            @if(auth()->user()->hasPermission('return_books'))
                                <li><a href="{{ route('books.return') }}" class="text-blue-500">Pengembalian Buku</a></li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_categories'))
                                <li><a href="{{ route('books.categories') }}" class="text-blue-500">Kelola Kategori Buku</a>
                                </li>
                            @endif


                            {{-- 👥 Anggota / User --}}
                            @if(auth()->user()->hasPermission('view_members'))
                                <li><a href="{{ route('members.index') }}" class="text-blue-500">Lihat Daftar Anggota</a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_users'))
                                <li><a href="{{ route('admin.users.index') }}" class="text-blue-500">Kelola User</a></li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_expired_members'))
                                <li><a href="{{ route('admin.expired') }}" class="text-blue-500">Kelola Anggota
                                        Kadaluarsa</a></li>
                            @endif


                            {{-- 💰 Denda --}}
                            @if(auth()->user()->hasPermission('view_fines'))
                                <li><a href="{{ route('fines.index') }}" class="text-blue-500">Lihat Denda</a></li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_fines'))
                                <li><a href="{{ route('admin.fines') }}" class="text-blue-500">Kelola Denda</a></li>
                            @endif


                            {{-- 📅 Reservasi --}}
                            @if(auth()->user()->hasPermission('reserve_books'))
                                <li><a href="{{ route('reservations.index') }}" class="text-blue-500">Reservasi Buku</a>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission('manage_reservations'))
                                <li><a href="{{ route('admin.reservations') }}" class="text-blue-500">Kelola Reservasi</a>
                                </li>
                            @endif


                            {{-- 📖 Buku Digital --}}
                            @if(auth()->user()->hasPermission('access_digital_books'))
                                <li><a href="{{ route('digital.index') }}" class="text-blue-500">Akses Buku Digital</a></li>
                            @endif


                            {{-- 📊 Laporan --}}
                            @if(auth()->user()->hasPermission('view_reports'))
                                <li><a href="{{ route('admin.reports') }}" class="text-blue-500">Laporan Perpustakaan</a>
                                </li>
                            @endif



                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>