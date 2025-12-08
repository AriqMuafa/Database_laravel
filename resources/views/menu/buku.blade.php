<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Buku
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-6">

            <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow">

                {{-- GRID MENU --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @auth
                        @if(auth()->user()->hasPermission('view_books'))
                            <a href="{{ route('books.index') }}"
                               class="group p-6 rounded-xl bg-gray-50 dark:bg-gray-700 
                                      shadow hover:shadow-lg transition-all flex flex-col items-center text-center
                                      hover:bg-blue-500 hover:text-white">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition">📚</div>
                                <div class="font-semibold text-lg">Lihat Buku</div>
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('borrow_books'))
                            <a href="{{ route('books.borrow') }}"
                               class="group p-6 rounded-xl bg-gray-50 dark:bg-gray-700 
                                      shadow hover:shadow-lg transition-all flex flex-col items-center text-center
                                      hover:bg-blue-500 hover:text-white">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition">📖</div>
                                <div class="font-semibold text-lg">Pinjam Buku</div>
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('return_books'))
                            <a href="{{ route('books.return') }}"
                               class="group p-6 rounded-xl bg-gray-50 dark:bg-gray-700 
                                      shadow hover:shadow-lg transition-all flex flex-col items-center text-center
                                      hover:bg-blue-500 hover:text-white">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition">🔄</div>
                                <div class="font-semibold text-lg">Pengembalian Buku</div>
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('reserve_books'))
                            <a href="{{ route('reservations.index') }}"
                               class="group p-6 rounded-xl bg-gray-50 dark:bg-gray-700 
                                      shadow hover:shadow-lg transition-all flex flex-col items-center text-center
                                      hover:bg-blue-500 hover:text-white">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition">📌</div>
                                <div class="font-semibold text-lg">Reservasi Buku</div>
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('access_digital_books'))
                            <a href="{{ route('digital.index') }}"
                               class="group p-6 rounded-xl bg-gray-50 dark:bg-gray-700 
                                      shadow hover:shadow-lg transition-all flex flex-col items-center text-center
                                      hover:bg-blue-500 hover:text-white">
                                <div class="text-4xl mb-3 group-hover:scale-110 transition">💻</div>
                                <div class="font-semibold text-lg">Akses Buku Digital</div>
                            </a>
                        @endif
                    @endauth

                    @guest
                        <div class="p-6 rounded-xl bg-gray-50 dark:bg-gray-700 shadow text-center text-gray-700 dark:text-gray-300">
                            Silakan <a href="{{ route('login') }}" class="text-blue-500 underline">login</a>
                            untuk mengakses menu buku.
                        </div>
                    @endguest

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
