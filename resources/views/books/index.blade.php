<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    {{-- Latar belakang halaman disetel ke abu-abu muda, seperti di app.blade.php --}}
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

                {{-- Fitur Pencarian (di dalam kontainer putih) --}}
                <div class="p-6 border-b border-gray-200">
                    <form action="{{ route('books.index') }}" method="GET">
                        <div class="flex">
                            <input type="text" name="search"
                                class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-l-md shadow-sm"
                                placeholder="Cari Buku..." value="{{ request('search') }}">
                            
                            {{-- Tombol Cari --}}
                            <button type="submit"
                                class="px-5 py-2 bg-white border border-l-0 border-gray-300 text-blue-600 font-semibold rounded-r-md hover:bg-gray-50 transition duration-150 ease-in-out">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Grid Kartu Buku --}}
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($books as $book)
                        {{-- Kartu --}}
                        <div
                            class="border border-gray-200 rounded-lg overflow-hidden flex flex-col justify-between shadow-sm">
                            <div>
                                {{-- Gambar Placeholder --}}
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">Cover Buku</span>
                                </div>

                                {{-- Konten Kartu --}}
                                <div class="p-5">
                                    <h3 class="font-semibold text-lg text-gray-900 truncate"
                                        title="{{ $book->judul }}">
                                        {{ $book->judul }}
                                    </h3>
                                    <p class="text-sm text-gray-500">{{ $book->pengarang }}</p>

                                    {{-- Sinopsis --}}
                                    <p class="mt-3 text-sm text-gray-600">
                                        {{ \Illuminate\Support\Str::limit($book->sinopsis, 100, '...') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Footer Kartu --}}
                            <div class="p-5 pt-0 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500">
                                    Stok: {{ $book->stok_buku }}
                                </span>

                                <div>
                                    @if (Auth::user()->anggota)

                                        {{-- Stok ADA, tombol nonaktif --}}
                                        @if ($book->stok_buku > 0)
                                            <button
                                                class="bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded text-xs cursor-not-allowed"
                                                disabled>
                                                Reservasi
                                            </button>
                                        {{-- Stok KOSONG, tombol aktif --}}
                                        @else
                                            <form action="{{ route('reservasi.store', $book->buku_id) }}" method="POST"
                                                onsubmit="return confirm('Anda akan masuk antrean untuk buku ini. Lanjutkan?');">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-xs">
                                                    Reservasi
                                                </button>
                                            </form>
                                        @endif

                                    {{-- Belum jadi anggota --}}
                                    @else
                                        <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:text-blue-600 text-xs font-semibold">
                                            Lengkapi Profil
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Tampilan jika tidak ada buku --}}
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center text-gray-500 py-16">
                            Belum ada buku yang tersedia.
                        </div>
                    @endforelse
                </div>
            </div> {{-- End Kontainer Putih Utama --}}
        </div>
    </div>
</x-app-layout>