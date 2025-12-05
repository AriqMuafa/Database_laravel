<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Kontainer Putih Utama --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Fitur Pencarian dan Filter (di dalam kontainer putih) --}}
                <div class="p-6 border-b border-gray-200">
                    <form action="{{ route('books.index') }}" method="GET" class="space-y-4">
                        
                        {{-- Dropdown Filter Kategori (NEW BLOCK) --}}
                        <div class="flex items-center space-x-4">
                            <label for="category" class="text-gray-700 font-medium whitespace-nowrap">Filter Kategori:</label>
                            <select name="category" id="category" 
                                class="w-full sm:w-1/3 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                
                                {{-- Opsi default untuk menampilkan semua --}}
                                <option value="" @if (!request('category')) selected @endif>Semua Kategori</option>
                                
                                {{-- Loop untuk menampilkan kategori dari Controller --}}
                                @foreach ($kategori as $cat)
                                    <option value="{{ $cat->kategori_id }}" 
                                        @if (request('category') == $cat->kategori_id) selected @endif>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Input Pencarian --}}
                        <div class="flex">
                            <input type="text" name="search"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-l-md shadow-sm"
                                placeholder="Cari Buku (Judul, Pengarang, Sinopsis)..." value="{{ request('search') }}">
                            
                            {{-- Tombol Submit --}}
                            <button type="submit"
                                class="px-5 py-2 bg-indigo-600 border border-l-0 border-indigo-600 text-white font-semibold rounded-r-md hover:bg-indigo-700 transition duration-150 ease-in-out">
                                Terapkan Filter
                            </button>
                            
                            {{-- Tombol Reset Pencarian dan Filter (Jika ada salah satu yang aktif) --}}
                            @if (request('search') || request('category'))
                                <a href="{{ route('books.index') }}" class="ml-2 px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 flex items-center shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Grid Kartu Buku --}}
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($books as $book)
                        {{-- Kartu --}}
                        <div
                            class="border border-gray-200 rounded-lg overflow-hidden flex flex-col justify-between shadow-md hover:shadow-lg transition duration-300 ease-in-out">
                            <div>
                                {{-- Gambar Placeholder --}}
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center relative">
                                    <span class="text-gray-500">Cover Buku</span>
                                    {{-- Kategori Label --}}
                                    <span class="absolute top-2 right-2 bg-indigo-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-md">
                                        {{ $book->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                    </span>
                                </div>

                                {{-- Konten Kartu --}}
                                <div class="p-5">
                                    <h3 class="font-bold text-xl text-gray-900 line-clamp-2 h-14"
                                        title="{{ $book->judul }}">
                                        {{ $book->judul }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">Oleh: {{ $book->pengarang }} ({{ $book->tahun_terbit }})</p>

                                    {{-- Sinopsis --}}
                                    <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                                        {{ $book->sinopsis }}
                                    </p>
                                </div>
                            </div>

                            {{-- Footer Kartu --}}
                            <div class="p-5 pt-0 flex justify-between items-center">
                                @php
                                    // Hitung stok tersedia (total stok dikurangi buku yang sedang dipinjam/di reservasi)
                                    // Asumsi $book->peminjaman dan $book->reservasi adalah relasi yang ada di model Buku
                                    $stokTersedia = $book->stok_buku - ($book->peminjaman->where('status', 'dipinjam')->count() ?? 0) - ($book->reservasi->where('status', 'menunggu')->count() ?? 0);
                                @endphp
                                <span class="text-sm font-bold @if($stokTersedia > 0) text-green-600 @else text-red-600 @endif">
                                    Stok: {{ $stokTersedia }} / {{ $book->stok_buku }}
                                </span>

                                <div>
                                    @if (Auth::user()->anggota)
                                        {{-- Stok ADA, tombol nonaktif (Tidak bisa reservasi jika stok ada) --}}
                                        @if ($stokTersedia > 0)
                                            <button
                                                class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded text-xs cursor-not-allowed shadow-inner"
                                                disabled>
                                                Stok Tersedia
                                            </button>
                                        {{-- Stok KOSONG, tombol Reservasi aktif --}}
                                        @else
                                            <form action="{{ route('reservasi.store', $book->buku_id) }}" method="POST"
                                                onsubmit="return confirm('Anda akan masuk antrean untuk buku ini. Lanjutkan?');">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-xs shadow-lg transition duration-150">
                                                    Reservasi
                                                </button>
                                            </form>
                                        @endif

                                    {{-- Belum jadi anggota --}}
                                    @else
                                        <a href="{{ route('profile.edit') }}" class="text-indigo-500 hover:text-indigo-600 text-xs font-semibold underline">
                                            Lengkapi Profil
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Tampilan jika tidak ada buku --}}
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center text-gray-500 py-16">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2 text-lg font-medium text-gray-900">
                                Tidak ada buku ditemukan.
                            </p>
                            <p class="mt-1 text-base text-gray-500">
                                @if(request('search') && request('category'))
                                    Buku tidak ditemukan untuk kata kunci **{{ request('search') }}** di kategori yang dipilih.
                                @elseif(request('search'))
                                    Coba ubah kata kunci pencarian Anda: **{{ request('search') }}**.
                                @elseif(request('category'))
                                    Tidak ada buku dalam kategori ini.
                                @else
                                    Belum ada buku yang tersedia.
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination Links --}}
                @if ($books->hasPages())
                    <div class="p-6 border-t border-gray-200">
                        {{ $books->links() }}
                    </div>
                @endif

            </div> {{-- End Kontainer Putih Utama --}}
        </div>
    </div>
</x-app-layout>