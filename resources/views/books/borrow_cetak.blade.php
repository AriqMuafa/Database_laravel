<style>
    .nota-card {
        @apply bg-white dark:bg-gray-900 shadow-2xl rounded-3xl p-8 w-full max-w-2xl text-center transition-transform transform hover:scale-[1.01];
    }
    .nota-section-title {
        @apply text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 border-b border-gray-300 dark:border-gray-700 pb-2;
    }
    .nota-info p {
        @apply text-gray-700 dark:text-gray-300 mb-2;
    }
    .nota-label {
        @apply font-medium text-gray-800 dark:text-gray-200;
    }
    .btn {
        @apply inline-block px-6 py-3 rounded-xl font-semibold text-white shadow-lg transform transition duration-200;
    }
    .btn-primary {
        @apply bg-indigo-600 hover:bg-indigo-700;
    }
    .btn-secondary {
        @apply bg-gray-600 hover:bg-gray-700;
    }
    .badge {
        @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold;
    }
    .badge-success {
        @apply bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100;
    }
    .badge-warning {
        @apply bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100;
    }
</style>

<div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
        <div class="nota-card">
            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Detail Peminjaman --}}
            <div class="mb-6">
                <h3 class="nota-section-title">Detail Peminjaman</h3>
                <div class="nota-info">
                    <p><span class="nota-label">ID Transaksi:</span> {{ $peminjaman->id_peminjaman }}</p>
                    <p><span class="nota-label">Nama Anggota:</span> {{ $peminjaman->anggota->nama }}</p>
                    <p><span class="nota-label">Judul Buku:</span> {{ $peminjaman->buku->judul }}</p>
                    <p><span class="nota-label">Tanggal Pinjam:</span> {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</p>
                    <p><span class="nota-label">Jatuh Tempo:</span> {{ $peminjaman->tanggal_jatuh_tempo->format('d-m-Y') }}</p>
                </div>
            </div>

            {{-- Denda --}}
            @if($peminjaman->denda)
                <div class="mb-8">
                    <h3 class="nota-section-title">Informasi Denda</h3>
                    <div class="nota-info">
                        <p>
                            <span class="nota-label">Total Denda:</span>
                            Rp {{ number_format($peminjaman->denda->jumlah ?? 0, 0, ',', '.') }}
                        </p>
                        <p>
                            <span class="nota-label">Status Denda:</span>
                            @if($peminjaman->denda->status == 'lunas')
                                <span class="badge badge-success">Lunas</span>
                            @else
                                <span class="badge badge-warning">Belum Bayar</span>
                            @endif
                        </p>
                    </div>

                    {{-- Tombol --}}
                    @if($peminjaman->denda->status != 'lunas')
                        <div class="mt-6 flex justify-center gap-4">
                            <a href="{{ route('orders.confirm', $peminjaman->denda->denda_id) }}" class="btn btn-primary">
                                💳 Bayar Sekarang
                            </a>
                            <a href="{{ route('books.borrow') }}" class="btn btn-secondary">
                                ↩️ Kembali
                            </a>
                        </div>
                    @else
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('books.borrow') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="p-4 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 rounded-lg mb-8">
                    Tidak ada denda untuk peminjaman ini.
                </div>
                <div class="flex justify-center">
                    <a href="{{ route('books.borrow') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
