<!DOCTYPE html>
<html>
<head>
    <title>Bukti Booking - SiPentas</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .container { width: 100%; margin: 0 auto; text-align: center; }
        .header { border-bottom: 2px solid #047857; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { color: #047857; margin: 0; }
        .box { border: 1px solid #ccc; padding: 20px; border-radius: 8px; background-color: #f9f9f9; width: 80%; margin: 0 auto; }
        .code { font-size: 24px; font-weight: bold; color: #047857; letter-spacing: 2px; margin: 15px 0; }
        .info-table { width: 100%; margin-top: 20px; text-align: left; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 140px; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; }
        .qr-wrapper { margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BUKTI BOOKING ANTREAN</h1>
            <p>SiPentas - Kelurahan Klender</p>
        </div>

        <div class="box">
            <p>Halo, <strong>{{ $booking->warga->nama_lengkap }}</strong></p>
            <p>Tunjukkan bukti ini kepada petugas saat kedatangan.</p>

            <div class="code">{{ $booking->no_booking }}</div>

            {{-- QR Code (Menggunakan Base64 agar tampil di PDF) --}}
            <div class="qr-wrapper">
                {{-- Kita paksa jadi format SVG, lalu di-encode ke Base64, dan dimasukkan ke tag IMG --}}
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(150)->generate($booking->no_booking)) }}" width="150" height="150" alt="QR Code">
            </div>

            <table class="info-table">
                <tr>
                    <td class="label">Layanan</td>
                    <td>: {{ $booking->layanan->nama_layanan }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($booking->jadwal_janji_temu)->isoFormat('dddd, D MMMM Y') }}</td>
                </tr>
                <tr>
                    <td class="label">Pukul</td>
                    <td>: {{ \Carbon\Carbon::parse($booking->jadwal_janji_temu)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Lokasi</td>
                    <td>: Kantor Kelurahan Klender</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Dokumen ini diterbitkan secara otomatis oleh sistem SiPentas.</p>
            <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>
        </div>
    </div>
</body>
</html>