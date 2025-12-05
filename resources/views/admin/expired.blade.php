<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anggota Kadaluarsa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .card { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .table-header { background-color: #f1f5f9; }
    </style>
</head>
<body class="p-4 sm:p-8">

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-red-500 pb-2">
            🚨 Daftar Anggota Kadaluarsa
        </h1>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <p class="mb-6 text-sm text-gray-600">
            Berikut adalah anggota yang masa keanggotaannya telah berakhir (5 tahun sejak tanggal pendaftaran):
            <span class="font-semibold text-red-600">({{ $expiredDateLimit->format('d F Y') }} atau sebelumnya)</span>.
        </p>

        <!-- Tabel Daftar Anggota -->
        <div class="bg-white card rounded-xl overflow-hidden shadow-lg">
            @if ($expiredMembers->isEmpty())
                <div class="p-10 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h3 class="mt-2 text-xl font-medium text-gray-900">Kosong</h3>
                    <p class="mt-1 text-base text-gray-500">
                        Tidak ada anggota yang kadaluarsa saat ini.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="table-header">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Anggota</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Anggota</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Daftar</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Telah Kadaluarsa Sejak</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($expiredMembers as $anggota)
                                @php
                                    $tanggalDaftar = \Carbon\Carbon::parse($anggota->tanggal_daftar);
                                    $tanggalKadaluarsa = $tanggalDaftar->copy()->addYears(5);
                                    $sejakKadaluarsa = $tanggalKadaluarsa->diffForHumans(null, true);
                                @endphp
                                <tr class="hover:bg-red-50/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                                        {{ $anggota->anggota_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $anggota->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $tanggalDaftar->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-700">
                                        {{ $sejakKadaluarsa }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <!-- Formulir untuk Aksi Hapus -->
                                        <form action="{{ route('admin.expired.destroy', $anggota->anggota_id) }}" method="POST" 
                                            onsubmit="return confirm('APAKAH ANDA YAKIN? Penghapusan anggota ini bersifat permanen dan tidak dapat dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-semibold py-1.5 px-3 rounded-full 
                                                shadow-md transition duration-200 ease-in-out transform hover:scale-105 active:scale-95 text-xs">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.86 12.14a2 2 0 01-2 1.86H7.86a2 2 0 01-2-1.86L5 7m14 0V5a2 2 0 00-2-2H7a2 2 0 00-2 2v2m14 0h-4"></path></svg>
                                                Hapus Anggota
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="p-4 border-t border-gray-200">
                    {{ $expiredMembers->links() }}
                </div>
            @endif
        </div>

    </div>
</body>
</html>