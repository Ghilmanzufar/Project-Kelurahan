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
    public function __construct()
    {
        // Ganti authorize menjadi middleware can
        $this->middleware('can:kelola-berkas');
    }
    
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

    /**
     * Menampilkan halaman Scanner QR Code.
     */
    public function scan()
    {
        return view('admin.booking.scan');
    }

    /**
     * Memproses data QR Code yang discan via AJAX.
     */
    public function verifyQr(Request $request)
    {
        $request->validate([
            'no_booking' => 'required|string'
        ]);

        // 1. Cari Data Booking
        $booking = Booking::with(['warga', 'layanan'])
                    ->where('no_booking', $request->no_booking)
                    ->first();

        if (!$booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Booking Tidak Ditemukan!'
            ], 404);
        }

        // 2. Validasi Tanggal (Opsional: Hanya boleh scan jika jadwalnya hari ini)
        if (!$booking->jadwal_janji_temu->isToday()) {
             return response()->json([
                'status' => 'error',
                'message' => 'Jadwal Booking Bukan Hari Ini! (' . $booking->jadwal_janji_temu->format('d M Y') . ')'
            ], 400);
        }

        // 3. Cek Status (Jangan update jika sudah selesai/ditolak)
        if (in_array($booking->status_berkas, ['SELESAI', 'DITOLAK'])) {
             return response()->json([
                'status' => 'warning',
                'message' => 'Booking ini sudah berstatus: ' . $booking->status_berkas
            ], 200); // 200 OK tapi warning
        }

        // 4. Update Status Otomatis (Check-in)
        // Kita ubah jadi 'BERKAS DITERIMA' (artinya warga sudah datang dan lapor)
        $booking->update(['status_berkas' => 'BERKAS DITERIMA']);

        // 5. Catat Log
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => 'BERKAS DITERIMA',
            'deskripsi' => 'Warga melakukan Check-in via QR Code Scanner di loket.',
            'petugas_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Check-in Berhasil! Status diperbarui.',
            'data' => [
                'nama' => $booking->warga->nama_lengkap,
                'layanan' => $booking->layanan->nama_layanan,
                'jam' => $booking->jadwal_janji_temu->format('H:i') . ' WIB'
            ]
        ]);
    }
}