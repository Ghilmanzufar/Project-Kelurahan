<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\LayananDokumenWajib; // <<< TAMBAHKAN INI
use App\Models\LayananAlurProses;  // <<< TAMBAHKAN INI
use Illuminate\Support\Facades\DB;      // <<< TAMBAHKAN INI (untuk Transaksi)
use Illuminate\Support\Facades\Log;      // <<< TAMBAHKAN INI (opsional, untuk error logging)

class LayananController extends Controller
{
    // BENAR
    public function __construct()
    {
        // Gunakan middleware 'can' agar dijalankan pada waktu yang tepat
        $this->middleware('can:kelola-sistem'); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil semua data layanan, urutkan berdasarkan nama
        $allLayanan = Layanan::orderBy('nama_layanan', 'asc')->paginate(10);

        // Kirim data ke view
        return view('admin.layanan.index', compact('allLayanan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Siapkan data kosong untuk form
        $dokumenWajibJson = json_encode([['deskripsi' => '']]);
        $alurProsesJson = json_encode([['deskripsi' => '']]);
        
        return view('admin.layanan.create', compact('dokumenWajibJson', 'alurProsesJson'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input, termasuk array dinamis
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'estimasi_proses' => 'required|string|max:255',
            'biaya' => 'required|string|max:255',
            'dasar_hukum' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak_aktif',
            
            // Validasi array (harus ada, minimal 1 item)
            'dokumen_wajib' => 'required|array|min:1',
            'dokumen_wajib.*' => 'required|string|max:255', // Validasi setiap item di dalam array
            
            'alur_proses' => 'required|array|min:1',
            'alur_proses.*' => 'required|string|max:255', // Validasi setiap item di dalam array
        ], [
            // Pesan error kustom
            'dokumen_wajib.min' => 'Setidaknya satu Dokumen Wajib harus diisi.',
            'alur_proses.min' => 'Setidaknya satu Alur Proses harus diisi.',
            'dokumen_wajib.*.required' => 'Kolom Dokumen Wajib tidak boleh kosong.',
            'alur_proses.*.required' => 'Kolom Alur Proses tidak boleh kosong.',
        ]);

        // 2. Gunakan Database Transaction
        try {
            DB::beginTransaction();

            // 3. Buat entri utama di tabel 'layanan'
            $layanan = Layanan::create([
                'nama_layanan' => $validatedData['nama_layanan'],
                'deskripsi' => $validatedData['deskripsi'],
                'estimasi_proses' => $validatedData['estimasi_proses'],
                'biaya' => $validatedData['biaya'],
                'dasar_hukum' => $validatedData['dasar_hukum'],
                'status' => $validatedData['status'],
            ]);

            // 4. Looping dan simpan 'Dokumen Wajib'
            // Kita siapkan data dalam array agar bisa di-insert sekaligus (lebih efisien)
            $dokumenWajibData = [];
            foreach ($validatedData['dokumen_wajib'] as $deskripsiDokumen) {
                $dokumenWajibData[] = [
                    'layanan_id' => $layanan->id,
                    'deskripsi_dokumen' => $deskripsiDokumen,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            LayananDokumenWajib::insert($dokumenWajibData);

            // 5. Looping dan simpan 'Alur Proses'
            $alurProsesData = [];
            foreach ($validatedData['alur_proses'] as $deskripsiAlur) {
                $alurProsesData[] = [
                    'layanan_id' => $layanan->id,
                    'deskripsi_alur' => $deskripsiAlur,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            LayananAlurProses::insert($alurProsesData);

            // 6. Jika semua berhasil, commit transaksi
            DB::commit();

        } catch (\Exception $e) {
            // 7. Jika terjadi error, rollback semua perubahan
            DB::rollBack();
            
            // (Opsional) Catat error untuk debugging
            Log::error('Gagal menyimpan layanan baru: ' . $e->getMessage());

            // Kembalikan ke formulir dengan pesan error
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.')
                             ->withInput(); // withInput() agar data formulir tidak hilang
        }

        // 8. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Layanan $layanan)
    {
        $layanan->load('dokumenWajib', 'alurProses');

        // Siapkan data lama untuk form
        $dokumenWajibJson = $layanan->dokumenWajib->count() > 0
            ? $layanan->dokumenWajib->map(fn($d) => ['deskripsi' => $d->deskripsi_dokumen])->toJson()
            : json_encode([['deskripsi' => '']]);

        $alurProsesJson = $layanan->alurProses->count() > 0
            ? $layanan->alurProses->map(fn($a) => ['deskripsi' => $a->deskripsi_alur])->toJson()
            : json_encode([['deskripsi' => '']]);

        return view('admin.layanan.edit', compact('layanan', 'dokumenWajibJson', 'alurProsesJson'));
    }

    /**
     * Update the specified resource in storage.
     */
    // <<< PERBAIKI DI SINI: Ganti $id menjadi Layanan $layanan >>>
    public function update(Request $request, Layanan $layanan)
    {
        // 1. Validasi data (sama seperti store)
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'estimasi_proses' => 'required|string|max:255',
            'biaya' => 'required|string|max:255',
            'dasar_hukum' => 'required|string|max:255',
            'status' => 'required|in:aktif,tidak_aktif',
            'dokumen_wajib' => 'required|array|min:1',
            'dokumen_wajib.*' => 'required|string|max:255',
            'alur_proses' => 'required|array|min:1',
            'alur_proses.*' => 'required|string|max:255',
        ], [
            'dokumen_wajib.min' => 'Setidaknya satu Dokumen Wajib harus diisi.',
            'alur_proses.min' => 'Setidaknya satu Alur Proses harus diisi.',
            'dokumen_wajib.*.required' => 'Kolom Dokumen Wajib tidak boleh kosong.',
            'alur_proses.*.required' => 'Kolom Alur Proses tidak boleh kosong.',
        ]);

        try {
            DB::beginTransaction();

            // 2. Update data utama di tabel 'layanan'
            //    (Sekarang $layanan sudah menjadi objek yang benar)
            $layanan->update([
                'nama_layanan' => $validatedData['nama_layanan'],
                'deskripsi' => $validatedData['deskripsi'],
                'estimasi_proses' => $validatedData['estimasi_proses'],
                'biaya' => $validatedData['biaya'],
                'dasar_hukum' => $validatedData['dasar_hukum'],
                'status' => $validatedData['status'],
            ]);

            // 3. Hapus relasi lama
            $layanan->dokumenWajib()->delete();
            $layanan->alurProses()->delete();

            // 4. Buat ulang relasi 'Dokumen Wajib'
            $dokumenWajibData = [];
            foreach ($validatedData['dokumen_wajib'] as $deskripsiDokumen) {
                $dokumenWajibData[] = [
                    'deskripsi_dokumen' => $deskripsiDokumen,
                ];
            }
            $layanan->dokumenWajib()->createMany($dokumenWajibData);

            // 5. Buat ulang relasi 'Alur Proses'
            $alurProsesData = [];
            foreach ($validatedData['alur_proses'] as $deskripsiAlur) {
                $alurProsesData[] = [
                    'deskripsi_alur' => $deskripsiAlur,
                ];
            }
            $layanan->alurProses()->createMany($alurProsesData);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal update layanan: ' . $e->getMessage());
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat memperbarui data.')
                             ->withInput();
        }

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // <<< PERBAIKI DI SINI JUGA: Ganti $id menjadi Layanan $layanan >>>
    public function destroy(Layanan $layanan)
    {
        try {
            $namaLayanan = $layanan->nama_layanan;
            
            // Karena migrasi kita sudah 'onDelete('cascade')',
            // menghapus $layanan akan otomatis menghapus relasi.
            $layanan->delete();

            return redirect()->route('admin.layanan.index')
                             ->with('success', "Layanan '$namaLayanan' berhasil dihapus.");
                             
        } catch (\Exception $e) {
            Log::error('Gagal hapus layanan: ' . $e->getMessage());
            return redirect()->route('admin.layanan.index')
                             ->with('error', 'Gagal menghapus layanan. Kemungkinan layanan ini masih terkait dengan data booking.');
        }
    }
}
