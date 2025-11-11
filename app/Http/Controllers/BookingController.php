<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Layanan;
use App\Models\User; // Pastikan ini di-import
use App\Models\BookingStatusLog; // <<< TAMBAHKAN INI
use App\Models\Warga; // <<< TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon; // Pastikan ini di-import untuk format tanggal

class BookingController extends Controller
{
    
    /**
     * Menampilkan halaman Langkah 1: Pilih Petugas & Jadwal
     * Menerima {layanan} dari URL.
     */
    public function showStep1(Layanan $layanan)
    {
        // Untuk UI mockup, kita pakai data dummy dulu.
        // Nanti ini akan diambil dari database.
        $petugasTersedia = User::where('role', 'petugas') // Asumsi ada user dengan role 'petugas'
                                ->where('status', 'aktif')
                                ->get();

        // Jika tidak ada petugas, berikan dummy atau kosongkan
        if ($petugasTersedia->isEmpty()) {
            $petugasTersedia = collect([
                (object)['id' => 1, 'nama_lengkap' => 'Budi Santoso', 'jabatan' => 'Kasi Pemerintahan'],
                (object)['id' => 2, 'nama_lengkap' => 'Siti Aminah', 'jabatan' => 'Staff Pelayanan'],
                (object)['id' => 3, 'nama_lengkap' => 'Joko Widodo', 'jabatan' => 'Sekretaris'],
            ]);
        }

        return view('booking.langkah1_pilih_jadwal', [
            'layanan' => $layanan,
            'petugasTersedia' => $petugasTersedia,
        ]);
    }

