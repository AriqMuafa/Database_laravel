<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Pembayaran Denda
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Denda</h3>

                    <div class="border rounded-lg p-4 mb-6">
                        <div class="flex flex-col gap-2">
                            <p><strong>Judul Buku:</strong> {{ $denda->peminjaman->judul_buku }}</p>
                            <p><strong>Tanggal Pinjam:</strong> {{ $denda->peminjaman->tanggal_pinjam }}</p>
                            <p><strong>Tanggal Kembali:</strong> {{ $denda->peminjaman->tanggal_pengembalian ?? 'Belum Dikembalikan' }}</p>
                            <p><strong>Jumlah Denda:</strong> Rp {{ number_format($denda->jumlah, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <form action="{{ route('orders.process', $denda) }}" method="POST">
                        @csrf
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                                Bayar Sekarang
                            </button>
                            <a href="{{ route('fines.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
