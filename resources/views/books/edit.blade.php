<x-app-layout>
    <div class="container mx-auto mt-10 text-white">
        <h2 class="text-2xl font-semibold mb-6">Edit Buku</h2>

        <form action="{{ route('books.update', $book->buku_id) }}" method="POST"
            class="space-y-4 bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div>
                <label for="judul" class="block text-sm font-medium mb-1">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $book->judul) }}"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Pengarang --}}
            <div>
                <label for="pengarang" class="block text-sm font-medium mb-1">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang', $book->pengarang) }}"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Penerbit --}}
            {{-- <div>
                <label for="penerbit" class="block text-sm font-medium mb-1">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $book->penerbit) }}"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div> --}}

            {{-- Tahun Terbit --}}
            <div>
                <label for="tahun_terbit" class="block text-sm font-medium mb-1">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit"
                    value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori_id" class="block text-sm font-medium mb-1">Kategori</label>
                <select name="kategori_id" id="kategori_id"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->kategori_id }}" {{ old('kategori_id', $book->kategori_id) == $item->kategori_id ? 'selected' : '' }}>
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sinopsis --}}
            <div>
                <label for="sinopsis" class="block text-sm font-medium mb-1">Sinopsis</label>
                <textarea name="sinopsis" id="sinopsis" rows="4"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('sinopsis', $book->sinopsis) }}</textarea>
            </div>

            {{-- Stok Buku --}}
            <div>
                <label for="stok_buku" class="block text-sm font-medium mb-1">Stok Buku</label>
                <input type="number" name="stok_buku" id="stok_buku" value="{{ old('stok_buku', $book->stok_buku) }}"
                    class="w-full px-3 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Update
                </button>
                <a href="{{ route('books.manage') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>