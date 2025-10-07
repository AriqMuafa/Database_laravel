<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-200 border-collapse">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">ID Buku</th>
                            <th class="px-4 py-2 border">Judul</th>
                            <th class="px-4 py-2 border">Pengarang</th>
                            <th class="px-4 py-2 border">Kategori</th>
                            <th class="px-4 py-2 border">Tahun Terbit</th>
                            <th class="px-4 py-2 border">Sinopsis</th>
                            <th class="px-4 py-2 border">Stok Buku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td class="px-4 py-2 border">{{ $book->buku_id }}</td>
                                <td class="px-4 py-2 border">{{ $book->judul }}</td>
                                <td class="px-4 py-2 border">{{ $book->pengarang }}</td>
                                <td class="px-4 py-2 border">{{ $book->nama_kategori }}</td>
                                <td class="px-4 py-2 border">{{ $book->tahun_terbit }}</td>
                                <td class="px-4 py-2 border">{{ $book->sinopsis }}</td>
                                <td class="px-4 py-2 border">{{ $book->stok_buku }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-2 border text-center">Belum ada buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>