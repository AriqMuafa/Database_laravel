<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi Peminjaman Baru') }}
        </h2>
    </x-slot>

    {{-- Latar belakang abu-abu muda --}}
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Kontainer Putih Utama --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Menampilkan pesan error validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Whoops!</strong> Ada masalah dengan input Anda.
                            <ul class="mt-2 list-disc list-inside">
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

                            {{-- Field Nama Anggota --}}
                            <div>
                                {{-- Menggunakan komponen <x-input-label> dan <x-text-input> agar konsisten --}}
                                <x-input-label for="nama_anggota" :value="__('Nama Anggota')" />
                                <x-text-input id="nama_anggota" class="block mt-1 w-full bg-gray-100 cursor-not-allowed"
                                              type="text"
                                              value="{{ $anggota->nama }} ({{ $anggota->anggota_id }})"
                                              disabled />
                                <p class="mt-1 text-xs text-gray-500">Nama diisi otomatis dari akun Anda.</p>
                            </div>

                            {{-- Field Judul Buku --}}
                            <div>
                                <x-input-label for="buku_id" :value="__('Judul Buku')" />
                                {{-- Mengganti <input> biasa dengan <select> --}}
                                <select name="buku_id" id="buku_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach ($buku as $bk)
                                        {{-- Menambahkan atribut 'disabled' jika stok 0 --}}
                                        <option value="{{ $bk->buku_id }}" @if($bk->stok_buku <= 0) disabled @endif>
                                            {{ $bk->id_buku }} - {{ $bk->judul }} (Stok: {{ $bk->stok_buku }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Field Tanggal Pinjam --}}
                            <div>
                                <x-input-label for="tanggal_pinjam" :value="__('Tanggal Pinjam')" />
                                <x-text-input id="tanggal_pinjam" class="block mt-1 w-full"
                                              type="date"
                                              name="tanggal_pinjam"
                                              :value="old('tanggal_pinjam', now()->format('Y-m-d'))"
                                              required />
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex justify-end space-x-4">
                            {{-- Tombol Batal --}}
                            <a href="{{ route('books.borrow') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none">
                                Batal
                            </a>
                            
                            {{-- Tombol Simpan (Menggunakan komponen <x-primary-button>) --}}
                            <x-primary-button>
                                {{ __('Simpan Transaksi') }}
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>