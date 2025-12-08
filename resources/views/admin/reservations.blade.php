<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Reservasi Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Pesan Sukses atau Error --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Kontainer Tabel --}}
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            {{-- Header Tabel --}}
                            <thead class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="py-3 px-6">No</th>
                                    <th scope="col" class="py-3 px-6">Judul Buku</th>
                                    <th scope="col" class="py-3 px-6">Nama Anggota</th>
                                    <th scope="col" class="py-3 px-6">Tgl. Reservasi</th>
                                    <th scope="col" class="py-3 px-6">Status</th>
                                    <th scope="col" class="py-3 px-6">Opsi</th>
                                </tr>
                            </thead>
                            
                            {{-- Isi Tabel --}}
                            <tbody>
                                @forelse ($reservasi as $res)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="py-4 px-6">{{ $loop->iteration }}</td>
                                        
                                        {{-- Judul Buku --}}
                                        <td class="py-4 px-6 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ $res->buku->judul ?? 'Buku Dihapus' }}
                                        </td>
                                        
                                        {{-- Nama Anggota --}}
                                        <td class="py-4 px-6">
                                            {{ $res->anggota->nama ?? 'Anggota Dihapus' }}
                                        </td>
                                        
                                        <td class="py-4 px-6">{{ $res->tanggal_reservasi }}</td>
                                        
                                        {{-- Status --}}
                                        <td class="py-4 px-6">
                                            @if ($res->status == 'Pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">
                                                    {{ $res->status }}
                                                </span>
                                            @elseif ($res->status == 'Siap Diambil')
                                                <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">
                                                    {{ $res->status }}
                                                </span>
                                            @endif
                                        </td>
                                        
                                        {{-- Tombol Opsi --}}
                                        <td class="py-4 px-6 flex flex-col space-y-2">
                                            
                                            {{-- Skenario 1: Status "Pending" --}}
                                            @if ($res->status == 'Pending')
                                                <form action="{{ route('admin.reservations.siap', $res) }}" method="POST" onsubmit="return confirm('Tandai siap diambil? Stok buku akan dikurangi 1 (ditahan).');">
                                                    @csrf
                                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded text-xs">
                                                        Tandai Siap Diambil
                                                    </button>
                                                </form>
                                            
                                            {{-- Skenario 2: Status "Siap Diambil" --}}
                                            @elseif ($res->status == 'Siap Diambil')
                                                <form action="{{ route('admin.reservations.proses', $res) }}" method="POST" onsubmit="return confirm('Proses reservasi ini menjadi peminjaman?');">
                                                    @csrf
                                                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-2 rounded text-xs">
                                                        Proses Peminjaman
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            {{-- Tombol Batal (selalu ada) --}}
                                            <form action="{{ route('admin.reservations.batal', $res) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?');">
                                                @csrf
                                                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-xs">
                                                    Batalkan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td colspan="6" class="py-4 px-6 text-center">
                                            Tidak ada data reservasi aktif.
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