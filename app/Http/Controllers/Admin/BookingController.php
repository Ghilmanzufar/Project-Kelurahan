<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking; // Import model Booking
use App\Models\BookingStatusLog; // Import model BookingStatusLog
use App\Models\Layanan;       // <<< TAMBAHKAN INI
use App\Models\User;         // <<< TAMBAHKAN INI
use Illuminate\Support\Facades\Auth; // Import Auth untuk mencatat siapa yang melakukan aksi

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking yang perlu dikonfirmasi (dengan filter baru).
     */
    public function index(Request $request)
    {
        // --- Mulai Logika Filter ---

        // 1. Ambil data untuk mengisi dropdown filter
        $allLayanan = Layanan::orderBy('nama_layanan')->get();
        $allPetugas = User::whereIn('role', ['petugas_layanan', 'super_admin', 'pimpinan'])
                          ->orderBy('nama_lengkap')->get();

        // 2. Mulai query dasar: HANYA booking yang menunggu konfirmasi
        $query = Booking::with(['layanan', 'warga', 'petugas'])
                        ->where('status_berkas', 'JANJI TEMU DIBUAT');

        // 3. Terapkan filter tambahan secara kondisional

        
        // Filter berdasarkan Tanggal Janji Temu (Baru)
        $query->when($request->filled('tanggal_janji_temu'), function ($q) use ($request) {
            return $q->whereDate('jadwal_janji_temu', ($request->tanggal_janji_temu));
        });

        // Filter berdasarkan Layanan (Tetap ada)
        $query->when($request->filled('layanan_id'), function ($q) use ($request) {
            return $q->where('layanan_id', $request->layanan_id);
        });

        // Filter berdasarkan Petugas (Tetap ada)
        $query->when($request->filled('petugas_id'), function ($q) use ($request) {
            return $q->where('petugas_id', $request->petugas_id);
        });

        // 4. Terapkan Logika Sortir (Baru)
        $sortOrder = $request->input('sort', 'terbaru'); // Default 'terbaru'
        if ($sortOrder == 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else if ($sortOrder == 'jadwal_terdekat') {
            $query->orderBy('jadwal_janji_temu', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // Default (terbaru)
        }

        // --- Selesai Logika Filter & Sortir ---

        // 5. Eksekusi query dengan paginasi
        $bookings = $query->paginate(10)
                           ->appends($request->except('page')); // Agar paginasi tetap membawa filter

        // 6. Kirim data ke view
        return view('admin.booking.index', [
            'bookings' => $bookings,
            'allLayanan' => $allLayanan,
            'allPetugas' => $allPetugas,
        ]);
    }

    /**
     * Mengkonfirmasi booking.
     */
    public function konfirmasi(Booking $booking)
    {
        // 1. Ubah status booking menjadi 'JANJI TEMU DIKONFIRMASI'
        $booking->status_berkas = 'JANJI TEMU DIKONFIRMASI';
        $booking->save();

        // 2. Buat log status baru
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => 'JANJI TEMU DIKONFIRMASI',
            'petugas_id' => Auth::id(), // <<< DIPERBAIKI
            'deskripsi' => 'Booking dikonfirmasi oleh ' . Auth::user()->nama_lengkap, // <<< DIPERBAIKI
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dikonfirmasi.');
    }

    /**
     * Menolak booking.
     */
    public function tolak(Booking $booking)
    {
        // 1. Ubah status booking menjadi 'DITOLAK'
        $booking->status_berkas = 'DITOLAK';
        $booking->save();

        // 2. Buat log status baru
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => 'DITOLAK',
            'petugas_id' => Auth::id(), // <<< DIPERBAIKI
            'deskripsi' => 'Booking ditolak oleh ' . Auth::user()->nama_lengkap, // <<< DIPERBAIKI
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil ditolak.');
    }
}