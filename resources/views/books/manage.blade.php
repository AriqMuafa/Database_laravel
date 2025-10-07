<x-app-layout>
    <div class="container mx-auto mt-10">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold text-white">Kelola Buku</h1>
            <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                + Tambah Buku
            </a>
        </div>

        <div class="bg-gray-800 text-white rounded-lg shadow-md p-4">
            <table class="min-w-full table-auto border-collapse border border-gray-700">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">ID Buku</th>
                        <th class="px-4 py-2 border">Judul</th>
                        <th class="px-4 py-2 border">Pengarang</th>
                        <th class="px-4 py-2 border">Tahun Terbit</th>
                        <th class="px-4 py-2 border">Kategori</th>
                        <th class="px-4 py-2 border">Sinopsis</th>
                        <th class="px-4 py-2 border">Stok Buku</th>
                        <th class="px-4 py-2 border">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2 border border-gray-700 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border border-gray-700">{{ $book->judul }}</td>
                            <td class="px-4 py-2 border border-gray-700">{{ $book->pengarang }}</td>
                            <td class="px-4 py-2 border border-gray-700 text-center">{{ $book->tahun_terbit }}</td>
                            <td class="px-4 py-2 border border-gray-700">
                                {{ $book->kategori ? $book->kategori->nama_kategori : '-' }}
                            </td>
                            <td class="px-4 py-2 border border-gray-700">{{ $book->sinopsis }}</td>
                            <td class="px-4 py-2 border border-gray-700 text-center">{{ $book->stok_buku }}</td>
                            <td class="px-4 py-2 border border-gray-700 text-center">
                                <a href="{{ route('books.edit', $book->buku_id) }}"
                                    class="text-blue-400 hover:underline">Edit<br></a>

                                <form action="{{ route('books.destroy', ['book' => $book->buku_id]) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>