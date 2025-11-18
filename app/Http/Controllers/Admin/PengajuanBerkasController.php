<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 
use App\Models\BookingStatusLog; 
use App\Models\Layanan; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <<< TAMBAHKAN INI (untuk DB::raw())
use Illuminate\Support\Str;      // <<< TAMBAHKAN INI (untuk Str::title())
use Carbon\Carbon; 
use PDF;

class PengajuanBerkasController extends Controller
{
    public function __construct()
    {
        // Ganti authorize menjadi middleware can
        $this->middleware('can:kelola-berkas');
    }

    /**
     * Menampilkan daftar pengajuan berkas (dengan filter).
     */
    public function index(Request $request)
    {
        // Data untuk mengisi dropdown filter
        $allLayanan = Layanan::orderBy('nama_layanan')->get();
        $allPetugas = User::whereIn('role', ['petugas_layanan', 'super_admin', 'pimpinan'])
                          ->orderBy('nama_lengkap')->get();

        $allStatus = [
            'JANJI TEMU DIBUAT',
            'JANJI TEMU DIKONFIRMASI',
            'DITOLAK',
            'BERKAS DITERIMA',
            'VERIFIKASI BERKAS',
            'SEDANG DIPROSES',
            'SELESAI',
        ];

        // Mulai query dasar
        $query = Booking::with(['warga', 'layanan', 'petugas', 'statusLogs' => function($q){
            $q->orderBy('created_at', 'asc'); 
        }]);

        // ===============================================
        // <<< LOGIKA PENCARIAN BARU >>>
        // ===============================================
        // Terapkan filter pencarian (No. Booking, NIK Warga, Nama Warga)
        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = $request->search;
            
            return $q->where(function($subQuery) use ($searchTerm) {
                // 1. Cari di tabel booking (no_booking)
                $subQuery->where('no_booking', 'like', '%' . $searchTerm . '%')
                         
                         // 2. Cari di relasi 'warga' (nama_lengkap atau nik)
                         ->orWhereHas('warga', function($wargaQuery) use ($searchTerm) {
                             $wargaQuery->where('nama_lengkap', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('nik', 'like', '%' . $searchTerm . '%');
                         });
            });
        });
        // ===============================================

        // Terapkan filter dropdown (yang sudah ada)
        $query->when($request->filled('status_berkas'), function ($q) use ($request) {
            return $q->where('status_berkas', $request->status_berkas);
        }, function ($q) {
            // Default filter (jika status tidak diisi)
            return $q->whereNotIn('status_berkas', ['JANJI TEMU DIBUAT', 'DITOLAK']);
        });

        $query->when($request->filled('layanan_id'), function ($q) use ($request) {
            return $q->where('layanan_id', $request->layanan_id);
        });

        $query->when($request->filled('petugas_id'), function ($q) use ($request) {
            return $q->where('petugas_id', $request->petugas_id);
        });

        // Eksekusi query dengan paginasi
        $pengajuanBerkas = $query->orderBy('updated_at', 'desc')
                                  ->paginate(10)
                                  ->appends($request->except('page')); 

        return view('admin.pengajuan.index', [
            'pengajuanBerkas' => $pengajuanBerkas,
            'allLayanan' => $allLayanan,
            'allPetugas' => $allPetugas,
            'allStatus' => $allStatus,
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

    /**
     * Mengunduh daftar pengajuan berkas yang difilter sebagai PDF.
     */
    public function downloadPdf(Request $request)
    {
        // --- LOGIKA FILTER DAN PENCARIAN (DISALIN DARI METHOD index()) ---
        
        // <<< PERBAIKAN 1: Gunakan Model 'Booking', bukan 'PengajuanBerkas' >>>
        $query = Booking::with(['warga', 'layanan', 'petugas', 'statusLogs' => function($q){
            $q->orderBy('created_at', 'asc'); 
        }]);

        // Terapkan filter pencarian (No. Booking, NIK Warga, Nama Warga)
        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = $request->search;
            
            return $q->where(function($subQuery) use ($searchTerm) {
                $subQuery->where('no_booking', 'like', '%' . $searchTerm . '%')
                         
                         // <<< PERBAIKAN 2: Gunakan relasi 'warga', bukan 'user' >>>
                         ->orWhereHas('warga', function($wargaQuery) use ($searchTerm) {
                             $wargaQuery->where('nama_lengkap', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('nik', 'like', '%' . $searchTerm . '%');
                         });
            });
        });

        // Terapkan filter dropdown (yang sudah ada)
        $query->when($request->filled('status_berkas'), function ($q) use ($request) {
            return $q->where('status_berkas', $request->status_berkas);
        }, function ($q) {
            // Default filter
            return $q->whereNotIn('status_berkas', ['JANJI TEMU DIBUAT', 'DITOLAK']);
        });

        $query->when($request->filled('layanan_id'), function ($q) use ($request) {
            return $q->where('layanan_id', $request->layanan_id);
        });

        $query->when($request->filled('petugas_id'), function ($q) use ($request) {
            return $q->where('petugas_id', $request->petugas_id);
        });
        // --- AKHIR LOGIKA FILTER ---

        // <<< PENTING: Gunakan get() BUKAN paginate() untuk PDF >>>
        $pengajuanBerkas = $query->get(); // Ambil semua hasil yang difilter

        // Data yang akan dikirim ke view PDF
        $data = [
            'pengajuanBerkas' => $pengajuanBerkas,
            'title' => 'Laporan Pengajuan Berkas',
            'filter_info' => $this->getFilterInfo($request), // Method helper untuk info filter
            'date_generated' => Carbon::now()->format('d M Y H:i:s'),
        ];

        // Muat view untuk PDF dan konversi
        $pdf = \PDF::loadView('admin.pengajuan.pdf_template', $data); // Panggil PDF dengan benar

        // Unduh PDF
        return $pdf->download('laporan-pengajuan-berkas-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    /**
     * Helper method untuk mendapatkan string informasi filter.
     * (Tambahkan ini jika belum ada)
     */
    private function getFilterInfo(Request $request)
    {
        $info = [];
        if ($request->filled('search')) {
            $info[] = 'Kata Kunci: "' . $request->input('search') . '"';
        }
        if ($request->filled('status_berkas')) {
            $info[] = 'Status: ' . Str::title(str_replace('_', ' ', $request->input('status_berkas')));
        }
        if ($request->filled('layanan_id')) {
            $layanan = Layanan::find($request->input('layanan_id'));
            if ($layanan) {
                $info[] = 'Layanan: ' . $layanan->nama_layanan;
            }
        }
        
        return count($info) > 0 ? implode(', ', $info) : 'Semua Data (Default)';
    }
}