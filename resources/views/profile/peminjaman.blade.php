<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-transparent overflow-hidden sm:rounded-lg">
                <div class="p-0"> <div class="peminjaman-grid">

                        @forelse($peminjamans as $peminjaman)
                            <div class="peminjaman-card">
                                <div class="peminjaman-card-content">
                                    
                                    <h3 class="card-title">
                                        {{ $peminjaman->buku->judul ?? 'Buku Tidak Ditemukan' }}
                                    </h3>

                                    <dl class="card-details">
                                        <div class="card-detail-item">
                                            <dt class="card-detail-label">Tanggal Pinjam</dt>
                                            <dd class="card-detail-value">
                                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}
                                            </dd>
                                        </div>
                                        <div class="card-detail-item">
                                            <dt class="card-detail-label">Tanggal Kembali</dt>
                                            <dd class="card-detail-value">
                                                {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') : '-' }}
                                            </dd>
                                        </div>
                                    </dl>

                                    <div class="card-status-section">
                                        <span class="card-detail-label">Status</span>
                                        
                                        @php
                                            // Logika status yang sama dari sebelumnya
                                            $statusClass = 'status-badge-lainnya';
                                            $statusText = $peminjaman->status;

                                            if ($peminjaman->denda && $peminjaman->denda->status_pembayaran == 'Belum Lunas') {
                                                $statusClass = 'status-badge-denda';
                                                $statusText = 'Denda Belum Lunas';
                                            } elseif ($peminjaman->status == 'Dipinjam') {
                                                $statusClass = 'status-badge-dipinjam';
                                            } elseif ($peminjaman->status == 'Dikembalikan') {
                                                $statusClass = 'status-badge-dikembalikan';
                                            }
                                        @endphp

                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                </div>

                                @if($peminjaman->denda && $peminjaman->denda->status_pembayaran == 'Belum Lunas')
                                    <div class="card-action-section p-5">
                                        <a href="{{ route('pembayaran.show', $peminjaman->id) }}" class="card-button-denda">
                                            Bayar Denda
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="card-empty-state">
                                <p>Anda belum memiliki riwayat peminjaman.</p>
                            </div>
                        @endforelse

                    </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>