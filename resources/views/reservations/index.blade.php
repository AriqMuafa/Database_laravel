<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservasi Saya') }}
        </h2>
    </x-slot>

    {{-- Latar belakang abu-abu muda --}}
    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Kontainer Putih Utama --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <p class="mb-6 text-gray-600">
                        Ini adalah daftar antrean buku yang sedang Anda reservasi.
                    </p>

                    <div class="overflow-x-auto relative sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            {{-- Header Tabel diubah menjadi abu-abu muda --}}
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th>
                                    <th scope="col" class="py-3 px-6">Judul Buku</th>
                                    <th scope="col" class="py-3 px-6">Tgl. Reservasi</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Variabel $reservasi_saya dan $res TIDAK DIUBAH --}}
                                @forelse ($reservasi_saya as $res)
                                    {{-- Kelas 'dark:' dihapus dari <tr> --}}
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        <td class="py-4 px-6 font-medium text-gray-900">
                                            {{ $res->buku->judul ?? 'Buku Dihapus' }}
                                        </td>
                                        <td class="py-4 px-6">{{ $res->tanggal_reservasi }}</td>
                                        <td class="py-4 px-6">
                                            {{-- Logika Status dan Badge (hanya menghapus kelas 'dark:') --}}
                                            @if ($res->status == 'Pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                    {{ $res->status }}
                                                </span>
                                            @elseif ($res->status == 'Siap Diambil')
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                    {{ $res->status }} (Silakan ambil di perpustakaan)
                                                </span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                    {{ $res->status }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Kelas 'dark:' dihapus dari <tr> --}}
                                    <tr class="bg-white border-b">
                                        <td colspan="4" class="py-4 px-6 text-center">
                                            Anda belum memiliki reservasi aktif.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>