<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Menu Buku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <ul class="list-disc ml-6 space-y-3">
                    @if(auth()->user()->hasPermission('manage_books'))
                        <li>
                            <a href="{{ route('books.manage') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Kelola Buku
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_users'))
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Kelola User
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_fines'))
                        <li>
                            <a href="{{ route('admin.fines') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Kelola Denda
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission('manage_reservations'))
                        <li>
                            <a href="{{ route('admin.reservations') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Kelola Reservasi
                            </a>
                        </li>
                    @endif
                    
                    @if(auth()->user()->hasPermission('manage_books'))
                        <li>
                            <a href="{{ route('admin.peminjaman.index') }}" class="text-gray-800 dark:text-gray-100 hover:underline">
                                Kelola Peminjaman
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
