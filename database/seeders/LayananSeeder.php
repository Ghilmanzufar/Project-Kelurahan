<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan; 

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Layanan: Surat Keterangan Riwayat Tanah
        $layanan1 = Layanan::create([
            'nama_layanan' => 'Pelayanan Ahli Waris',
            'deskripsi' => 'Surat keterangan yang menjelaskan riwayat kepemilikan tanah tertentu.',
            'estimasi_proses' => '3-5 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'PP No. 24 Tahun 1997',
            'status' => 'aktif',
        ]);

        $layanan1->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Fotokopi KTP Pemohon'],
            ['deskripsi_dokumen' => 'Fotokopi KK Pemohon'],
            ['deskripsi_dokumen' => 'Fotokopi Sertifikat/AJB/Girik (Surat Tanah)'],
            ['deskripsi_dokumen' => 'Bukti Lunas PBB Tahun Berjalan'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Riwayat Tanah (dari RT/RW)'],
        ]);

        $layanan1->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon menyerahkan berkas di loket.'],
            ['deskripsi_alur' => 'Petugas memverifikasi kelengkapan berkas.'],
            ['deskripsi_alur' => 'Pengecekan data riwayat tanah (Buku C).'],
            ['deskripsi_alur' => 'Proses pengetikan dan penandatanganan oleh Lurah.'],
            ['deskripsi_alur' => 'Selesai dan dapat diambil.'],
        ]);

        // 2. Layanan: Surat Pengantar Akta Jual Beli (AJB)
        $layanan2 = Layanan::create([
            'nama_layanan' => 'Pelayanan Pernyataan Ahli Waris',
            'deskripsi' => 'Surat pengantar yang diperlukan untuk pembuatan Akta Jual Beli (AJB) di hadapan PPAT.',
            'estimasi_proses' => '2-3 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Permen ATR/BPN No. 3 Tahun 1997',
            'status' => 'aktif',
        ]);

        $layanan2->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Fotokopi KTP Penjual (Suami/Istri)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP Pembeli'],
            ['deskripsi_dokumen' => 'Fotokopi KK Penjual & Pembeli'],
            ['deskripsi_dokumen' => 'Fotokopi Surat Nikah (jika sudah menikah)'],
            ['deskripsi_dokumen' => 'Asli Sertifikat Tanah/Surat Tanah'],
            ['deskripsi_dokumen' => 'Bukti Lunas PBB 5 Tahun Terakhir'],
        ]);

        $layanan2->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon (Penjual/Pembeli) menyerahkan berkas.'],
            ['deskripsi_alur' => 'Verifikasi berkas oleh petugas.'],
            ['deskripsi_alur' => 'Surat Pengantar diproses dan ditandatangani Lurah.'],
            ['deskripsi_alur' => 'Selesai. Surat pengantar siap dibawa ke PPAT.'],
        ]);

        // 3. Layanan: Surat Keterangan Ahli Waris
        $layanan3 = Layanan::create([
            'nama_layanan' => 'Pelayanan Permohonan Riwayat Tanah',
            'deskripsi' => 'Surat keterangan yang menyatakan seseorang adalah ahli waris dari pewaris tertentu.',
            'estimasi_proses' => '5-7 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Kompilasi Hukum Islam',
            'status' => 'aktif',
        ]);

        $layanan3->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Fotokopi KTP & KK Pewaris (yang meninggal)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP & KK Semua Ahli Waris'],
            ['deskripsi_dokumen' => 'Fotokopi Akta Kematian Pewaris (dari Dukcapil)'],
            ['deskripsi_dokumen' => 'Fotokopi Surat Nikah Pewaris'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Ahli Waris (dari RT/RW)'],
        ]);

        $layanan3->alurProses()->createMany([
            ['deskripsi_alur' => 'Ahli waris menyerahkan berkas lengkap.'],
            ['deskripsi_alur' => 'Verifikasi data kependudukan dan ahli waris.'],
            ['deskripsi_alur' => 'Proses pengetikan SKAW.'],
            ['deskripsi_alur' => 'Penandatanganan oleh Lurah.'],
            ['deskripsi_alur' => 'Selesai.'],
        ]);
        
        // 4. Layanan: Surat Keterangan Tidak Sengketa
        $layanan4 = Layanan::create([
            'nama_layanan' => 'Surat Keterangan Tidak Sengketa',
            'deskripsi' => 'Surat pernyataan bahwa tanah yang dimaksud tidak dalam keadaan sengketa.',
            'estimasi_proses' => '2 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Peraturan internal',
            'status' => 'aktif',
        ]);
        
        $layanan4->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Fotokopi KTP Pemohon'],
            ['deskripsi_dokumen' => 'Fotokopi Sertifikat/AJB/Girik (Surat Tanah)'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Tidak Sengketa (dari RT/RW)'],
        ]);

        $layanan4->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon menyerahkan berkas.'],
            ['deskripsi_alur' => 'Pengecekan lapangan (jika diperlukan).'],
            ['deskripsi_alur' => 'Surat Keterangan diproses dan ditandatangani Lurah.'],
            ['deskripsi_alur' => 'Selesai.'],
        ]);
    }
}