    /**
     * Menyimpan data Langkah 1 ke session dan lanjut ke Langkah 2.
     * Nanti akan ada validasi input di sini.
     */
    public function storeStep1(Request $request)
    {
        // Validasi input (akan ditambahkan lebih detail nanti)
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'petugas_id' => 'required', // Kita tidak validasi exists:users,id dulu untuk dummy
            'tanggal_kunjungan' => 'required|date',
            'waktu_kunjungan' => 'required|string',
        ]);

        // Simpan data ke session
        Session::put('booking.layanan_id', $request->layanan_id);
        Session::put('booking.petugas_id', $request->petugas_id);
        Session::put('booking.tanggal_kunjungan', $request->tanggal_kunjungan);
        Session::put('booking.waktu_kunjungan', $request->waktu_kunjungan);

        // Ambil nama layanan dan petugas untuk tampilan konfirmasi di step 2
        $layanan = Layanan::find($request->layanan_id);
        $petugas = User::find($request->petugas_id); // Asumsi user sudah ada
        if (!$petugas) { // Untuk dummy, jika tidak ada user asli
             $petugas = (object)['id' => $request->petugas_id, 'nama_lengkap' => 'Petugas Dummy ' . $request->petugas_id, 'jabatan' => 'Staff'];
        }
        Session::put('booking.layanan_nama', $layanan->nama_layanan);
        Session::put('booking.petugas_nama', $petugas->nama_lengkap);

        return redirect()->route('booking.showStep2');
    }

    /**
     * Menampilkan halaman Langkah 2: Isi Data Diri Anda.
     */
    public function showStep2()
    {
        // Pastikan data langkah 1 sudah ada di session
        if (!Session::has('booking.layanan_id')) {
            return redirect()->route('beranda')->with('error', 'Silakan pilih layanan dan jadwal terlebih dahulu.');
        }

        // Ambil data yang sudah disimpan di session untuk ditampilkan
        $bookingData = Session::get('booking');

        return view('booking.langkah2_isi_data', compact('bookingData'));
    }

    /**
     * Menyimpan data Langkah 2 ke session dan lanjut ke Langkah 3.
     * Nanti akan ada validasi input di sini.
     */
    public function storeStep2(Request $request)
    {
        // Validasi input (akan ditambahkan lebih detail nanti)
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date|before:today', // <<< TAMBAHKAN INI
            'nomor_hp' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        // Simpan data ke session
        Session::put('booking.nama_lengkap', $request->nama_lengkap);
        Session::put('booking.nik', $request->nik);
        Session::put('booking.tanggal_lahir', $request->tanggal_lahir); // <<< TAMBAHKAN INI
        Session::put('booking.nomor_hp', $request->nomor_hp);
        Session::put('booking.email', $request->email);

        return redirect()->route('booking.showStep3');
    }

    /**
     * Menampilkan halaman Langkah 3: Konfirmasi Janji Temu Anda.
     */
    public function showStep3()
    {
        // Pastikan semua data yang dibutuhkan sudah ada di session
        if (!Session::has('booking.layanan_id') || !Session::has('booking.nama_lengkap')) {
            return redirect()->route('beranda')->with('error', 'Silakan lengkapi langkah-langkah sebelumnya.');
        }

        $bookingData = Session::get('booking');

        return view('booking.langkah3_konfirmasi', compact('bookingData'));
    }

    /**
     * Menyimpan data booking ke database dan menampilkan halaman sukses.
     * Ini adalah titik di mana booking benar-benar dicatat.
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'konfirmasi' => 'required|accepted',
        ], [
            'konfirmasi.required' => 'Anda harus menyetujui pernyataan di atas.',
            'konfirmasi.accepted' => 'Anda harus menyetujui pernyataan di atas.',
        ]);

        $bookingData = Session::get('booking');

        // Pastikan semua data yang dibutuhkan ada
        if (! $bookingData || !isset($bookingData['nik'], $bookingData['tanggal_lahir'], $bookingData['nomor_hp'])) {
            return redirect()->route('beranda')->with('error', 'Data booking tidak lengkap. Silakan mulai ulang proses.');
        }

        // --- LOGIKA BARU: Simpan/Update data Warga ---
        // Cari warga berdasarkan NIK, atau buat baru jika tidak ada.
        $warga = Warga::updateOrCreate(
            ['nik' => $bookingData['nik']], // Kunci untuk mencari
            [
                'nama_lengkap' => $bookingData['nama_lengkap'],
                'tanggal_lahir' => $bookingData['tanggal_lahir'], // Simpan tanggal lahir
                'no_hp' => $bookingData['nomor_hp'],
                'email' => $bookingData['email'],
                'alamat_terakhir' => $bookingData['alamat_terakhir'] ?? null, // Ambil alamat jika ada
            ]
        );
        // ---------------------------------------------

        // Generate nomor booking
        $nomorBooking = 'BKG-' . date('Ymd') . '-' . Str::padLeft(Booking::count() + 1, 3, '0');

        // Simpan data booking ke database (SKEMA SUDAH BENAR)
        $booking = Booking::create([
            'no_booking'        => $nomorBooking,
            'warga_id'          => $warga->id, // <<< GUNAKAN ID WARGA
            'layanan_id'        => $bookingData['layanan_id'],
            'petugas_id'        => $bookingData['petugas_id'],
            'jadwal_janji_temu' => Carbon::parse($bookingData['tanggal_kunjungan'] . ' ' . $bookingData['waktu_kunjungan']), // Gabungkan tanggal & waktu
            'status_berkas'     => 'JANJI TEMU DIBUAT', // Status awal
        ]);

        // Buat log status awal
        BookingStatusLog::create([
            'booking_id' => $booking->id,
            'status' => 'JANJI TEMU DIBUAT',
            'deskripsi' => 'Anda berhasil membuat janji temu online.',
        ]);

        // Ambil data penting untuk halaman sukses
        $emailPemohon = $warga->email;
        $nomorHpPemohon = $warga->no_hp;
        
        Session::forget('booking'); // Hapus session booking

        return redirect()->route('booking.showSuccess')
            ->with('nomor_booking', $nomorBooking)
            ->with('email_pemohon', $emailPemohon)
            ->with('nomor_hp_pemohon', $nomorHpPemohon);
    }

        /**
         * Menampilkan halaman Janji Temu Berhasil Dibuat!
         */
        public function showSuccess()
        {
            $nomorBooking = Session::get('nomor_booking');
            $emailPemohon = Session::get('email_pemohon'); // <<< TAMBAHKAN INI
            $nomorHpPemohon = Session::get('nomor_hp_pemohon'); // <<< TAMBAHKAN INI

            // Jika nomor booking tidak ada (misalnya langsung akses URL ini), redirect ke beranda
            if (!$nomorBooking) {
                return redirect()->route('beranda');
            }

            return view('booking.langkah4_sukses', compact('nomorBooking', 'emailPemohon', 'nomorHpPemohon'));
        }
}