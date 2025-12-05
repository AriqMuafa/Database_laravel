<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan Peminjaman</title>
    <style>
        body { font-family: sans-serif; margin: 20px; background-color: #f4f4f9; }
        .container { max-width: 1100px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #007bff; color: white; font-weight: 600; }
        tr:nth-child(even) { background-color: #f8f8ff; }
        .status-dipinjam { color: #dc3545; font-weight: 600; }
        .status-dikembalikan { color: #28a745; font-weight: 600; }
        .filter-form { display: flex; gap: 10px; margin-bottom: 20px; align-items: center; }
        .filter-form label { font-weight: 600; }
        .filter-form select, .filter-form button { padding: 8px 15px; border-radius: 5px; border: 1px solid #ccc; }
        .filter-form button { background-color: #28a745; color: white; cursor: pointer; border: none; transition: background-color 0.3s; }
        .filter-form button:hover { background-color: #1e7e34; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $reportTitle }}</h1>

        @if(session('error'))
            <p style="color: red; border: 1px solid red; padding: 10px; background: #ffe0e0; border-radius: 5px;">
                {{ session('error') }}
            </p>
        @endif

        <!-- Filter Form untuk memilih Bulan/Tahun -->
        <form action="{{ route('admin.reports') }}" method="GET" class="filter-form">
            <label for="month">Pilih Bulan:</label>
            <select name="month" id="month">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <label for="year">Pilih Tahun:</label>
            <select name="year" id="year">
                @for ($i = \Carbon\Carbon::now()->year; $i >= \Carbon\Carbon::now()->year - 5; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            
            <button type="submit">Filter</button>
        </form>

        @if($peminjaman->isEmpty())
            <p>Tidak ada data peminjaman yang tercatat untuk bulan ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID Pinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tgl. Jatuh Tempo</th>
                        <th>Tgl. Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $item)
                    <tr>
                        <td>{{ $item->peminjaman_id }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                        
                        <!-- PENTING: Menggunakan ?-> (Nullsafe Operator) -->
                        <td>{{ $item->anggota?->nama ?? 'Anggota Tidak Dikenal' }}</td>
                        
                        <!-- PENTING: Menggunakan ?-> (Nullsafe Operator) -->
                        <td>{{ $item->buku?->judul ?? 'Buku Tidak Dikenal' }}</td>
                        
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                        <td>{{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') : 'Belum Kembali' }}</td>
                        <td>
                            <span class="status-{{ $item->status }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>