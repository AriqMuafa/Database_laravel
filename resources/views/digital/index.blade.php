<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-6xl mx-auto px-6">

            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center">
                Akses Buku Digital
            </h1>

            {{-- Grid Buku --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($digitalBooks as $digital)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">

                        {{-- Cover --}}
                        <img src="{{ $digital->cover ? asset('storage/' . $digital->cover) : 'https://via.placeholder.com/300x400' }}"
                             class="w-full h-56 object-cover" alt="Cover Buku">

                        <div class="p-6">

                            {{-- Judul --}}
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                {{ $digital->buku->judul ?? 'Judul Tidak Ditemukan' }}
                            </h2>

                            {{-- Format & Akses --}}
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                Format: <span class="font-medium">{{ strtoupper($digital->format) }}</span>
                            </p>

                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Akses:
                                <span class="font-medium {{ $digital->hak_akses === 'open access' ? 'text-green-500' : 'text-red-500' }}">
                                    {{ ucfirst($digital->hak_akses) }}
                                </span>
                            </p>

                            {{-- Tombol --}}
                            <a href="{{ route('digital.show', $digital->buku_digital_id) }}"
                               class="mt-4 inline-block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg transition">
                                Baca Sekarang
                            </a>

                        </div>
                    </div>

                @empty
                    <p class="text-gray-700 dark:text-gray-300 text-center col-span-3">
                        Belum ada buku digital yang tersedia.
                    </p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
