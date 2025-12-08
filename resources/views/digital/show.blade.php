<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-6">

            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8">
                {{ $book->buku->judul ?? 'Judul Tidak Ditemukan' }}
            </h1>

            {{-- Card Detail --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 flex flex-col md:flex-row gap-6">

                {{-- Cover --}}
                <img src="{{ $book->cover ? asset('storage/covers/' . $book->cover) : 'https://via.placeholder.com/300x400' }}"
                     class="w-48 h-64 object-cover rounded-lg shadow"
                     alt="Cover Buku">

                {{-- Detail --}}
                <div class="flex-1">

                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        <strong>Format:</strong> {{ strtoupper($book->format) }}
                    </p>

                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        <strong>Akses:</strong>
                        <span class="{{ $book->hak_akses === 'open access' ? 'text-green-600' : 'text-red-500' }}">
                            {{ ucfirst($book->hak_akses) }}
                        </span>
                    </p>

                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        <strong>Ukuran File:</strong> {{ $book->size ?? '-' }}
                    </p>

                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        <strong>Dilihat:</strong> {{ $book->views }}x
                    </p>

                    {{-- Deskripsi --}}
                    <p class="mt-4 text-gray-700 dark:text-gray-300">
                        {!! nl2br(e($book->deskripsi)) !!}
                    </p>

                    {{-- Tombol Aksi --}}
                    <div class="mt-6 flex gap-3">
                        {{-- Baca --}}
                        @if ($book->hak_akses === 'open access')
                            <a href="{{ asset('storage/' . $book->file_url) }}"
                               target="_blank"
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Baca Sekarang
                            </a>
                        @else
                            <button class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed">
                                Akses Dikunci
                            </button>
                        @endif

                        {{-- Download --}}
                        @if ($book->is_downloadable && $book->hak_akses === 'open access')
                            <a href="{{ route('digital.download', $book->buku_digital_id) }}"
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Download
                            </a>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
