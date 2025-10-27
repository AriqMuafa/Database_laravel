<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Peminjaman Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Daftar Peminjaman</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                            <th class="px-4 py-2">Judul Buku</th>
                            <th class="px-4 py-2">Tanggal Pinjam</th>
                            <th class="px-4 py-2">Tanggal Kembali</th>
                            <th class="px-4 py-2">Denda</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $pinjam)
                        <tr class="border-b dark:border-gray-600">
                            <td class="px-4 py-2">{{ $pinjam['judul_buku'] }}</td>
                            <td class="px-4 py-2">{{ $pinjam['tanggal_pinjam'] }}</td>
                            <td class="px-4 py-2">{{ $pinjam['tanggal_kembali'] }}</td>
                            <td class="px-4 py-2 {{ $pinjam['jumlah_denda'] > 0 ? 'text-red-500' : 'text-green-600' }}">
                                {{ $pinjam['jumlah_denda'] > 0 ? 'Rp ' . number_format($pinjam['jumlah_denda'],0,',','.') : 'Tidak Ada' }}
                            </td>
                            <td class="px-4 py-2">
                                @if($pinjam['jumlah_denda'] > 0)
                                    <a href="{{ route('fines.index', ['denda' => $pinjam['denda_id']]) }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm">
                                        Bayar Denda
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
