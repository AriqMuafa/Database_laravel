<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran Denda Berhasil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-green-600 mb-2">Pembayaran Berhasil!</h3>
                    <p class="text-gray-600">Order #{{ $order->order_number }}</p>

                    <div class="border rounded-lg p-4 mb-6 mt-4">
                        <h4 class="font-semibold mb-3">Detail Denda</h4>
                        <p><strong>Judul Buku:</strong> {{ $order->denda->peminjaman->judul_buku }}</p>
                        <p><strong>Tanggal Pinjam:</strong> {{ $order->denda->peminjaman->tanggal_pinjam }}</p>
                        <p><strong>Tanggal Kembali:</strong> {{ $order->denda->peminjaman->tanggal_pengembalian ?? 'Belum Dikembalikan' }}</p>
                        <p><strong>Jumlah Dibayar:</strong> Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                        <p><strong>Nomor VA:</strong> {{ $order->va_number }}</p>
                        <p><strong>Tanggal Bayar:</strong> {{ $order->paid_at->format('d M Y H:i') }} WIB</p>
                    </div>

                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('menu.peminjaman') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                            Kembali ke Peminjaman
                        </a>
                        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded">
                            Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
