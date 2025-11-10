{{-- Hapus seluruh tag <style>...</style> yang ada di file Anda --}}

{{-- 
  Layout ini akan menggunakan x-app-layout Anda.
  Saya sesuaikan background-nya menjadi abu-abu muda (bg-gray-100) 
  dan semua style (card, tombol, badge) menggunakan kelas Tailwind standar.
--}}
<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            
            {{-- Ini adalah 'nota-card' Anda, diterjemahkan ke kelas Tailwind --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-2xl text-center">
                
                {{-- Notifikasi sukses --}}
                @if(session('success'))
                    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Detail Peminjaman --}}
                <div class="mb-6">
                    {{-- Ini adalah 'nota-section-title' --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-300 pb-2">
                        Detail Peminjaman
                    </h3>
                    
                    {{-- Ini adalah 'nota-info' --}}
                    <div class="text-left">
                        <p class="text-gray-700 mb-2">
                            {{-- Ini adalah 'nota-label' --}}
                            <span class="font-medium text-gray-800">ID Transaksi:</span> 
                            {{ $peminjaman->id_peminjaman }}
                        </p>
                        <p class="text-gray-700 mb-2">
                            <span class="font-medium text-gray-800">Nama Anggota:</span> 
                            {{ $peminjaman->anggota->nama }}
                        </p>
                        <p class="text-gray-700 mb-2">
                            <span class="font-medium text-gray-800">Judul Buku:</span> 
                            {{ $peminjaman->buku->judul }}
                        </p>
                        <p class="text-gray-700 mb-2">
                            <span class="font-medium text-gray-800">Tanggal Pinjam:</span> 
                            {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}
                        </p>
                        <p class="text-gray-700 mb-2">
                            <span class="font-medium text-gray-800">Jatuh Tempo:</span> 
                            {{ $peminjaman->tanggal_jatuh_tempo->format('d-m-Y') }}
                        </p>
                    </div>
                </div>

                {{-- Denda --}}
                @if($peminjaman->denda)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b border-gray-300 pb-2">
                            Informasi Denda
                        </h3>
                        <div class="text-left">
                            <p class="text-gray-700 mb-2">
                                <span class="font-medium text-gray-800">Total Denda:</span>
                                Rp {{ number_format($peminjaman->denda->jumlah ?? 0, 0, ',', '.') }}
                            </p>
                            <p class="text-gray-700 mb-2 flex items-center">
                                <span class="font-medium text-gray-800 mr-2">Status Denda:</span>
                                @if($peminjaman->denda->status == 'lunas')
                                    {{-- Ini adalah 'badge badge-success' --}}
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        Lunas
                                    </span>
                                @else
                                    {{-- Ini adalah 'badge badge-warning' --}}
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                        Belum Bayar
                                    </span>
                                @endif
                            </p>
                        </div>

                        {{-- Tombol --}}
                        @if($peminjaman->denda->status != 'lunas')
                            <div class="mt-6 flex justify-center gap-4">
                                {{-- Ini adalah 'btn btn-primary' (disesuaikan warnanya) --}}
                                <a href="{{ route('orders.confirm', $peminjaman->denda->denda_id) }}" 
                                   class="inline-block px-6 py-3 rounded-lg font-semibold text-white shadow-lg bg-blue-600 hover:bg-blue-700">
                                    💳 Bayar Sekarang
                                </a>
                                {{-- Ini adalah 'btn btn-secondary' --}}
                                <a href="{{ route('books.borrow') }}" 
                                   class="inline-block px-6 py-3 rounded-lg font-semibold text-white shadow-lg bg-gray-600 hover:bg-gray-700">
                                    ↩️ Kembali
                                </a>
                            </div>
                        @else
                            <div class="mt-6 flex justify-center">
                                <a href="{{ route('books.borrow') }}" 
                                   class="inline-block px-6 py-3 rounded-lg font-semibold text-white shadow-lg bg-gray-600 hover:bg-gray-700">
                                    Kembali
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-4 bg-blue-100 text-blue-800 rounded-lg mb-8">
                        Tidak ada denda untuk peminjaman ini.
                    </div>
                    <div class="flex justify-center">
                        <a href="{{ route('books.borrow') }}" 
                           class="inline-block px-6 py-3 rounded-lg font-semibold text-white shadow-lg bg-gray-600 hover:bg-gray-700">
                            Kembali
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>