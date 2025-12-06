<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-6 p-4 text-green-700 bg-green-100 border border-green-200 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Kontainer Putih Utama --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Header & Pencarian --}}
                <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-medium text-gray-900">Koleksi Pustaka</h3>

                    <form action="{{ route('books.index') }}" method="GET" class="w-full sm:w-1/2 lg:w-1/3">
                        <div class="relative">
                            <input type="text" name="search"
                                class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-full py-2 pl-4 pr-10 shadow-sm transition duration-150 ease-in-out"
                                placeholder="Cari judul, pengarang..." value="{{ request('search') }}">
                            <button type="submit"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Grid Buku --}}
                <div class="p-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 sm:gap-8">
                    @forelse ($books as $book)
                        {{-- Card Item --}}
                        <div
                            class="group flex flex-col bg-white rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100 h-full relative">

                            {{-- 1. GAMBAR BUKU (Clickable ke Detail) --}}
                            <a href="{{ route('books.show', $book->buku_id) }}" class="block relative w-full">
                                {{-- Rasio A5 (13.5 : 20) = aspect-[135/200] --}}
                                <div class="aspect-[135/200] bg-gray-200 overflow-hidden relative">
                                    @if ($book->stok_buku <= 0)
                                        {{-- Overlay Stok Habis --}}
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-10">
                                            <span
                                                class="text-white font-bold text-sm px-3 py-1 bg-red-600 rounded-full shadow-lg transform -rotate-12">
                                                Stok Habis
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Gambar --}}
                                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/150x200' }}"
                                        alt="{{ $book->judul }}" class="w-full h-auto object-cover rounded-md">
                                </div>
                            </a>

                            {{-- 2. INFORMASI BUKU --}}
                            <div class="p-3 flex flex-col flex-grow">
                                {{-- Kategori --}}
                                <div class="text-xs text-blue-500 font-semibold uppercase tracking-wider mb-1">
                                    {{ $book->nama_kategori ?? 'Umum' }}
                                </div>

                                {{-- Judul (Clickable ke Detail) --}}
                                <a href="{{ route('books.show', $book->buku_id) }}" class="block mb-1">
                                    <h3
                                        class="text-sm font-bold text-gray-900 leading-tight line-clamp-2 hover:text-blue-600 transition-colors">
                                        {{ $book->judul }}
                                    </h3>
                                </a>

                                {{-- Pengarang --}}
                                <p class="text-xs text-gray-500 mb-3 truncate">
                                    {{ $book->pengarang }}
                                </p>

                                {{-- Spacer agar tombol selalu di bawah --}}
                                <div class="mt-auto">
                                    {{-- 3. TOMBOL AKSI (Logic Peminjaman) --}}
                                    @if (Auth::check())
                                        <div
                                            class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100">
                                            <div
                                                class="text-xs font-medium {{ $book->stok_buku > 0 ? 'text-green-600' : 'text-red-500' }}">
                                                Stok: {{ $book->stok_buku }}
                                            </div>

                                            @if ($book->stok_buku > 0)
                                                <form action="{{ route('peminjaman.store') }}" method="POST">
                                                    @csrf
                                                    {{-- Input Hidden: ID Buku --}}
                                                    <input type="hidden" name="buku_id" value="{{ $book->buku_id }}">

                                                    {{-- Input Hidden: Tanggal Pinjam (Otomatis Hari Ini) --}}
                                                    <input type="hidden" name="tanggal_pinjam"
                                                        value="{{ date('Y-m-d') }}">

                                                    <button type="submit"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-1.5 px-3 rounded-md transition duration-150 shadow-sm flex items-center"
                                                        onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">
                                                        Pinjam
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled
                                                    class="bg-gray-300 text-gray-500 text-xs font-semibold py-1.5 px-3 rounded-md cursor-not-allowed">
                                                    Habis
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full text-center mt-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold py-1.5 rounded-md transition">
                                            Login untuk Pinjam
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center">
                            <div class="inline-block p-4 rounded-full bg-gray-100 mb-3">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan.</p>
                            @if (request('search'))
                                <p class="text-gray-400 text-sm mt-1">Coba kata kunci lain.</p>
                                <a href="{{ route('books.index') }}"
                                    class="inline-block mt-4 text-blue-500 hover:underline">Reset Pencarian</a>
                            @endif
                        </div>
                    @endforelse
                </div>

                {{-- Pagination (Jika pakai paginate di controller) --}}
                @if (method_exists($books, 'links'))
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $books->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
