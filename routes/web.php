<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LacakController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController; 
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\Admin\PengajuanBerkasController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;
use App\Http\Controllers\Admin\PetugasController as AdminPetugasController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ===============================================
// RUTE UNTUK PUBLIK / WARGA
// ===============================================

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('beranda');
// Rute untuk mengetes koneksi ke Groq AI
Route::get('/test-ai', [ChatbotController::class, 'testConnection']);
// RUTE RESMI CHATBOT (Untuk diakses via AJAX Frontend)
Route::post('/chat/send', [ChatbotController::class, 'sendMessage'])->name('chat.send');
// Rute Layanan
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
Route::get('/layanan/{layanan}', [LayananController::class, 'show'])->name('layanan.show');

// Rute Booking (Pendaftaran Layanan)
Route::prefix('booking')->name('booking.')->group(function () {
    // <<< TAMBAHKAN RUTE INI DI PALING ATAS >>>
    Route::get('/', [BookingController::class, 'index'])->name('index');

    // PERBAIKAN: Ganti 'showStep1Form' menjadi 'showStep1'
    Route::get('/{layanan}/step-1', [BookingController::class, 'showStep1'])->name('step1'); 
    Route::post('/{layanan}/step-1', [BookingController::class, 'storeStep1'])->name('storeStep1');
    
    // PERBAIKAN: Ganti 'showStep2Form' menjadi 'showStep2'
    Route::get('/step-2', [BookingController::class, 'showStep2'])->name('step2');
    Route::post('/step-2', [BookingController::class, 'storeStep2'])->name('storeStep2');
    
    // PERBAIKAN: Ganti 'showStep3Form' menjadi 'showStep3'
    Route::get('/step-3', [BookingController::class, 'showStep3'])->name('step3');
    Route::post('/step-3', [BookingController::class, 'storeStep3'])->name('storeStep3');
    
    
    Route::post('/store', [BookingController::class, 'storeBooking'])->name('storeBooking');
    // <<< --------------------------------- >>>
    Route::get('/success/{no_booking}', [BookingController::class, 'showSuccess'])->name('success');
    
    // (Opsional, jika fitur ini ada)
    Route::get('/check-kuota/{layanan_id}/{tanggal}', [BookingController::class, 'checkKuota'])->name('checkKuota');
    Route::get('/get-petugas/{layanan_id}', [BookingController::class, 'getPetugas'])->name('getPetugas');
});




// Rute Lacak Pengajuan
Route::prefix('lacak')->name('lacak.')->group(function () {
    Route::get('/', [LacakController::class, 'index'])->name('index'); // Form utama lacak
    Route::post('/search', [LacakController::class, 'search'])->name('search'); // Hasil pencarian no_booking
    Route::get('/show/{no_booking}', [LacakController::class, 'show'])->name('show'); // Detail tracking

    // Lupa Nomor Booking
    Route::get('/lupa-nomor-booking', [LacakController::class, 'showLupaForm'])->name('showLupaForm');
    Route::post('/search-by-warga', [LacakController::class, 'searchByWarga'])->name('searchByWarga');
});

// Rute Pengumuman / Berita
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{pengumuman:slug}', [PengumumanController::class, 'show'])->name('pengumuman.show');

// Rute Halaman Statis (Kontak Kami)
Route::get('/kontak-kami', [PageController::class, 'kontak'])->name('kontak');
Route::post('/kontak-kami', [PageController::class, 'storeKontak'])->name('kontak.store');

// Rute Bantuan / FAQ
Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan.index');

// ===============================================
// RUTE UNTUK AUTENTIKASI (LOGIN/REGISTER)
// (INI DIBUAT OLEH LARAVEL BREEZE)
// ===============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================================
// <<< RUTE UNTUK ADMIN/PETUGAS >>>
// (Membutuhkan autentikasi DAN role tertentu)
// ===============================================
Route::middleware(['auth', 'role.check'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===============================================
    // <<< TAMBAHKAN RUTE BOOKING INI >>>
    // ===============================================
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('index'); // <<< UBAH DI SINI
        Route::post('/{booking}/konfirmasi', [AdminBookingController::class, 'konfirmasi'])->name('konfirmasi'); // <<< DAN DI SINI
        Route::post('/{booking}/tolak', [AdminBookingController::class, 'tolak'])->name('tolak');
        // <<< TAMBAHKAN RUTE SCAN INI >>>
        Route::get('/scan-qr', [AdminBookingController::class, 'scan'])->name('scan');
        Route::post('/scan-verify', [AdminBookingController::class, 'verifyQr'])->name('verify-qr'); // <<< DAN DI SINI
    });

    // ===============================================
    // <<< TAMBAHKAN RUTE PENGAJUAN BERKAS INI >>>
    // ===============================================
    Route::prefix('pengajuan-berkas')->name('pengajuan.')->group(function () {
        Route::get('/', [PengajuanBerkasController::class, 'index'])->name('index');
        Route::post('/{booking}/update-status', [PengajuanBerkasController::class, 'updateStatus'])->name('update-status');

        // <<< RUTE BARU UNTUK DOWNLOAD PDF >>>
        Route::get('/download-pdf', [App\Http\Controllers\Admin\PengajuanBerkasController::class, 'downloadPdf'])
            ->name('download_pdf')
            ->middleware('can:kelola-berkas'); // Pastikan tetap dilindungi
    });

    // ===============================================
    // <<< TAMBAHKAN RUTE KELOLA LAYANAN INI >>>
    // ===============================================
    Route::resource('layanan', AdminLayananController::class);

    // ===============================================
    // <<< TAMBAHKAN RUTE PENGUMUMAN INI >>>
    // ===============================================
    Route::resource('pengumuman', AdminPengumumanController::class);

    // KODE BARU (BENAR)
    Route::resource('petugas', AdminPetugasController::class)->parameters([
        'petugas' => 'petugas'
    ]);

    // ===============================================
    // <<< TAMBAHKAN RUTE KELOLA WARGA INI >>>
    // ===============================================
    Route::prefix('warga')->name('warga.')->group(function () {
        Route::get('/', [WargaController::class, 'index'])->name('index'); // Daftar Warga
        Route::get('/{warga}/edit', [WargaController::class, 'edit'])->name('edit'); // Tampilkan Form Edit
        Route::put('/{warga}', [WargaController::class, 'update'])->name('update'); // Simpan Perubahan (Update)
        Route::get('/download-pdf', [WargaController::class, 'downloadPdf'])->name('download_pdf');
    });

    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
        ->name('laporan.index')
        ->middleware('can:lihat-laporan'); // <<< PERHATIKAN INI

    // Rute Baru untuk Download Laporan PDF
    // Rute ini akan menerima parameter filter tanggal yang sama
    Route::get('/laporan/download-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'downloadPdf'])
        ->name('laporan.download_pdf')
        ->middleware('can:lihat-laporan'); // Tetap lindungi dengan Gate yang sama

    // Rute Manajemen Pesan Kontak
    Route::get('/pesan', [App\Http\Controllers\Admin\PesanController::class, 'index'])->name('pesan.index');
    Route::delete('/pesan/{id}', [App\Http\Controllers\Admin\PesanController::class, 'destroy'])->name('pesan.destroy');

    // Rute Cek Notifikasi (AJAX)
    Route::get('/notifications/unread', [App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->name('notifications.unread');

});

// Ini mengimport rute autentikasi dari Breeze
// File ini ada di vendor/laravel/breeze/stubs/web.stub jika Anda ingin melihatnya
require __DIR__.'/auth.php';