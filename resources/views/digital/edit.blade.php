<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center">
                Edit Buku Digital
            </h1>

            {{-- Card Form --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">

                <form action="{{ route('digital.update', $book->buku_digital_id) }}" 
                      method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Judul Buku --}}
                    <div class="mb-6">
                        <p class="text-gray-800 dark:text-gray-100 font-semibold mb-1">Buku</p>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            {{ $book->buku->judul }}
                        </p>
                    </div>

                    {{-- File Buku --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            File Buku (ganti opsional)
                        </label>
                        <input type="file" name="file_url"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                        <small class="text-gray-500 dark:text-gray-400">
                            File sekarang: {{ basename($book->file_url) }}
                        </small>
                    </div>

                    {{-- Hak Akses --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Hak Akses
                        </label>
                        <select name="hak_akses"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                            <option value="open access" {{ $book->hak_akses === 'open access' ? 'selected' : '' }}>
                                Open Access
                            </option>
                            <option value="locked" {{ $book->hak_akses === 'locked' ? 'selected' : '' }}>
                                Locked
                            </option>
                        </select>
                    </div>

                    {{-- Cover --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Cover Buku (ganti opsional)
                        </label>
                        <input type="file" name="cover"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                        
                        @if($book->cover)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $book->cover) }}" 
                                 class="w-32 rounded-lg shadow">
                        </div>
                        @endif
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">{{ $book->deskripsi }}</textarea>
                    </div>

                    {{-- Downloadable --}}
                    <div class="mb-6 flex items-center space-x-2">
                        <input type="checkbox" name="is_downloadable" value="1"
                               {{ $book->is_downloadable ? 'checked' : '' }}
                               class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        <label class="text-gray-700 dark:text-gray-300">Izinkan untuk diunduh</label>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-between">

                        <a href="{{ route('digital.show', $book->buku_digital_id) }}"
                           class="px-6 py-3 rounded-lg bg-gray-500 hover:bg-gray-600 text-white shadow">
                            Batal
                        </a>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">
                            Update Buku Digital
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
