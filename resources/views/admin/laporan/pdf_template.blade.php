<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Laporan Statistik Pelayanan' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Styling dasar untuk PDF */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            -webkit-print-color-adjust: exact; /* Penting untuk warna latar belakang */
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #222;
            font-weight: bold;
            line-height: 1.2;
            margin: 0 0 10px;
        }
        h1 { font-size: 24px; }
        h2 { font-size: 20px; }
        h3 { font-size: 16px; }
        p {
            margin: 0 0 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .header img {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .date-range {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11px;
            color: #555;
        }
        .statistic-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Sesuaikan jarak antar kartu */
            margin-bottom: 20px;
            justify-content: center; /* Pusatkan kartu */
        }
        .card {
            background-color: #f8f8f8;
            border-radius: 8px;
            padding: 15px;
            flex: 0 0 calc(25% - 15px); /* 4 kartu per baris, sesuaikan jika perlu */
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
            min-width: 150px; /* Lebar minimum agar tidak terlalu kecil */
        }
        .card.wide {
             flex: 0 0 calc(50% - 15px); /* 2 kartu per baris */
        }
        .card-title {
            font-size: 10px;
            color: #ffffffff;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .card-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .card.bg-blue-500 { background-color: #3b82f6; color: white; }
        .card.bg-green-500 { background-color: #22c55e; color: white; }
        .card.bg-yellow-500 { background-color: #eab308; color: white; }
        .card.bg-red-500 { background-color: #ef4444; color: white; }
        .card.bg-purple-500 { background-color: #a855f7; color: white; }
        .card.bg-teal-500 { background-color: #14b8a6; color: white; }


        .section-title {
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #eee;
            padding: 8px;
            text-align: left;
            font-size: 9px;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .status-badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            color: white;
            white-space: nowrap;
        }
        .bg-green-100 { background-color: #d1fae5; color: #065f46; } /* Contoh warna badge, sesuaikan */
        .bg-red-100 { background-color: #fee2e2; color: #991b1b; }
        .bg-yellow-100 { background-color: #fffbeb; color: #92400e; }
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
            {{-- <img src="path/to/your/logo.png" alt="Logo Kelurahan"> --}}
            <h1>{{ $title ?? 'Laporan Statistik Pelayanan Kelurahan' }}</h1>
            <p>Sistem Informasi Pelayanan Publik</p>
        </div>

        <p class="date-range">Periode Laporan: {{ $startDate }} s/d {{ $endDate }}</p>

        <h3 class="section-title">Ringkasan Statistik Utama</h3>
        <div class="statistic-cards">
            <div class="card bg-blue-500">
                <div class="card-title">Total Booking</div>
                <div class="card-value">{{ $totalBooking }}</div>
            </div>
            <div class="card bg-green-500">
                <div class="card-title">Booking Selesai</div>
                <div class="card-value">{{ $bookingSelesai }}</div>
            </div>
            <div class="card bg-yellow-500">
                <div class="card-title">Booking Pending</div>
                <div class="card-value">{{ $bookingPending }}</div>
            </div>
            <div class="card bg-red-500">
                <div class="card-title">Booking Ditolak</div>
                <div class="card-value">{{ $bookingDitolak }}</div>
            </div>
        </div>

        <h3 class="section-title">Statistik Tambahan</h3>
        <div class="statistic-cards">
            <div class="card wide bg-purple-500">
                <div class="card-title">Total Warga Terdaftar</div>
                <div class="card-value">{{ $totalWarga }}</div>
            </div>
            <div class="card wide bg-teal-500">
                <div class="card-title">Total Petugas/Admin</div>
                <div class="card-value">{{ $totalPetugas }}</div>
            </div>
        </div>

        <h3 class="section-title">5 Layanan Paling Populer</h3>
        <table>
            <thead>
                <tr>
                    <th>Layanan</th>
                    <th class="text-right">Jumlah Booking</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($layananPopuler as $layanan)
                    <tr>
                        <td>{{ $layanan->nama_layanan }}</td>
                        <td class="text-right">{{ $layanan->bookings_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Tidak ada data layanan populer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3 class="section-title">Ringkasan Status Booking</h3>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookingStatusCounts as $status => $count)
                    <tr>
                        <td>{{ $status }}</td> {{-- Status sudah di-format di controller --}}
                        <td class="text-right">{{ $count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">Tidak ada ringkasan status booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3 class="section-title">10 Booking Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>No. Booking</th>
                    <th>Nama Warga</th>
                    <th>Layanan</th>
                    <th>Tanggal Booking</th>
                    <th>Status Berkas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->nomor_booking }}</td>
                        <td>{{ $booking->user->nama_lengkap ?? 'N/A' }}</td> {{-- Asumsi relasi ke user --}}
                        <td>{{ $booking->layanan->nama_layanan ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->jadwal_janji_temu)->format('d M Y') }}</td>
                        <td>
                            <span class="status-badge 
                                @if($booking->status_berkas == 'SELESAI') bg-green-100
                                @elseif($booking->status_berkas == 'DITOLAK') bg-red-100
                                @else bg-yellow-100
                                @endif
                            ">
                                {{ Str::title(str_replace('_', ' ', $booking->status_berkas)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada booking terbaru dalam periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh Sistem Informasi Pelayanan Publik Kelurahan Klender.<br>
            Dicetak pada: {{ $date_generated }}
        </div>
    </div>
</body>
</html>