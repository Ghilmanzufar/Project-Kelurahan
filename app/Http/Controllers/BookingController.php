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
use App\Notifications\BookingBaruNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon; // Pastikan ini di-import untuk format tanggal
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // Import Facade Mail
use App\Mail\BookingSuccessMail;     // Import Mailable yang kita buat

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
     * Menampilkan halaman Langkah 1: Pilih Jadwal (Tanpa Petugas)
     */
    public function showStep1(Layanan $layanan)
    {
        // 1. Generate Tanggal (2 Minggu ke depan)
        $dates = [];
        $startDate = Carbon::now();

        // Jika user membuka website lewat jam 14:00 (tutup), mulai tanggal dari besok
        if ($startDate->hour >= 14) {
            $startDate->addDay();
        }

        for ($i = 0; $i < 14; $i++) {
            $date = $startDate->copy()->addDays($i);
            $status = 'available';

            if ($date->isWeekend()) {
                $status = 'libur';
            }

            $dates[] = [
                'val' => $date->format('Y-m-d'),
                'day_name' => $date->locale('id')->isoFormat('ddd'),
                'day_num' => $date->format('d'),
                'status' => $status,
            ];
        }

        // 2. Definisi Sesi (Pagi & Siang) - Tanpa Jam Spesifik
        // Kita gunakan array sederhana
        $sessions = [
            [
                'id' => 'Sesi Pagi',
                'label' => 'Sesi Pagi',
                'jam' => '08:00 - 12:00',
                'desc' => 'Kuota tersisa: Tersedia' // Nanti bisa didinamiskan
            ],
            [
                'id' => 'Sesi Siang',
                'label' => 'Sesi Siang',
                'jam' => '13:00 - 15:00',
                'desc' => 'Kuota tersisa: Tersedia'
            ],
        ];

        // Kirim data ke view (HAPUS variabel $petugasTersedia)
        $serverNow = Carbon::now();
        return view('booking.langkah1_pilih_jadwal', [
            'layanan' => $layanan,
            'dates' => $dates,
            'sessions' => $sessions, // Ganti $timeSlots jadi $sessions
            'currentDate' => $serverNow->format('Y-m-d'),
            'currentTime' => $serverNow->format('H:i'),
        ]);
    }


    public function storeStep1(Request $request)
    {
        // Validasi input (Hapus 'petugas_id')
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'tanggal_kunjungan' => 'required|date',
            'waktu_kunjungan' => 'required|string',
        ]);

        // Simpan data ke session
        Session::put('booking.layanan_id', $request->layanan_id);
        Session::put('booking.tanggal_kunjungan', $request->tanggal_kunjungan);
        Session::put('booking.waktu_kunjungan', $request->waktu_kunjungan);
        
        // Hapus session petugas lama jika ada (bersih-bersih)
        Session::forget('booking.petugas_id');
        Session::forget('booking.petugas_nama');

        // Ambil nama layanan dan simpan ke session untuk ditampilkan di step selanjutnya
        $layanan = Layanan::find($request->layanan_id);
        Session::put('booking.layanan_nama', $layanan->nama_layanan);

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
            DB::beginTransaction(); 

            // 3. Update atau Buat Data Warga
            $warga = Warga::updateOrCreate(
                ['nik' => $bookingData['nik']], 
                [
                    'nama_lengkap'    => $bookingData['nama_lengkap'],
                    'tanggal_lahir'   => $bookingData['tanggal_lahir'], 
                    'no_hp'           => $bookingData['no_hp'],          
                    'email'           => $bookingData['email'],
                    'alamat_terakhir' => $bookingData['alamat_terakhir']
                ]
            );

            // 4. Generate Nomor Booking
            $dateCode = now()->format('Ymd');
            $lastBooking = Booking::whereDate('created_at', today())->latest()->first();
            $sequence = $lastBooking ? intval(substr($lastBooking->no_booking, -3)) + 1 : 1;
            $noBooking = 'BKG-' . $dateCode . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);

            // ===============================================
            // <<< PERBAIKAN UTAMA DI SINI >>>
            // Menerjemahkan "Sesi" menjadi "Jam" untuk Database
            // ===============================================
            $waktu = $bookingData['waktu_kunjungan']; // Isinya "Sesi Pagi" atau "Sesi Siang"
            $jamDefault = '08:00:00'; // Default jika error

            if ($waktu == 'Sesi Pagi') {
                $jamDefault = '09:00:00'; // Kita set jam 9 pagi untuk sesi pagi
            } elseif ($waktu == 'Sesi Siang') {
                $jamDefault = '13:00:00'; // Kita set jam 1 siang untuk sesi siang
            } else {
                // Fallback jika masih menggunakan format jam lama (misal: 10:30)
                $jamDefault = $waktu; 
            }

            // Gabungkan Tanggal dan Jam yang sudah dikonversi
            $jadwalTemu = Carbon::parse($bookingData['tanggal_kunjungan'] . ' ' . $jamDefault);
            // ===============================================

            // 6. Simpan Data Booking
            $booking = Booking::create([
                'no_booking'        => $noBooking,
                'warga_id'          => $warga->id, 
                'layanan_id'        => $bookingData['layanan_id'],
                'petugas_id'        => $bookingData['petugas_id'] ?? null, 
                'jadwal_janji_temu' => $jadwalTemu,
                'status_berkas'     => 'JANJI TEMU DIBUAT', 
                'catatan_internal'  => null,
            ]);

            // 7. Catat Log Status Awal
            BookingStatusLog::create([
                'booking_id' => $booking->id,
                'status'     => 'JANJI TEMU DIBUAT',
                'deskripsi'  => 'Pendaftaran janji temu berhasil dilakukan secara online (Sesi: ' . $waktu . ').',
                'petugas_id' => null, 
            ]);

            DB::commit(); 

            // ===============================================
            // <<< KIRIM EMAIL NOTIFIKASI KE WARGA >>>
            // ===============================================
            try {
                // Pastikan warga punya email sebelum mencoba mengirim
                if (!empty($booking->warga->email)) {
                    // Kirim email ke alamat email warga
                    Mail::to($booking->warga->email)->send(new BookingSuccessMail($booking));
                    // Log sukses (opsional)
                    \Log::info('Email booking berhasil dikirim ke: ' . $booking->warga->email);
                }
            } catch (\Exception $e) {
                // PENTING: Jangan biarkan error email membatalkan booking!
                // Kita tangkap errornya, catat di log, tapi biarkan proses lanjut.
                \Log::error('Gagal mengirim email booking: ' . $e->getMessage());
                // Opsional: bisa tambahkan flash message warning bahwa email gagal, tapi booking sukses.
            }
            
            // 8. Bersihkan Session Booking
            Session::forget('booking');

            // 9. Redirect ke Halaman Sukses
            return redirect()->route('booking.success', ['no_booking' => $noBooking]);

        } catch (\Exception $e) {
            DB::rollBack(); 
            // Tampilkan pesan error asli sementara untuk debugging jika masih gagal
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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