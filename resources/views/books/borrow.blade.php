<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peminjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Tombol Transaksi Baru --}}
            <div class="mb-4">
                <a href="{{ route('peminjaman.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700 transition">
                    + Pinjam Buku
                </a>
            </div>
            <div class="mb-4">
                <a href="{{ route('reservations.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-yellow-600 transition">
                    Reservasi Saya
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                @if (session('success'))
                    <div class="p-4 bg-green-50 text-green-700 border-b border-green-100">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="py-3 px-6">No</th>
                                <th class="py-3 px-6">Judul Buku</th>
                                <th class="py-3 px-6">Tgl Pinjam</th>
                                <th class="py-3 px-6">Jatuh Tempo</th>
                                <th class="py-3 px-6 text-center">Estimasi Denda</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_peminjaman as $pinjam)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-6 font-medium text-gray-900">
                                        {{ $pinjam->buku->judul ?? 'Buku dihapus' }}
                                        <div class="text-xs text-gray-400">{{ $pinjam->id_peminjaman }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                                    </td>

                                    {{-- Logic Jatuh Tempo --}}
                                    <td class="py-4 px-6">
                                        @php
                                            $jatuhTempo = \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo);
                                            $isOverdue = now()->gt($jatuhTempo) && $pinjam->status == 'dipinjam';
                                        @endphp
                                        <span class="{{ $isOverdue ? 'text-red-600 font-bold' : '' }}">
                                            {{ $jatuhTempo->format('d M Y') }}
                                        </span>
                                        @if ($isOverdue)
                                            <div class="text-[10px] text-red-500 font-bold">Terlambat!</div>
                                        @endif
                                    </td>

                                    {{-- Logic Denda --}}
                                    <td class="py-4 px-6 text-center">
                                        @php
                                            // Prioritaskan denda real (jika sudah dikembalikan), jika belum, pakai estimasi
                                            $nominal = $pinjam->denda
                                                ? $pinjam->denda->jumlah
                                                : $pinjam->denda_saat_ini;
                                            $lunas = $pinjam->denda && $pinjam->denda->status == 'lunas';
                                        @endphp

                                        @if ($nominal > 0)
                                            <span
                                                class="px-2 py-1 rounded text-xs {{ $lunas ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                Rp {{ number_format($nominal, 0, ',', '.') }}
                                                {{ $lunas ? '(Lunas)' : '' }}
                                                {{ !$lunas && !$pinjam->denda ? '(Estimasi)' : '' }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        @if ($pinjam->status == 'sudah dikembalikan')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Selesai</span>
                                        @else
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Dipinjam</span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6 text-center">
                                        {{-- LOGIKA AKSI --}}
                                        @if ($pinjam->denda && $pinjam->denda->status == 'belum lunas')
                                            {{-- Kasus 1: Sudah dikembalikan tapi belum bayar denda --}}
                                            <a href="{{ route('orders.confirm', $pinjam->denda->denda_id) }}"
                                                class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-3 py-2">
                                                Bayar Denda
                                            </a>
                                        @elseif($isOverdue && $pinjam->status == 'dipinjam')
                                            {{-- Kasus 2: Telat tapi belum dikembalikan --}}
                                            <span
                                                class="text-xs text-red-500 font-semibold border border-red-200 bg-red-50 px-2 py-1 rounded">
                                                Kembalikan ke Petugas
                                            </span>
                                        @elseif($pinjam->status == 'sudah dikembalikan')
                                            {{-- Kasus 3: Selesai --}}
                                            <a href="{{ route('peminjaman.cetak', $pinjam->peminjaman_id) }}"
                                                target="_blank" class="text-blue-600 hover:underline text-xs">
                                                Cetak Bukti
                                            </a>
                                        @else
                                            {{-- Kasus 4: Masih dipinjam normal --}}
                                            <span class="text-gray-400 text-xs italic">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-500">Belum ada riwayat
                                        peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
