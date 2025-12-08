<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Buku Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-6">Formulir Penambahan Buku</h3>

                    {{-- Menampilkan error validasi --}}
                    @if ($errors->any())
                        <div
                            class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900 dark:border-red-700 dark:text-red-200">
                            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Menampilkan pesan error umum --}}
                    @if (session('error'))
                        <div
                            class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded dark:bg-red-900 dark:border-red-700 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Judul Buku --}}
                            <div>
                                <label for="judul"
                                    class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Judul
                                    Buku</label>
                                <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required autofocus>
                            </div>

                            {{-- 2. Cover Buku --}}
                            <div class="mb-4">
                                <label for="cover"
                                    class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Cover Buku
                                    (Opsional):</label>
                                <input type="file" name="cover" id="cover" accept="image/png, image/jpeg, image/jpg"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-300
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                dark:file:bg-gray-700 dark:file:text-gray-300">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, JPEG. Max:
                                    2MB.</p>
                            </div>

                            {{-- Pengarang --}}
                            <div>
                                <label for="pengarang"
                                    class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Pengarang</label>
                                <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang') }}"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            {{-- Tahun Terbit --}}
                            <div>
                                <label for="tahun_terbit"
                                    class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Tahun
                                    Terbit</label>
                                <input type="number" name="tahun_terbit" id="tahun_terbit"
                                    value="{{ old('tahun_terbit') }}" min="1000" max="{{ date('Y') }}"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            {{-- Kategori --}}
                            <div>
                                <label for="kategori_id"
                                    class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Kategori</label>
                                <select name="kategori_id" id="kategori_id"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                    <option value="">-- Pilih Kategori --</option>
                                    {{-- Variabel $kategori dikirim dari controller --}}
                                    @foreach ($kategori ?? [] as $item)
                                        @if(is_object($item))
                                            <option value="{{ $item->kategori_id }}" {{ old('kategori_id') == $item->kategori_id ? 'selected' : '' }}>
                                                {{ $item->nama_kategori }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>

                            {{-- Sinopsis --}}
                            <div class="md:col-span-2">
                                <label for="sinopsis"
                                    class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Sinopsis</label>
                                <textarea name="sinopsis" id="sinopsis" rows="4"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('sinopsis') }}</textarea>
                            </div>

                            {{-- Stok Buku --}}
                            <div>
                                <label for="stok_buku"
                                    class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Stok
                                    Buku</label>
                                <input type="number" name="stok_buku" id="stok_buku" value="{{ old('stok_buku', 1) }}"
                                    min="0"
                                    class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('books.manage') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-500 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Simpan Buku
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>