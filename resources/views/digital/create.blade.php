<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Judul --}}
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 text-center">
                Tambah Buku Digital
            </h1>

            {{-- Card Form --}}
            <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">

                <form action="{{ route('digital.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Pilih Buku --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Pilih Buku
                        </label>
                        <select name="buku_id"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $b)
                                <option value="{{ $b->buku_id }}">{{ $b->judul }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Upload File Buku --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            File Buku (PDF / EPUB)
                        </label>
                        <input type="file" name="file_url"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                    </div>

                    {{-- Hak Akses --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Hak Akses
                        </label>
                        <select name="hak_akses"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                            <option value="open access">Open Access</option>
                            <option value="locked">Locked</option>
                        </select>
                    </div>

                    {{-- Upload Cover --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Cover Buku (opsional)
                        </label>
                        <input type="file" name="cover"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" rows="4"
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg"></textarea>
                    </div>

                    {{-- Downloadable --}}
                    <div class="mb-6 flex items-center space-x-2">
                        <input type="checkbox" name="is_downloadable" value="1"
                               class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        <label class="text-gray-700 dark:text-gray-300">Izinkan untuk diunduh</label>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">
                            Simpan Buku Digital
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
