<x-app-layout>
    <x-slot name="header">
        <h2
            class="font-bold text-2xl leading-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-blue-800 drop-shadow-md text-center">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>

    <div class="pb-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Sukses (Toast Style) --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="fixed bottom-5 right-5 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-xl flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="ml-4 hover:text-green-200"><svg class="w-4 h-4" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg></button>
                </div>
            @endif

            {{-- HEADER SECTION: Filter & Search --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <form action="{{ route('books.index') }}" method="GET"
                    class="flex flex-col md:flex-row gap-4 justify-between items-center">

                    {{-- Dropdown Kategori (Modern Style) --}}
                    <div class="w-full md:w-1/3 relative">
                        <select name="category" onchange="this.form.submit()"
                            class="w-full appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded-xl focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategori as $cat)
                                <option value="{{ $cat->kategori_id }}"
                                    {{ request('category') == $cat->kategori_id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search Bar (Expanded) --}}
                    <div class="w-full md:w-2/3 relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all"
                            placeholder="Cari judul buku, penulis, atau topik...">

                        @if (request('search') || request('category'))
                            <a href="{{ route('books.index') }}"
                                class="absolute inset-y-2 right-2 px-4 flex items-center text-sm font-medium text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- GRID BUKU --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-12">
                @forelse ($books as $book)
                    <div
                        class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden h-full">

                        {{-- Cover Image --}}
                        <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                            <a href="{{ route('books.show', $book->buku_id) }}" class="block w-full h-full">
                                <img src="{{ $book->cover ? asset('storage/covers/' . $book->cover) : 'https://via.placeholder.com/300x450?text=No+Cover' }}"
                                    alt="{{ $book->judul }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                                {{-- Overlay Stok Habis --}}
                                @if ($book->stok_buku <= 0)
                                    <div
                                        class="absolute inset-0 bg-black/60 backdrop-blur-[2px] flex items-center justify-center">
                                        <span
                                            class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg transform -rotate-6 border-2 border-white">
                                            STOK HABIS
                                        </span>
                                    </div>
                                @endif

                                {{-- Kategori Badge (Top Left) --}}
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="bg-white/90 backdrop-blur-md text-indigo-600 text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm uppercase tracking-wide border border-white/50">
                                        {{ $book->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                </div>
                            </a>
                        </div>

                        {{-- Info Content --}}
                        <div class="p-4 flex flex-col flex-grow">
                            {{-- Judul --}}
                            <a href="{{ route('books.show', $book->buku_id) }}" class="block mb-1">
                                <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 transition-colors"
                                    title="{{ $book->judul }}">
                                    {{ $book->judul }}
                                </h3>
                            </a>

                            {{-- Penulis --}}
                            <p class="text-xs text-gray-500 mb-3">{{ $book->pengarang }}</p>

                            {{-- Divider Spacer --}}
                            <div class="mt-auto pt-3 border-t border-gray-50 flex flex-col gap-2">

                                {{-- Stok Info --}}
                                @php
                                    $stokTersedia =
                                        $book->stok_buku -
                                        ($book->peminjaman->where('status', 'dipinjam')->count() ?? 0) -
                                        ($book->reservasi->where('status', 'menunggu')->count() ?? 0);
                                @endphp
                                <div class="flex justify-between items-center text-xs font-medium text-gray-400">
                                    <span>Tersedia:</span>
                                    <span
                                        class="{{ $stokTersedia > 0 ? 'text-green-600 bg-green-50 px-2 py-0.5 rounded' : 'text-red-500 bg-red-50 px-2 py-0.5 rounded' }}">
                                        {{ $stokTersedia }} / {{ $book->stok_buku }}
                                    </span>
                                </div>

                                {{-- Action Buttons --}}
                                @auth
                                    @if (Auth::user()->anggota)
                                        @if ($stokTersedia > 0)
                                            <form action="{{ route('peminjaman.store') }}" method="POST" class="w-full">
                                                @csrf
                                                <input type="hidden" name="buku_id" value="{{ $book->buku_id }}">
                                                <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                                <button type="submit" onclick="return confirm('Pinjam buku ini?')"
                                                    class="w-full py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all active:scale-95">
                                                    Pinjam
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('reservasi.store', $book->buku_id) }}" method="POST"
                                                class="w-full">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Masuk antrean reservasi?')"
                                                    class="w-full py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold shadow-sm hover:shadow-md transition-all active:scale-95">
                                                    Reservasi
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('profile.edit') }}"
                                            class="block w-full py-2 text-center rounded-lg border border-indigo-200 text-indigo-600 text-xs font-semibold hover:bg-indigo-50 transition-colors">
                                            Lengkapi Profil
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block w-full py-2 text-center rounded-lg bg-gray-100 text-gray-500 text-xs font-semibold hover:bg-gray-200 transition-colors">
                                        Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div
                        class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-gray-300">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1">Tidak ada buku ditemukan</h3>
                        <p class="text-gray-500 text-sm mb-6">Coba ubah kata kunci pencarian atau filter kategori Anda.
                        </p>
                        <a href="{{ route('books.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            Reset Semua Filter
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($books->hasPages())
                <div class="mt-8">
                    {{ $books->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
