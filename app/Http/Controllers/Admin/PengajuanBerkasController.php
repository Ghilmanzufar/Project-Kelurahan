<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // Import model Booking
use App\Models\BookingStatusLog; // Import model BookingStatusLog
use App\Models\Layanan; // Import model Layanan untuk filter
use App\Models\User; // Import model User untuk filter petugas
use Illuminate\Support\Facades\Auth; // Import Auth untuk mencatat siapa yang melakukan aksi

class PengajuanBerkasController extends Controller
{
    /**
     * Menampilkan daftar pengajuan berkas (dengan filter).
     */
    public function index(Request $request)
    {
        // Data untuk mengisi dropdown filter
        $allLayanan = Layanan::orderBy('nama_layanan')->get();
        $allPetugas = User::whereIn('role', ['petugas_layanan', 'super_admin', 'pimpinan'])
                          ->orderBy('nama_lengkap')->get();

        // Daftar semua kemungkinan status berkas
        $allStatus = [
            'JANJI TEMU DIBUAT', // Ini seharusnya tidak muncul di sini, tapi kita sertakan untuk kelengkapan
            'JANJI TEMU DIKONFIRMASI',
            'DITOLAK',
            'BERKAS DITERIMA',
            'VERIFIKASI BERKAS',
            'SEDANG DIPROSES',
            'SELESAI',
        ];

        // Mulai query dasar
        // Memuat relasi 'warga', 'layanan', 'petugas', dan 'statusLogs' (untuk riwayat di modal)
        $query = Booking::with(['warga', 'layanan', 'petugas', 'statusLogs' => function($q){
            $q->orderBy('created_at', 'asc'); // Urutkan log dari yang paling lama ke terbaru
        }]);

        // Terapkan filter secara kondisional
        $query->when($request->filled('status_berkas'), function ($q) use ($request) {
            return $q->where('status_berkas', $request->status_berkas);
        }, function ($q) {
            // Default: Tampilkan semua kecuali yang masih "JANJI TEMU DIBUAT" atau "DITOLAK"
            // Karena yang 'JANJI TEMU DIBUAT' sudah dihandle di AdminBookingController
            // Dan yang 'DITOLAK' sudah selesai prosesnya.
            return $q->whereNotIn('status_berkas', ['JANJI TEMU DIBUAT', 'DITOLAK']);
        });

        $query->when($request->filled('layanan_id'), function ($q) use ($request) {
            return $q->where('layanan_id', $request->layanan_id);
        });

        $query->when($request->filled('petugas_id'), function ($q) use ($request) {
            return $q->where('petugas_id', $request->petugas_id);
        });

        // Eksekusi query dengan paginasi
        $pengajuanBerkas = $query->orderBy('updated_at', 'desc') // Urutkan berdasarkan update terakhir
                                  ->paginate(10)
                                  ->appends($request->except('page')); // Agar paginasi tetap membawa filter

        return view('admin.pengajuan.index', [
            'pengajuanBerkas' => $pengajuanBerkas,
            'allLayanan' => $allLayanan,
            'allPetugas' => $allPetugas,
            'allStatus' => $allStatus, // Kirim daftar semua status
        ]);
    }

    /**
     * Mengupdate status berkas dan menambahkan log.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status_baru' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        // Pastikan status_baru adalah status yang valid (opsional, tapi disarankan)
        $validStatus = [
            'JANJI TEMU DIKONFIRMASI',
            'BERKAS DITERIMA',
            'VERIFIKASI BERKAS',
            'SEDANG DIPROSES',
            'SELESAI',
        ];

        if (!in_array($request->status_baru, $validStatus)) {
            return redirect()->back()->with('error', 'Status yang dipilih tidak valid.');
        }

        // 1. Perbarui status_berkas di model Booking
        $booking->status_berkas = $request->status_baru;
        $booking->save();

        // 2. Buat log status baru
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => $request->status_baru,
            'petugas_id' => Auth::id(), // Petugas yang melakukan update
            'deskripsi' => $request->deskripsi ?? 'Status diperbarui oleh ' . Auth::user()->nama_lengkap,
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berkas berhasil diperbarui.');
    }
}