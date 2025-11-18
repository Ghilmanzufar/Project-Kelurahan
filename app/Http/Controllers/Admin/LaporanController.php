<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;     
use App\Models\Layanan;     
use App\Models\User;        
use Carbon\Carbon;          
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str; 
use PDF;

class LaporanController extends Controller
{
    /**
     * Terapkan Gate 'lihat-laporan' ke semua method di controller ini.
     */
    public function __construct()
    {
        $this->middleware('can:lihat-laporan');
    }

    /**
     * Menampilkan halaman laporan dengan data statistik.
     */
    public function index(Request $request)
    {
        // --- Filter Tanggal ---
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfMonth();

        // Query dasar untuk booking yang akan difilter
        $bookingsQuery = Booking::query()
                                // <<< PERBAIKAN 1 DI SINI >>>
                                ->whereBetween('jadwal_janji_temu', [$startDate, $endDate]);

        // --- Statistik Umum Booking ---
        // (clone() diperlukan agar query tidak saling menimpa)
        $totalBooking = $bookingsQuery->clone()->count();
        $bookingSelesai = $bookingsQuery->clone()->where('status_berkas', 'SELESAI')->count();
        $bookingDitolak = $bookingsQuery->clone()->where('status_berkas', 'DITOLAK')->count();
        
        // Daftar status pending
        $pendingStatus = [
            'JANJI TEMU DIBUAT', 
            'JANJI TEMU DIKONFIRMASI', 
            'BERKAS DITERIMA', 
            'VERIFIKASI BERKAS', 
            'SEDANG DIPROSES'
        ];
        $bookingPending = $bookingsQuery->clone()->whereIn('status_berkas', $pendingStatus)->count();
        
        // --- Statistik Per Layanan ---
        $layananPopuler = Layanan::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
                                    // <<< PERBAIKAN 2 DI SINI >>>
                                    $query->whereBetween('jadwal_janji_temu', [$startDate, $endDate]);
                                }])
                                ->orderBy('bookings_count', 'desc')
                                ->take(5)
                                ->get();
        
        // --- Statistik Booking per Status ---
        $bookingStatusCounts = $bookingsQuery->clone()
                                             ->select('status_berkas', DB::raw('count(*) as total'))
                                             ->groupBy('status_berkas')
                                             ->get()
                                             ->mapWithKeys(function ($item) {
                                                 return [Str::title(str_replace('_', ' ', $item['status_berkas'])) => $item['total']];
                                             });

        // Contoh: Total Warga Terdaftar (tidak terkait filter tanggal booking)
        $totalWarga = \App\Models\Warga::count(); // Asumsi Anda punya model Warga

        // Contoh: Total Petugas Aktif (tidak terkait filter tanggal booking)
        $totalPetugas = User::whereIn('role', ['super_admin', 'petugas_layanan', 'pimpinan'])->count();

        // --- Data Booking Terbaru (untuk tabel ringkasan) ---
        $recentBookings = Booking::with('layanan', 'warga', 'petugas') // Muat relasi yang benar
                                 // <<< PERBAIKAN 3 DI SINI >>>
                                 ->whereBetween('jadwal_janji_temu', [$startDate, $endDate])
                                 ->latest() // Mengurutkan berdasarkan 'created_at' DESC
                                 ->take(10)
                                 ->get();

        return view('admin.laporan.index', [
            'totalBooking' => $totalBooking,
            'bookingSelesai' => $bookingSelesai,
            'bookingDitolak' => $bookingDitolak,
            'bookingPending' => $bookingPending,
            'layananPopuler' => $layananPopuler,
            'bookingStatusCounts' => $bookingStatusCounts,
            'totalWarga' => $totalWarga,
            'totalPetugas' => $totalPetugas,
            'recentBookings' => $recentBookings,
            'startDate' => $startDate->toDateString(), 
            'endDate' => $endDate->toDateString(),     
        ]);
    }

    /**
     * Mengunduh laporan statistik sebagai file PDF.
     */
    public function downloadPdf(Request $request)
    {
        // --- Ambil data laporan, LOGIKA NYARIS SAMA DENGAN METHOD index() ---
        // Anda bisa membuat method private terpisah untuk ini jika ingin lebih rapi
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfMonth();

        $bookingsQuery = Booking::query()
                                ->whereBetween('jadwal_janji_temu', [$startDate, $endDate]);

        $totalBooking = $bookingsQuery->clone()->count();
        $bookingSelesai = $bookingsQuery->clone()->where('status_berkas', 'SELESAI')->count();
        $bookingDitolak = $bookingsQuery->clone()->where('status_berkas', 'DITOLAK')->count();
        
        $pendingStatus = [
            'JANJI TEMU DIBUAT', 
            'JANJI TEMU DIKONFIRMASI', 
            'BERKAS DITERIMA', 
            'VERIFIKASI BERKAS', 
            'SEDANG DIPROSES'
        ];
        $bookingPending = $bookingsQuery->clone()->whereIn('status_berkas', $pendingStatus)->count();
        
        $layananPopuler = Layanan::withCount(['bookings' => function ($query) use ($startDate, $endDate) {
                                    $query->whereBetween('jadwal_janji_temu', [$startDate, $endDate]);
                                }])
                                ->orderBy('bookings_count', 'desc')
                                ->take(5)
                                ->get();
        
        $bookingStatusCounts = $bookingsQuery->clone()
                                             ->select('status_berkas', DB::raw('count(*) as total'))
                                             ->groupBy('status_berkas')
                                             ->get()
                                             ->mapWithKeys(function ($item) {
                                                 return [Str::title(str_replace('_', ' ', $item['status_berkas'])) => $item['total']];
                                             });

        // Pastikan Anda punya model Warga atau sesuaikan dengan User role 'warga'
        $totalWarga = 0;
        if (class_exists(Warga::class)) { // Cek apakah model Warga ada
            $totalWarga = Warga::count();
        } else { // Fallback jika tidak ada model Warga terpisah
            $totalWarga = User::where('role', 'warga')->count(); 
        }

        $totalPetugas = User::whereIn('role', ['super_admin', 'petugas_layanan', 'pimpinan'])->count();

        $recentBookings = Booking::with('layanan', 'warga', 'petugas') 
                                 ->whereBetween('jadwal_janji_temu', [$startDate, $endDate])
                                 ->latest()
                                 ->take(10)
                                 ->get();
        
        // Data yang akan dikirim ke view PDF
        $data = [
            'totalBooking' => $totalBooking,
            'bookingSelesai' => $bookingSelesai,
            'bookingDitolak' => $bookingDitolak,
            'bookingPending' => $bookingPending,
            'layananPopuler' => $layananPopuler,
            'bookingStatusCounts' => $bookingStatusCounts,
            'totalWarga' => $totalWarga,
            'totalPetugas' => $totalPetugas,
            'recentBookings' => $recentBookings,
            'startDate' => $startDate->format('d M Y'), // Format tanggal untuk PDF
            'endDate' => $endDate->format('d M Y'),     // Format tanggal untuk PDF
            'title' => 'Laporan Statistik Pelayanan Kelurahan Klender',
            'date_generated' => Carbon::now()->format('d M Y H:i:s'),
        ];

        // Muat view untuk PDF dan konversi
        $pdf = PDF::loadView('admin.laporan.pdf_template', $data);

        // Unduh PDF dengan nama file yang spesifik
        return $pdf->download('laporan-pelayanan-' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.pdf');
    }

    // Helper untuk mendapatkan role yang diizinkan (jika Anda tidak punya method ini di User.php)
    protected function getAllowedRoles()
    {
        // Sesuaikan dengan daftar role yang ada di migrasi enum Anda
        return ['super_admin', 'petugas_layanan', 'pimpinan', 'warga']; 
    }
}