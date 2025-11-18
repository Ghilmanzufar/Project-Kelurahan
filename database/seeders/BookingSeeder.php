<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\BookingStatusLog;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Warga; // <<< Import Model Warga
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil SEMUA ID layanan yang aktif dari database
        $layananIds = Layanan::where('status', 'aktif')->pluck('id');
        $petugasId = User::where('role', 'petugas_layanan')->first()->id ?? User::factory()->create(['role' => 'petugas_layanan'])->id;
        
        // Buat warga dummy
        $wargaId1 = Warga::factory()->create(['nama_lengkap' => 'Budi Santoso', 'nik' => '3175051234567890'])->id; 
        $wargaId2 = Warga::factory()->create(['nama_lengkap' => 'Siti Aminah', 'nik' => '3175051234567891'])->id;
        $wargaId3 = Warga::factory()->create(['nama_lengkap' => 'Rudi Hartono', 'nik' => '3175051234567892'])->id;
        $wargaId4 = Warga::factory()->create(['nama_lengkap' => 'Dewi Lestari', 'nik' => '3175051234567893'])->id;
        $wargaId5 = Warga::factory()->create(['nama_lengkap' => 'Eka Saputra', 'nik' => '3175051234567894'])->id;


        // --- Booking 1: Status Selesai ---
        $booking1 = Booking::create([
            'no_booking'        => 'BKG-20251027-001', // <<< TAHUN DIUBAH
            'warga_id'          => $wargaId1,
            'layanan_id'        => $layananIds->random(), 
            'petugas_id'        => $petugasId,
            'jadwal_janji_temu' => Carbon::parse('2025-10-27 09:00:00'), // <<< TAHUN DIUBAH
            'status_berkas'     => 'SELESAI',
            'catatan_internal'  => 'Berkas sudah diambil pemohon.',
        ]);
        // ... (Log untuk Booking 1)
        BookingStatusLog::create(['booking_id' => $booking1->id, 'status' => 'JANJI TEMU DIBUAT', 'deskripsi' => 'Anda berhasil membuat janji temu online.', 'created_at' => Carbon::parse('2025-10-27 10:05:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking1->id, 'status' => 'BERKAS DITERIMA', 'deskripsi' => 'Berkas fisik Anda telah diterima di loket 1.', 'created_at' => Carbon::parse('2025-10-28 09:32:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking1->id, 'status' => 'VERIFIKASI BERKAS', 'deskripsi' => 'Petugas telah selesai memverifikasi kelengkapan berkas fisik Anda.', 'created_at' => Carbon::parse('2025-10-28 14:30:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking1->id, 'status' => 'SEDANG DIPROSES', 'deskripsi' => 'Berkas Anda sedang ditinjau Kasi/Lurah.', 'created_at' => Carbon::parse('2025-10-29 09:15:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking1->id, 'status' => 'SELESAI', 'deskripsi' => 'Pengajuan Anda telah selesai diproses dan dapat diambil.', 'created_at' => Carbon::parse('2025-10-30 11:00:00')]); // <<< TAHUN DIUBAH


        // --- Booking 2: Status Sedang Diproses ---
        $booking2 = Booking::create([
            'no_booking'        => 'BKG-20251101-002', // <<< TAHUN DIUBAH
            'warga_id'          => $wargaId2,
            'layanan_id'        => $layananIds->random(), 
            'petugas_id'        => $petugasId,
            'jadwal_janji_temu' => Carbon::parse('2025-11-01 10:00:00'), // <<< TAHUN DIUBAH
            'status_berkas'     => 'SEDANG DIPROSES',
            'catatan_internal'  => null,
        ]);
        // ... (Log untuk Booking 2)
        BookingStatusLog::create(['booking_id' => $booking2->id, 'status' => 'JANJI TEMU DIBUAT', 'deskripsi' => 'Anda berhasil membuat janji temu online.', 'created_at' => Carbon::parse('2025-11-01 08:30:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking2->id, 'status' => 'BERKAS DITERIMA', 'deskripsi' => 'Berkas fisik Anda telah diterima oleh petugas di loket 2.', 'created_at' => Carbon::parse('2025-11-01 10:15:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking2->id, 'status' => 'VERIFIKASI BERKAS', 'deskripsi' => 'Verifikasi berkas fisik telah selesai dan dinyatakan lengkap.', 'created_at' => Carbon::parse('2025-11-01 15:00:00')]); // <<< TAHUN DIUBAH
        BookingStatusLog::create(['booking_id' => $booking2->id, 'status' => 'SEDANG DIPROSES', 'deskripsi' => 'Berkas sedang dalam antrian untuk ditinjau oleh Kasi.', 'created_at' => Carbon::parse('2025-11-02 09:00:00')]); // <<< TAHUN DIUBAH
        
        
        // --- Booking 3: Status Janji Temu Dibuat (BARU) ---
        $booking3 = Booking::create([
            'no_booking'        => 'BKG-20251110-003', // <<< TAHUN DIUBAH
            'warga_id'          => $wargaId3,
            'layanan_id'        => $layananIds->random(), 
            'petugas_id'        => $petugasId,
            'jadwal_janji_temu' => Carbon::parse('2025-11-10 14:00:00'), // Tanggal 10 Nov 2025
            'status_berkas'     => 'JANJI TEMU DIBUAT',
            'catatan_internal'  => null,
        ]);
        BookingStatusLog::create([
            'booking_id' => $booking3->id,
            'status' => 'JANJI TEMU DIBUAT',
            'deskripsi' => 'Anda berhasil membuat janji temu online.',
            'created_at' => Carbon::parse('2025-11-10 10:30:00'), // Dibuat tanggal 10
        ]);

        
        // --- DATA BARU 1: Status Janji Temu Dibuat ---
        $booking4 = Booking::create([
            'no_booking'        => 'BKG-20251111-004', // <<< TAHUN DIUBAH
            'warga_id'          => $wargaId4,
            'layanan_id'        => $layananIds->random(), 
            'petugas_id'        => $petugasId,
            'jadwal_janji_temu' => Carbon::parse('2025-11-11 09:00:00'), // Tanggal 11 Nov 2025
            'status_berkas'     => 'JANJI TEMU DIBUAT',
            'catatan_internal'  => null,
        ]);
        BookingStatusLog::create([
            'booking_id' => $booking4->id,
            'status' => 'JANJI TEMU DIBUAT',
            'deskripsi' => 'Anda berhasil membuat janji temu online.',
            'created_at' => Carbon::parse('2025-11-11 11:00:00'), // Dibuat tanggal 11
        ]);

        // --- DATA BARU 2: Status Janji Temu Dibuat ---
        $booking5 = Booking::create([
            'no_booking'        => 'BKG-20251112-005', // <<< TAHUN DIUBAH
            'warga_id'          => $wargaId5,
            'layanan_id'        => $layananIds->random(), 
            'petugas_id'        => $petugasId,
            'jadwal_janji_temu' => Carbon::parse('2025-11-12 13:00:00'), // Tanggal 12 Nov 2025
            'status_berkas'     => 'JANJI TEMU DIBUAT',
            'catatan_internal'  => null,
        ]);
        BookingStatusLog::create([
            'booking_id' => $booking5->id,
            'status' => 'JANJI TEMU DIBUAT',
            'deskripsi' => 'Anda berhasil membuat janji temu online.',
            'created_at' => Carbon::parse('2025-11-12 08:00:00'), // Dibuat tanggal 12
        ]);
    }
}