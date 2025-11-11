<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Import model Booking
use Illuminate\Http\Request;
use App\Models\Warga;

class LacakController extends Controller
{
    /**
     * Menampilkan halaman formulir untuk memasukkan nomor booking.
     */
    public function index()
    {
        return view('lacak.index');
    }

    /**
     * Memproses pencarian nomor booking dari formulir.
     * Meredirect ke halaman hasil jika ditemukan, atau kembali dengan error.
     */
    public function search(Request $request)
    {
        $request->validate([
            'nomor_booking' => 'required|string|min:10|max:20', // Sesuaikan validasi dengan format nomor booking Anda
        ], [
            'nomor_booking.required' => 'Nomor Booking / Registrasi wajib diisi.',
            'nomor_booking.min' => 'Nomor Booking terlalu pendek.',
            'nomor_booking.max' => 'Nomor Booking terlalu panjang.',
        ]);

        $nomorBooking = $request->input('nomor_booking');

        // Cari booking berdasarkan nomor booking
        $booking = Booking::where('no_booking', $nomorBooking)->first();

        if ($booking) {
            // Jika booking ditemukan, redirect ke halaman show dengan nomor booking
            return redirect()->route('lacak.show', ['no_booking' => $nomorBooking]);
        } else {
            // Jika tidak ditemukan, kembali ke halaman index dengan error
            return redirect()->route('lacak.index')->withErrors(['nomor_booking' => 'Nomor Booking / Registrasi tidak ditemukan.']);
        }
    }

    /**
     * Menampilkan detail pelacakan untuk nomor booking tertentu.
     */
    public function show($no_booking)
    {
        // Cari booking beserta relasi layanan, petugas, dan status logs
        $booking = Booking::where('no_booking', $no_booking)
                            ->with(['layanan', 'petugas', 'statusLogs'])
                            ->firstOrFail(); // Akan 404 jika tidak ditemukan

        // Definisikan urutan langkah-langkah progres secara statis
        $progresSteps = [
            'JANJI TEMU DIBUAT' => '1. Janji Temu Dibuat',
            'BERKAS DITERIMA' => '2. Berkas Diterima Petugas',
            'VERIFIKASI BERKAS' => '3. Verifikasi Berkas (Lengkap)',
            'SEDANG DIPROSES' => '4. Diproses Kasi/Lurah',
            'SELESAI' => '5. Selesai / Dapat Diambil',
        ];

        // Dapatkan status terakhir dari log
        $latestStatus = $booking->statusLogs->first()->status ?? $booking->status;

        return view('lacak.show', compact('booking', 'progresSteps', 'latestStatus'));
    }

    // ===============================================
    // <<< METHOD BARU UNTUK FITUR LUPA BOOKING >>>
    // ===============================================

    /**
     * Menampilkan halaman formulir Lupa Nomor Booking.
     */
    public function showLupaForm()
    {
        return view('lacak.lupa'); // View ini akan kita buat di Langkah 3
    }

    /**
     * Memproses pencarian riwayat booking berdasarkan data diri warga.
     */
    public function searchByWarga(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:15',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
        ]);

        // 1. Cari Warga berdasarkan data yang cocok
        $warga = Warga::where('nik', $request->nik)
                     ->where('tanggal_lahir', $request->tanggal_lahir)
                     ->where('no_hp', $request->no_hp)
                     ->first();

        // 2. Jika Warga tidak ditemukan
        if (!$warga) {
            return redirect()->route('lacak.showLupaForm')
                             ->withErrors(['gagal' => 'Data NIK, Tanggal Lahir, atau Nomor HP tidak cocok. Pastikan data yang Anda masukkan benar.'])
                             ->withInput(); // Mengembalikan input lama (NIK, dll)
        }

        // 3. Jika Warga ditemukan, ambil semua booking miliknya
        // Kita gunakan relasi 'bookings' yang baru dibuat di Model Warga
        $bookings = $warga->bookings()
                          ->with(['layanan', 'statusLogs']) // Ambil juga data layanan & status
                          ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
                          ->get();

        // 4. Kirim data ke view hasil pencarian
        return view('lacak.hasil_lupa', compact('warga', 'bookings')); // View ini akan kita buat di Langkah 3
    }
}