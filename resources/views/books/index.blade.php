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

                {{-- Header: Filter Kategori & Pencarian (Dari Incoming - Lebih Lengkap) --}}
                <div class="p-6 border-b border-gray-200">
                    <form action="{{ route('books.index') }}" method="GET"
                        class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">

                        {{-- Group Filter & Search --}}
                        <div class="flex flex-col sm:flex-row gap-4 w-full">

                            {{-- Dropdown Filter Kategori --}}
                            <div class="w-full sm:w-1/3">
                                <select name="category" id="category"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    onchange="this.form.submit()">
                                    <option value="" @if (!request('category')) selected @endif>Semua
                                        Kategori</option>
                                    @foreach ($kategori as $cat)
                                        <option value="{{ $cat->kategori_id }}"
                                            @if (request('category') == $cat->kategori_id) selected @endif>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Input Pencarian --}}
                            <div class="relative w-full sm:w-2/3">
                                <input type="text" name="search"
                                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md pl-4 pr-10 shadow-sm"
                                    placeholder="Cari judul, pengarang, sinopsis..." value="{{ request('search') }}">

                                <button type="submit"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Tombol Reset (Jika sedang filter/search) --}}
                        @if (request('search') || request('category'))
                            <a href="{{ route('books.index') }}"
                                class="whitespace-nowrap px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 flex items-center shadow-sm transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Grid Buku (Dari Current - Layout Kartu Lengkap) --}}
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
                                        alt="{{ $book->judul }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                </div>
                            </a>

                            {{-- 2. INFORMASI BUKU --}}
                            <div class="p-3 flex flex-col flex-grow">
                                {{-- Kategori --}}
                                <div class="text-xs text-blue-500 font-semibold uppercase tracking-wider mb-1 truncate">
                                    {{ $book->kategori->nama_kategori ?? 'Umum' }}
                                </div>

                                {{-- Judul (Clickable ke Detail) --}}
                                <a href="{{ route('books.show', $book->buku_id) }}" class="block mb-1">
                                    <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-2 hover:text-blue-600 transition-colors"
                                        title="{{ $book->judul }}">
                                        {{ $book->judul }}
                                    </h3>
                                </a>

                                {{-- Pengarang --}}
                                <p class="text-xs text-gray-500 mb-3 truncate">
                                    {{ $book->pengarang }} ({{ $book->tahun_terbit }})
                                </p>

                                {{-- Spacer agar tombol selalu di bawah --}}
                                <div class="mt-auto">

                                    {{-- Info Stok --}}
                                    <div
                                        class="flex items-center justify-between mt-2 pt-2 border-t border-gray-100 mb-2">
                                        @php
                                            // Hitung stok tersedia (total stok dikurangi buku yang sedang dipinjam/di reservasi)
                                            // Asumsi $book->peminjaman dan $book->reservasi adalah relasi yang ada di model Buku
                                            $stokTersedia =
                                                $book->stok_buku -
                                                ($book->peminjaman->where('status', 'dipinjam')->count() ?? 0) -
                                                ($book->reservasi->where('status', 'menunggu')->count() ?? 0);
                                        @endphp
                                        <span
                                            class="text-xs font-medium {{ $stokTersedia > 0 ? 'text-green-600' : 'text-red-500' }}">
                                            Stok: {{ $stokTersedia }} / {{ $book->stok_buku }}
                                        </span>
                                    </div>

                                    {{-- 3. TOMBOL AKSI --}}
                                    @if (Auth::check())
                                        @if (Auth::user()->anggota)
                                            {{-- Stok ADA --}}
                                            @if ($stokTersedia > 0)
                                                <form action="{{ route('peminjaman.store') }}" method="POST"
                                                    class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="buku_id" value="{{ $book->buku_id }}">
                                                    <input type="hidden" name="tanggal_pinjam"
                                                        value="{{ date('Y-m-d') }}">
                                                    <button type="submit"
                                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 px-3 rounded-md transition duration-150 shadow-sm flex items-center justify-center"
                                                        onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">
                                                        Pinjam Sekarang
                                                    </button>
                                                </form>

                                                {{-- Stok HABIS -> Reservasi --}}
                                            @else
                                                <form action="{{ route('reservasi.store', $book->buku_id) }}"
                                                    method="POST" class="w-full"
                                                    onsubmit="return confirm('Anda akan masuk antrean untuk buku ini. Lanjutkan?');">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold py-2 px-3 rounded-md transition duration-150 shadow-sm flex items-center justify-center">
                                                        Reservasi
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            {{-- User Login tapi bukan Anggota --}}
                                            <a href="{{ route('profile.edit') }}"
                                                class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-indigo-600 text-xs font-semibold py-2 rounded-md transition border border-gray-200">
                                                Lengkapi Profil
                                            </a>
                                        @endif
                                    @else
                                        {{-- Belum Login --}}
                                        <a href="{{ route('login') }}"
                                            class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold py-2 rounded-md transition border border-gray-200">
                                            Login untuk Pinjam
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Tampilan Kosong (Dari Incoming - Lebih Informatif) --}}
                        <div class="col-span-full py-16 text-center">
                            <div class="inline-block p-4 rounded-full bg-gray-50 mb-4">
                                <svg class="w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Tidak ada buku ditemukan</h3>
                            <p class="mt-1 text-gray-500 max-w-md mx-auto">
                                @if (request('search') && request('category'))
                                    Kami tidak dapat menemukan buku dengan kata kunci
                                    <strong>"{{ request('search') }}"</strong> di kategori yang dipilih.
                                @elseif(request('search'))
                                    Coba gunakan kata kunci lain atau periksa ejaan Anda.
                                @elseif(request('category'))
                                    Belum ada buku dalam kategori ini.
                                @else
                                    Koleksi pustaka saat ini masih kosong.
                                @endif
                            </p>
                            @if (request('search') || request('category'))
                                <div class="mt-6">
                                    <a href="{{ route('books.index') }}"
                                        class="text-indigo-600 hover:text-indigo-500 font-medium">
                                        Hapus semua filter &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforelse
                </div>

                {{-- Pagination Links (Dari Incoming - Syntax Modern) --}}
                @if ($books->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $books->links() }}
                    </div>
                @endif

            </div> {{-- End Kontainer Putih --}}
        </div>
    </div>
</x-app-layout>
