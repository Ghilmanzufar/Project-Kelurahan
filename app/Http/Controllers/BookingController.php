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
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    /**
     * Menampilkan halaman daftar layanan khusus untuk memulai booking.
     */
    public function index()
    {
        // Ambil semua layanan yang aktif
        $layanan = Layanan::where('status', 'aktif')->orderBy('nama_layanan', 'asc')->get();
        
        return view('booking.index', compact('layanan'));
    }

    /**
     * Menampilkan halaman Langkah 1: Pilih Petugas & Jadwal
     */
    public function showStep1(Layanan $layanan)
    {
        // 1. Ambil Petugas (Real dari Database)
        // Kita cari user yang role-nya 'petugas_layanan' dan statusnya 'aktif'
        $petugasTersedia = User::where('role', 'petugas_layanan')
                                ->where('status', 'aktif')
                                ->get();

        // 2. Generate Tanggal (2 Minggu ke depan)
        $dates = [];
        $startDate = Carbon::now();

        // Jika user membuka website lewat jam 14:00 (tutup), mulai tanggal dari besok
        if ($startDate->hour >= 14) {
            $startDate->addDay();
        }

        // Loop untuk 14 hari ke depan
        for ($i = 0; $i < 14; $i++) {
            $date = $startDate->copy()->addDays($i);
            $status = 'available';

            // Logika Libur: Sabtu & Minggu
            if ($date->isWeekend()) {
                $status = 'libur';
            }

            // (Opsional) Anda bisa menambahkan array tanggal merah di sini
            // if (in_array($date->format('Y-m-d'), ['2025-12-25'])) $status = 'libur';

            $dates[] = [
                'val' => $date->format('Y-m-d'), // Value untuk input radio (2025-11-20)
                'day_name' => $date->locale('id')->isoFormat('ddd'), // Nama hari pendek (Sen, Sel)
                'day_num' => $date->format('d'), // Tanggal (20)
                'status' => $status, // Status ketersediaan
            ];
        }

        // 3. Definisi Slot Waktu (Bisa dibuat dinamis nanti)
        $timeSlots = [
            'Pagi' => ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00'],
            'Siang' => ['13:00', '13:30', '14:00', '14:30'],
        ];

        // ===============================================
        // <<< TAMBAHAN BARU: WAKTU SEKARANG >>>
        // ===============================================
        $serverNow = Carbon::now();
        $currentDate = $serverNow->format('Y-m-d'); // Contoh: 2025-11-17
        $currentTime = $serverNow->format('H:i');   // Contoh: 12:30
        // ===============================================

        return view('booking.langkah1_pilih_jadwal', [
            'layanan' => $layanan,
            'petugasTersedia' => $petugasTersedia,
            'dates' => $dates,
            'timeSlots' => $timeSlots,
            'currentDate' => $currentDate, 
            'currentTime' => $currentTime, 
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

        return redirect()->route('booking.step2');
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
     * Menyimpan data Langkah 2 (Data Diri) ke session dan lanjut ke Langkah 3.
     */
    public function storeStep2(Request $request)
    {
        // 1. Validasi Data Diri
        // Kita sesuaikan rule dengan tabel 'warga' yang Anda kirim
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|digits:16', // Wajib 16 digit angka
            'tanggal_lahir' => 'required|date|before:today', // Opsional: Jika ingin tetap divalidasi untuk keperluan verifikasi
            'nomor_hp'     => 'required|string|max:20', 
            'email'        => 'nullable|email|max:255', // Boleh kosong sesuai migrasi
            'alamat'       => 'nullable|string|max:1000', // Boleh kosong sesuai migrasi (alamat_terakhir)
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required'          => 'NIK wajib diisi.',
            'nik.digits'            => 'NIK harus terdiri dari 16 angka.',
            'nomor_hp.required'     => 'Nomor HP / WhatsApp wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
        ]);

        // 2. Simpan Data Diri ke Session
        // Kita simpan dengan nama key yang sesuai dengan kolom database 'warga'
        // agar nanti di storeBooking lebih mudah mapping-nya.
        Session::put('booking.nama_lengkap', $request->nama_lengkap);
        Session::put('booking.nik', $request->nik);
        
        // Mapping input form ke nama kolom database 'warga'
        Session::put('booking.no_hp', $request->nomor_hp); // input 'nomor_hp' -> db 'no_hp'
        Session::put('booking.email', $request->email);
        Session::put('booking.alamat_terakhir', $request->alamat); // input 'alamat' -> db 'alamat_terakhir'
        
        // Kita tetap simpan tanggal lahir di session jika form mengirimnya, 
        // meskipun di tabel warga saat ini belum ada kolomnya (bisa untuk verifikasi nanti)
        if ($request->has('tanggal_lahir')) {
            Session::put('booking.tanggal_lahir', $request->tanggal_lahir);
        }

        // 3. Redirect ke Langkah 3 (Konfirmasi)
        return redirect()->route('booking.step3');
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
     * Menyimpan data booking ke database (Final Step).
     */
    public function storeBooking(Request $request)
    {
        // 1. Validasi Checkbox Persetujuan
        $request->validate([
            'konfirmasi' => 'required|accepted',
        ], [
            'konfirmasi.required' => 'Anda harus menyetujui pernyataan bahwa data sudah benar.',
            'konfirmasi.accepted' => 'Anda harus menyetujui pernyataan bahwa data sudah benar.',
        ]);

        // 2. Ambil Semua Data dari Session
        $bookingData = Session::get('booking');

        // Cek jika session sudah kadaluarsa atau kosong
        if (!$bookingData || !isset($bookingData['nik'])) {
            return redirect()->route('booking.index')
                ->with('error', 'Sesi booking telah berakhir. Silakan ulangi proses dari awal.');
        }

        try {
            DB::beginTransaction(); // Mulai transaksi database agar aman

            // 3. Update atau Buat Data Warga (Table: warga)
            // Kita gunakan updateOrCreate agar jika NIK sudah ada, datanya di-update (misal alamat baru)
            // Jika belum ada, buat baru.
            $warga = Warga::updateOrCreate(
                ['nik' => $bookingData['nik']], // Kunci pencarian (NIK)
                [
                    'nama_lengkap'    => $bookingData['nama_lengkap'],
                    'no_hp'           => $bookingData['no_hp'],          // Sesuai key session dari storeStep2
                    'email'           => $bookingData['email'],
                    'alamat_terakhir' => $bookingData['alamat_terakhir'] // Sesuai key session dari storeStep2
                ]
            );

            // 4. Generate Nomor Booking Unik
            // Format: BKG-YYYYMMDD-XXX (Contoh: BKG-20251117-005)
            $dateCode = now()->format('Ymd');
            $lastBooking = Booking::whereDate('created_at', today())->latest()->first();
            $sequence = $lastBooking ? intval(substr($lastBooking->no_booking, -3)) + 1 : 1;
            $noBooking = 'BKG-' . $dateCode . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);

            // 5. Gabungkan Tanggal dan Waktu
            $jadwalTemu = Carbon::parse($bookingData['tanggal_kunjungan'] . ' ' . $bookingData['waktu_kunjungan']);

            // 6. Simpan Data Booking (Table: booking)
            $booking = Booking::create([
                'no_booking'        => $noBooking,
                'warga_id'          => $warga->id, // Ambil ID dari warga yang baru dibuat/diupdate
                'layanan_id'        => $bookingData['layanan_id'],
                'petugas_id'        => $bookingData['petugas_id'],
                'jadwal_janji_temu' => $jadwalTemu,
                'status_berkas'     => 'JANJI TEMU DIBUAT', // Status awal default
                'catatan_internal'  => null,
            ]);

            // 7. Catat Log Status Awal (Table: booking_status_logs)
            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'status'     => 'JANJI TEMU DIBUAT',
                'deskripsi'  => 'Pendaftaran janji temu berhasil dilakukan secara online.',
                'petugas_id' => null, // Null karena dibuat oleh sistem/warga
            ]);

            DB::commit(); // Simpan perubahan ke database

            // 8. Bersihkan Session Booking
            Session::forget('booking');

            // 9. Redirect ke Halaman Sukses dengan membawa data No Booking
            return redirect()->route('booking.success', ['no_booking' => $noBooking]);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error
            // Log error untuk developer (opsional: Log::error($e->getMessage());)
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan booking. Silakan coba lagi.');
        }
    }

        /**
         * Menampilkan halaman Janji Temu Berhasil Dibuat!
         * Parameter $no_booking diambil dari URL.
         */
        public function showSuccess($no_booking) // <<< TERIMA PARAMETER DARI URL
        {
            // Cari booking berdasarkan nomor untuk ditampilkan detailnya di halaman sukses
            // Kita gunakan firstOrFail agar jika nomor ngawur, langsung 404 (aman)
            $booking = Booking::with(['layanan', 'warga'])
                        ->where('no_booking', $no_booking)
                        ->firstOrFail();

            // Ambil data email/hp dari relasi warga (lebih aman daripada session)
            $emailPemohon = $booking->warga->email;
            $nomorHpPemohon = $booking->warga->no_hp;
            $nomorBooking = $booking->no_booking; // Untuk konsistensi variabel di view

            return view('booking.langkah4_sukses', compact('booking', 'nomorBooking', 'emailPemohon', 'nomorHpPemohon'));
        }
}