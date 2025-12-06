<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header & Tombol Tambah --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Pustaka</h3>
                        <a href="{{ route('books.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Buku
                        </a>
                    </div>

                    {{-- Pesan Sukses --}}
                    @if (session('success'))
                        <div
                            class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-900 dark:border-green-700 dark:text-green-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel Responsive --}}
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full table-auto border-collapse border border-gray-200 dark:border-gray-700">
                            {{-- Table Head --}}
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-4 py-3 border-b dark:border-gray-600 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-4 py-3 border-b dark:border-gray-600 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Cover</th>
                                    <th
                                        class="px-4 py-3 border-b dark:border-gray-600 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Detail Buku</th>
                                    <th
                                        class="px-4 py-3 border-b dark:border-gray-600 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kategori</th>
                                    <th
                                        class="px-4 py-3 border-b dark:border-gray-600 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Stok</th>
                                    <th
                                        class="px-4 py-3 border-b dark:border-gray-600 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>

                            {{-- Table Body --}}
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($books as $book)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                        {{-- No --}}
                                        <td
                                            class="px-4 py-4 text-center whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- Cover --}}
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            @if ($book->cover)
                                                <img src="{{ asset('storage/' . $book->cover) }}" alt="Cover"
                                                    class="h-16 w-12 object-cover rounded shadow border border-gray-200 dark:border-gray-600">
                                            @else
                                                <div
                                                    class="h-16 w-12 bg-gray-100 dark:bg-gray-600 flex items-center justify-center rounded text-xs text-gray-400 border border-gray-200 dark:border-gray-600">
                                                    N/A
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Detail Buku (Gabungan Info) --}}
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white mb-1">
                                                {{ $book->judul }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                <span class="font-medium">Penulis:</span> {{ $book->pengarang }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                <span class="font-medium">Penerbit:</span> {{ $book->penerbit ?? '-' }}
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Tahun: {{ $book->tahun_terbit }}
                                            </div>
                                        </td>

                                        {{-- Kategori --}}
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ $book->kategori ? $book->kategori->nama_kategori : 'Umum' }}
                                            </span>
                                        </td>

                                        {{-- Stok --}}
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="text-sm font-bold {{ $book->stok_buku > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $book->stok_buku }}
                                            </span>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div
                                                class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2 justify-center">
                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('books.edit', $book->buku_id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 px-3 py-1 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 transition">
                                                    Edit
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('books.destroy', $book->buku_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?');"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/50 px-3 py-1 rounded hover:bg-red-100 dark:hover:bg-red-900 transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                {{-- Ikon Empty State --}}
                                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                <span class="text-lg font-medium">Belum ada buku</span>
                                                <p class="text-sm mt-1">Mulai dengan menambahkan buku baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
