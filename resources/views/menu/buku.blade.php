<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Buku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <ul class="list-disc ml-6 space-y-3">
                    @if(auth()->user()->hasPermission('view_books'))
                        <li><a href="{{ route('books.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">Lihat Buku</a></li>
                    @endif
                    @if(auth()->user()->hasPermission('borrow_books'))
                        <li><a href="{{ route('books.borrow') }}" class="text-gray-800 dark:text-gray-100 hover:underline">Pinjam Buku</a></li>
                    @endif
                    @if(auth()->user()->hasPermission('return_books'))
                        <li><a href="{{ route('books.return') }}" class="text-gray-800 dark:text-gray-100 hover:underline">Pengembalian Buku</a></li>
                    @endif
                    @if(auth()->user()->hasPermission('view_fines'))
                        <li><a href="{{ route('fines.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">Lihat Denda</a></li>
                    @endif
                    @if(auth()->user()->hasPermission('reserve_books'))
                        <li><a href="{{ route('reservations.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">Reservasi Buku</a></li>
                    @endif
                    @if(auth()->user()->hasPermission('access_digital_books'))
                        <li><a href="{{ route('digital.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">Akses Buku Digital</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
