<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi Peminjaman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Menampilkan pesan error validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Whoops!</strong> Ada masalah dengan input Anda.
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Menampilkan pesan error dari controller --}}
                    @if (session('error'))
                         <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="anggota_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Anggota</label>
                                <select name="anggota_id" id="anggota_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach ($anggota as $agt)
                                        <option value="{{ $agt->anggota_id }}">{{ $agt->id_anggota }} - {{ $agt->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="buku_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Judul Buku</label>
                                <select name="buku_id" id="buku_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach ($buku as $bk)
                                        <option value="{{ $bk->buku_id }}">{{ $bk->id_buku }} - {{ $bk->judul }} (Stok: {{ $bk->stok_buku }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tanggal_pinjam" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" 
                                       value="{{ old('tanggal_pinjam', now()->format('Y-m-d')) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <a href="{{ route('books.borrow') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Simpan Transaksi
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>