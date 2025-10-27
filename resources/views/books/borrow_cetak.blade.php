@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nota Peminjaman</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Detail Peminjaman --}}
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>ID Transaksi:</strong> {{ $peminjaman->id_peminjaman }}</p>
            <p><strong>Nama Anggota:</strong> {{ $peminjaman->anggota->nama }}</p>
            <p><strong>Buku:</strong> {{ $peminjaman->buku->judul }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</p>
            <p><strong>Tanggal Jatuh Tempo:</strong> {{ $peminjaman->tanggal_jatuh_tempo->format('d-m-Y') }}</p>
        </div>
    </div>

    {{-- Denda --}}
    @if($peminjaman->denda)
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Total Denda:</strong> Rp {{ number_format($peminjaman->denda->jumlah ?? 0, 0, ',', '.') }}</p>
                <p><strong>Status Denda:</strong>
                    @if($peminjaman->denda->status == 'lunas')
                        <span class="badge bg-success">Lunas</span>
                    @else
                        <span class="badge bg-warning">Belum Bayar</span>
                    @endif
                </p>

                {{-- Tombol Bayar Sekarang --}}
                @if($peminjaman->denda->status != 'lunas')
                    <a href="{{ route('orders.confirm', $peminjaman->denda->denda_id) }}" class="btn btn-primary">
                        Bayar Sekarang
                    </a>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Tidak ada denda untuk peminjaman ini.
        </div>
    @endif

    {{-- Tombol Kembali --}}
    <a href="{{ route('books.borrow') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Peminjaman</a>
</div>
@endsection
