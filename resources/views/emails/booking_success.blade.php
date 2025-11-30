<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: #ffffff; max-width: 600px; margin: auto; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #059669; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #059669; margin: 0; font-size: 24px; }
        .content { line-height: 1.6; color: #333333; }
        .booking-info { background-color: #ecfdf5; padding: 20px; border-radius: 8px; border: 1px solid #d1fae5; margin: 20px 0; text-align: center; }
        .booking-code { font-size: 28px; font-weight: bold; color: #059669; letter-spacing: 2px; margin: 10px 0; }
        .footer { text-align: center; font-size: 12px; color: #777777; margin-top: 30px; border-top: 1px solid #eeeeee; padding-top: 20px; }
        .qr-code { margin: 20px auto; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Janji Temu Berhasil Dibuat!</h1>
            <p>SiPentas - Kelurahan Klender</p>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ $booking->warga->nama_lengkap }}</strong>!</p>
            <p>Terima kasih telah menggunakan layanan kami. Pendaftaran janji temu Anda telah berhasil dikonfirmasi.</p>

            <div class="booking-info">
                <p style="margin: 0;">Nomor Booking Anda:</p>
                <div class="booking-code">{{ $booking->no_booking }}</div>

                {{-- QR Code (Akan kita lampirkan sebagai gambar) --}}
                <div style="display: inline-block; padding: 10px; background: white;">
                    {!! QrCode::size(200)->generate($booking->no_booking) !!}
                </div>

                <p style="margin-top: 10px;"><strong>Layanan:</strong> {{ $booking->layanan->nama_layanan }}</p>
                <p><strong>Jadwal:</strong> {{ \Carbon\Carbon::parse($booking->jadwal_janji_temu)->isoFormat('dddd, D MMMM Y') }}</p>
                <p><strong>Waktu/Sesi:</strong> {{ \Carbon\Carbon::parse($booking->jadwal_janji_temu)->format('H:i') }} WIB</p>
            </div>

            <p><strong>PENTING:</strong></p>
            <ul>
                <li>Simpan email ini sebagai bukti pendaftaran.</li>
                <li>Tunjukkan <strong>QR Code</strong> atau Nomor Booking di atas kepada petugas saat kedatangan untuk <em>check-in</em>.</li>
                <li>Mohon datang tepat waktu sesuai jadwal yang dipilih.</li>
                <li>Pastikan Anda membawa seluruh <strong>dokumen persyaratan (Asli & Fotokopi)</strong> yang telah diinformasikan sebelumnya.</li>
            </ul>

            <p>Anda dapat melacak status pengajuan Anda kapan saja melalui menu "Lacak Pengajuan" di website kami.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Kelurahan Klender. All rights reserved.</p>
            <p>Ini adalah email otomatis, mohon jangan membalas email ini.</p>
        </div>
    </div>
</body>
</html>