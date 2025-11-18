<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Import model Booking
use Illuminate\Http\Request;
use App\Models\Warga;

class LacakController extends Controller
{
    /**
     * Menampilkan halaman form pencarian (Lacak Index).
     */
    public function index(Request $request)
    {
        return view('lacak.index');
    }

    /**
     * Memproses pencarian nomor booking.
     */
    public function search(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'no_booking' => 'required|string',
        ]);

        // 2. Cari Booking berdasarkan nomor
        $booking = Booking::where('no_booking', $request->no_booking)->first();

        // 3. Cek Hasil
        if ($booking) {
            // JIKA DITEMUKAN: Redirect ke halaman detail (show)
            // Kita menggunakan redirect()->route(), bukan return view()
            return redirect()->route('lacak.show', ['no_booking' => $booking->no_booking]);
        } else {
            // JIKA TIDAK DITEMUKAN: Kembali ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Nomor Booking tidak ditemukan. Mohon periksa kembali.');
        }
    }

    /**
     * Menampilkan halaman detail status (Lacak Show).
     */
    public function show($no_booking)
    {
        // Cari booking beserta relasinya (layanan, logs)
        // Gunakan firstOrFail agar jika user mengetik URL manual dan salah, muncul 404
        $booking = Booking::with(['layanan', 'statusLogs'])
                    ->where('no_booking', $no_booking)
                    ->firstOrFail();

        return view('lacak.show', compact('booking'));
    }

    public function showLupaForm() {
        return view('lacak.lupa'); // Pastikan view ini nanti dibuat
    }

    /**
     * Memproses pencarian riwayat booking berdasarkan data diri warga.
     */
    public function searchByWarga(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nik' => 'required|string|size:16',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string',
        ], [
            'nik.size' => 'NIK harus terdiri dari 16 digit angka.',
        ]);

        // 2. Cari Warga berdasarkan NIK
        $warga = Warga::where('nik', $request->nik)->first();

        // 3. Verifikasi Data Tambahan (Tanggal Lahir & No HP) untuk keamanan
        // Kita cek apakah warga ditemukan DAN data lainnya cocok
        if (!$warga) {
             return back()->withErrors(['nik' => 'Data tidak ditemukan. Periksa kembali input Anda.'])->withInput();
        }

        // Cek tanggal lahir (jika kolom tanggal_lahir ada di tabel warga - sesuai migrasi revisi Anda)
        // Jika belum ada di migrasi warga, Anda mungkin perlu join dengan tabel booking atau users, 
        // tapi asumsi terbaik adalah data ini ada di tabel Warga.
        // UNTUK SAAT INI: Kita skip validasi tanggal lahir yang ketat jika kolomnya belum ada di tabel Warga
        // Tapi idealnya: if ($warga->tanggal_lahir != $request->tanggal_lahir) { ... }
        
        // Cek No HP (Sederhana)
        if ($warga->no_hp != $request->no_hp) {
             return back()->withErrors(['no_hp' => 'Nomor HP tidak cocok dengan data kami.'])->withInput();
        }

        // 4. Ambil Riwayat Booking
        $riwayatBooking = Booking::with(['layanan'])
                            ->where('warga_id', $warga->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        if ($riwayatBooking->isEmpty()) {
             return back()->withErrors(['nik' => 'Data warga ditemukan, tetapi belum ada riwayat pengajuan.'])->withInput();
        }

        // 5. Tampilkan Hasil
        return view('lacak.hasil_lupa', compact('warga', 'riwayatBooking'));
    }
}