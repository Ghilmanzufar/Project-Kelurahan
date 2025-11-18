<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Laporan Data Warga' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Helvetica', sans-serif; /* Font standar yang aman untuk PDF */
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        h2 {
            font-size: 14px;
            font-weight: normal;
            color: #555;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .filter-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 15px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 9px;
            text-align: left;
        }
        table th {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 8px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title ?? 'Laporan Data Warga' }}</h1>
            <h2>Sistem Informasi Pelayanan Pertanahan Kelurahan Klender</h2>
        </div>

        <p class="filter-info">
            <strong>Filter Aktif:</strong> {{ $filter_info }}<br>
            <strong>Total Data:</strong> {{ $warga->count() }} Warga
        </p>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Lahir</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($warga as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>'{{ $item->nik }}</td> {{-- Tambahkan petik agar tidak jadi angka --}}
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d M Y') : '-' }}</td>
                        <td>{{ $item->no_hp ?? '-' }}</td>
                        <td>{{ $item->email ?? '-' }}</td>
                        <td>{{ $item->alamat_terakhir ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data warga yang ditemukan sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem.
            <br>
            Dicetak pada: {{ $date_generated }}
        </div>
    </div>
</body>
</html>