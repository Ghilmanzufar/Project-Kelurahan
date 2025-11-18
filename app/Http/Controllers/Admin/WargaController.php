<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga; // Pastikan model ini sudah di-use
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; // Pastikan ini juga di-use
use Carbon\Carbon;                 // <<< TAMBAHKAN INI
use PDF;                           // <<< TAMBAHKAN INI
use Illuminate\Support\Str;        // <<< TAMBAHKAN INI

class WargaController extends Controller
{
    public function __construct()
    {
        // Ganti menjadi 'kelola-berkas' agar 'petugas_layanan' juga bisa mengakses
        $this->middleware('can:kelola-berkas'); 
    }

    public function index(Request $request)
    {
        // Logika pencarian
        $query = Warga::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%')
                  ->orWhere('no_hp', 'like', '%' . $search . '%');
        }

        // Ambil semua data warga (dengan hasil pencarian jika ada), urutkan berdasarkan nama
        $allWarga = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();

        // Kirim data ke view
        return view('admin.warga.index', compact('allWarga'));
    }

    public function edit(Warga $warga) // Menggunakan Route Model Binding
    {
        // Mengirim data warga yang ada ke view 'edit' (form terisi)
        return view('admin.warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        // 1. Validasi data
        // NIK dan email harus unik, tapi abaikan warga yang sedang diedit
        $validated = $request->validate([
            'nik' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warga')->ignore($warga->id), // Abaikan NIK warga ini sendiri
            ],
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:20',
            'email' => [
                'nullable', // Email bisa kosong
                'string',
                'email',
                'max:255',
                Rule::unique('warga')->ignore($warga->id), // Abaikan email warga ini sendiri
            ],
            'alamat_terakhir' => 'nullable|string|max:1000',
        ]);

        // 2. Update record di database
        $warga->update($validated);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.warga.index')
                         ->with('success', 'Data warga berhasil diperbarui.');
    }

    /**
     * Mengunduh daftar warga yang difilter sebagai PDF.
     */
    public function downloadPdf(Request $request)
    {
        // --- LOGIKA FILTER DAN PENCARIAN (DISALIN DARI METHOD index()) ---
        $query = Warga::query();

        // Filter by search term
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_lengkap', 'like', $searchTerm)
                  ->orWhere('nik', 'like', $searchTerm)
                  ->orWhere('no_telepon', 'like', $searchTerm);
            });
        }

        // Filter by status_verifikasi_akun
        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi_akun', $request->input('status_verifikasi'));
        }

        // Filter by date range (tanggal pendaftaran atau update)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]); // Filter berdasarkan tanggal pendaftaran
        }
        // --- AKHIR LOGIKA FILTER DAN PENCARIAN ---

        // Ambil semua hasil yang difilter (bukan paginate)
        $warga = $query->get();

        // Data yang akan dikirim ke view PDF
        $data = [
            'warga' => $warga,
            'title' => 'Laporan Data Warga Terdaftar',
            'filter_info' => $this->getFilterInfo($request), // Method helper untuk info filter
            'date_generated' => Carbon::now()->format('d M Y H:i:s'),
        ];

        // Muat view untuk PDF dan konversi
        $pdf = PDF::loadView('admin.warga.pdf_template', $data);

        // Unduh PDF dengan nama file yang spesifik
        return $pdf->download('laporan-data-warga-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    /**
     * Helper method untuk mendapatkan string informasi filter.
     * (Mirip dengan yang ada di LaporanController/PengajuanBerkasController)
     */
    private function getFilterInfo(Request $request)
    {
        $info = [];
        if ($request->filled('search')) {
            $info[] = 'Kata Kunci: "' . $request->input('search') . '"';
        }
        if ($request->filled('status_verifikasi')) {
            $info[] = 'Status Verifikasi: ' . Str::title(str_replace('_', ' ', $request->input('status_verifikasi')));
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $info[] = 'Periode Pendaftaran: ' . Carbon::parse($request->input('start_date'))->format('d M Y') . ' s/d ' . Carbon::parse($request->input('end_date'))->format('d M Y');
        }
        return count($info) > 0 ? implode(', ', $info) : 'Semua Data';
    }
}
