<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Laporan Pengajuan Berkas' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            -webkit-print-color-adjust: exact;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3 {
            color: #222;
            font-weight: bold;
            line-height: 1.2;
            margin: 0 0 10px;
        }
        h1 { font-size: 20px; text-align: center; }
        h2 { font-size: 16px; margin-top: 20px; }
        p { margin: 0 0 8px; }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .filter-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #eee;
            padding: 6px 8px; /* Padding lebih kecil untuk tabel padat */
            text-align: left;
            font-size: 9px;
            vertical-align: top; /* Agar konten di sel sejajar di atas */
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            color: white;
            white-space: nowrap;
        }
        .bg-green-100 { background-color: #065f46; color: white; } /* SELESAI */
        .bg-red-100 { background-color: #991b1b; color: white; }    /* DITOLAK */
        .bg-yellow-100 { background-color: #92400e; color: white; } /* PROSES LAIN */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 8px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title ?? 'Laporan Pengajuan Berkas' }}</h1>
            <p>Sistem Informasi Pelayanan Publik Kelurahan Klender</p>
        </div>

        <p class="filter-info">Filter Aktif: {{ $filter_info }}</p>

        <h2>Daftar Pengajuan Berkas</h2>
        <table>
            <thead>
                <tr>
                    <th>No. Booking</th>
                    <th>Nama Warga</th>
                    <th>Layanan</th>
                    <th>Jadwal Temu</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuanBerkas as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->no_booking }}</td>
                        <td>{{ $pengajuan->warga->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ $pengajuan->layanan->nama_layanan ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($pengajuan->jadwal_janji_temu)->format('d M Y H:i') }}</td>
                        <td>
                            <span class="status-badge 
                                @if($pengajuan->status_berkas == 'SELESAI') bg-green-100
                                @elseif($pengajuan->status_berkas == 'DITOLAK') bg-red-100
                                @else bg-yellow-100
                                @endif
                            ">
                                {{ Str::title(str_replace('_', ' ', $pengajuan->status_berkas)) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data pengajuan berkas yang sesuai dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh Sistem Informasi Pelayanan Publik.<br>
            Dicetak pada: {{ $date_generated }}
        </div>
    </div>
</body>
</html>