<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header Form & Tombol Hapus --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Edit Data Buku: <span
                                class="text-blue-500">{{ $book->judul }}</span></h3>

                        {{-- Tombol Hapus Cepat --}}
                        <form action="{{ route('books.destroy', $book->buku_id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:text-red-800 text-sm font-semibold hover:underline">
                                Hapus Buku Ini
                            </button>
                        </form>
                    </div>

                    {{-- Menampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div
                            class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900 dark:border-red-700 dark:text-red-200">
                            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM EDIT --}}
                    <form action="{{ route('books.update', $book->buku_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1. Judul --}}
                        <div class="mb-4">
                            <label for="judul"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Judul
                                Buku:</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $book->judul) }}"
                                class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        {{-- 2. Cover Buku --}}
                        <div class="mb-4 border p-4 rounded-lg border-gray-200 dark:border-gray-700">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Cover
                                Buku:</label>
                            @if ($book->cover)
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cover Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover Lama"
                                        class="w-32 h-auto rounded shadow-sm border border-gray-300 dark:border-gray-600">
                                </div>
                            @else
                                <div class="mb-3">
                                    <p class="text-xs text-gray-500 italic">Belum ada cover.</p>
                                </div>
                            @endif
                            <input type="file" name="cover" id="cover"
                                accept="image/png, image/jpeg, image/jpg"
                                class="block w-full text-sm text-gray-500 dark:text-gray-300
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                dark:file:bg-gray-600 dark:file:text-gray-200">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG. Max: 2MB.</p>
                        </div>

                        {{-- 3. Pengarang --}}
                        <div class="mb-4">
                            <label for="pengarang"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pengarang:</label>
                            <input type="text" name="pengarang" id="pengarang"
                                value="{{ old('pengarang', $book->pengarang) }}"
                                class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        {{-- 4. Penerbit (BARU DITAMBAHKAN) --}}
                        <div class="mb-4">
                            <label for="penerbit"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Penerbit:</label>
                            <input type="text" name="penerbit" id="penerbit"
                                value="{{ old('penerbit', $book->penerbit) }}"
                                class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        {{-- 5. Tahun Terbit & Kategori --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="tahun_terbit"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tahun
                                    Terbit:</label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit"
                                    value="{{ old('tahun_terbit', $book->tahun_terbit) }}" min="1900"
                                    max="{{ date('Y') }}"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label for="kategori_id"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Kategori:</label>
                                <select name="kategori_id" id="kategori_id"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->kategori_id }}"
                                            {{ old('kategori_id', $book->kategori_id) == $kat->kategori_id ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- 6. Sinopsis --}}
                        <div class="mb-4">
                            <label for="sinopsis"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Sinopsis:</label>
                            <textarea name="sinopsis" id="sinopsis" rows="4"
                                class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('sinopsis', $book->sinopsis) }}</textarea>
                        </div>

                        {{-- 7. Stok Buku --}}
                        <div class="mb-6">
                            <label for="stok_buku"
                                class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stok Buku:</label>
                            <div class="w-32">
                                <input type="number" name="stok_buku" id="stok_buku"
                                    value="{{ old('stok_buku', $book->stok_buku) }}" min="0"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('books.manage') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                Update Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
