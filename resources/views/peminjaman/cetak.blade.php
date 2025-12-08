<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Peminjaman - {{ $peminjaman->id_peminjaman }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 9pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            text-align: left;
            padding: 6px;
            vertical-align: top;
        }

        table th {
            width: 140px;
            font-weight: bold;
        }

        .status-box {
            text-align: center;
            border: 2px dashed #333;
            padding: 10px;
            margin: 20px 0;
            font-weight: bold;
            font-size: 12pt;
            text-transform: uppercase;
        }

        .footer {
            text-align: center;
            font-size: 8pt;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        /* CSS Khusus Cetak */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                border: none;
                width: 100%;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()"> {{-- Otomatis muncul dialog print --}}

    <div class="container">
        <div class="header">
            <h1>Perpustakaan Digital</h1>
            <p>Jalan Pustaka No. 1, Kota Ilmu</p>
            <p>Telp: (021) 1234-5678</p>
        </div>

        <table>
            <tr>
                <th>No. Transaksi</th>
                <td>: {{ $peminjaman->id_peminjaman }}</td>
            </tr>
            <tr>
                <th>Tanggal Pinjam</th>
                <td>: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Jatuh Tempo</th>
                <td>: {{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Peminjam</th>
                <td>: {{ $peminjaman->anggota->nama }} (ID: {{ $peminjaman->anggota->anggota_id }})</td>
            </tr>
        </table>

        <div style="border-top: 1px solid #ddd; margin: 10px 0;"></div>

        <table>
            <tr>
                <th>Judul Buku</th>
                <td>: <strong>{{ $peminjaman->buku->judul }}</strong></td>
            </tr>
            <tr>
                <th>Pengarang</th>
                <td>: {{ $peminjaman->buku->pengarang }}</td>
            </tr>
        </table>

        <div class="status-box">
            STATUS: {{ strtoupper($peminjaman->status) }}
        </div>

        @if ($peminjaman->denda && $peminjaman->denda->jumlah > 0)
            <div style="text-align: right; margin-top: 10px;">
                <p><strong>Denda Keterlambatan:</strong></p>
                <p style="font-size: 14pt;">Rp {{ number_format($peminjaman->denda->jumlah, 0, ',', '.') }}</p>
                <p style="font-size: 9pt; font-style: italic;">Status: {{ $peminjaman->denda->status }}</p>
            </div>
        @endif

        <div class="footer">
            Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
            <br>
            Simpan struk ini sebagai bukti peminjaman/pengembalian yang sah.
        </div>
    </div>

</body>

</html>
