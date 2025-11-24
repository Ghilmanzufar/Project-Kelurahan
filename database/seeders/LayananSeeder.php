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
        // ==========================================
        // 1. Layanan: Persyaratan Pecah SPPT PBB
        // ==========================================
        $layanan1 = Layanan::create([
            'nama_layanan' => 'Persyaratan Pecah SPPT PBB',
            'deskripsi' => 'Surat keterangan untuk keperluan pemecahan SPPT PBB karena pembagian waris, jual beli sebagian, atau hibah.',
            'estimasi_proses' => '1-7 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Peraturan Daerah DKI Jakarta tentang Pajak Bumi dan Bangunan Perdesaan dan Perkotaan.',
            'status' => 'aktif',
        ]);

        $layanan1->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP Pemohon / Penanggung Jawab'],
            ['deskripsi_dokumen' => 'Fotokopi Kartu Keluarga (KK) Pemohon'],
            ['deskripsi_dokumen' => 'Fotokopi Bukti Kepemilikan Tanah (Sertifikat/AJB/Girik/Letter C)'],
            ['deskripsi_dokumen' => 'Fotokopi SPPT PBB Induk tahun terakhir dan Bukti Lunas STTS'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Penguasaan Fisik Bidang Tanah (Bermaterai Rp 10.000)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP 2 (dua) orang saksi (Tetangga batas tanah)'],
            ['deskripsi_dokumen' => 'Surat Kuasa bermaterai dan fotokopi KTP penerima kuasa (jika dikuasakan)'],
            ['deskripsi_dokumen' => 'Site Plan / Gambar Denah Lokasi Tanah yang akan dipecah (diketahui RT/RW)'],
        ]);

        $layanan1->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online melalui website SiPentas untuk memilih jadwal kedatangan.'],
            ['deskripsi_alur' => 'Pemohon datang ke Kantor Kelurahan Klender sesuai jadwal dengan membawa seluruh dokumen persyaratan (Asli & Fotokopi) dan menunjukkan QR Code Booking.'],
            ['deskripsi_alur' => 'Petugas Front Office (FO) memindai QR Code dan memeriksa kelengkapan berkas.'],
            ['deskripsi_alur' => 'Jika berkas lengkap, petugas akan memproses dan memberikan estimasi waktu pengambilan. Status pengajuan dapat dipantau melalui fitur "Lacak Pengajuan".'],
            ['deskripsi_alur' => 'Petugas Seksi terkait melakukan verifikasi dan validasi lapangan (jika diperlukan).'],
            ['deskripsi_alur' => 'Setelah surat selesai dan ditandatangani Lurah, pemohon akan menerima notifikasi untuk mengambil dokumen.'],
        ]);

        // ==========================================
        // 2. Layanan: Persyaratan Pernyataan Ahli Waris
        // ==========================================
        $layanan2 = Layanan::create([
            'nama_layanan' => 'Persyaratan Pernyataan Ahli Waris',
            'deskripsi' => 'Layanan pembuatan Surat Keterangan Waris untuk keperluan peralihan hak atas tanah, pengambilan dana di bank, atau urusan administrasi lainnya.',
            'estimasi_proses' => '2-3 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Peraturan perundang-undangan yang berlaku tentang Hukum Waris di Indonesia.',
            'status' => 'aktif',
        ]);

        $layanan2->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi Surat/Akta Kematian Pewaris (Almarhum/Almarhumah)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pewaris (Semasa hidup)'],
            ['deskripsi_dokumen' => 'Fotokopi Buku Nikah/Akta Perkawinan Pewaris (Legalisir KUA/Catatan Sipil)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK seluruh Ahli Waris'],
            ['deskripsi_dokumen' => 'Fotokopi Akta Kelahiran seluruh Ahli Waris'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Ahli Waris yang ditandatangani oleh seluruh ahli waris di atas materai, diketahui RT/RW'],
            ['deskripsi_dokumen' => 'Bagan Silsilah Keluarga Waris yang dibuat pemohon dan diketahui RT/RW'],
            ['deskripsi_dokumen' => 'Fotokopi KTP 2 (dua) orang saksi (yang mengetahui silsilah keluarga)'],
        ]);

        $layanan2->alurProses()->createMany([
            ['deskripsi_alur' => 'Seluruh ahli waris sepakat membuat Surat Pernyataan Ahli Waris dan Bagan Silsilah.'],
            ['deskripsi_alur' => 'Salah satu ahli waris melakukan Booking Antrean Online di website SiPentas.'],
            ['deskripsi_alur' => 'Datang ke Kelurahan membawa berkas lengkap. Petugas FO melakukan verifikasi awal.'],
            ['deskripsi_alur' => 'Berkas diverifikasi oleh Seksi Pemerintahan. Jika ada kekurangan, pemohon akan dihubungi.'],
            ['deskripsi_alur' => 'Draft Surat Keterangan Waris dibuat dan diajukan untuk tanda tangan Lurah.'],
            ['deskripsi_alur' => 'Surat Keterangan Waris yang telah selesai dapat diambil oleh pemohon dengan membawa bukti pengambilan.'],
        ]);

        // ==========================================
        // 3. Layanan: Persyaratan Persamaan Orang yang Sama
        // ==========================================
        $layanan3 = Layanan::create([
            'nama_layanan' => 'Persyaratan Persamaan Orang yang Sama',
            'deskripsi' => 'Surat keterangan yang menyatakan bahwa dua nama atau lebih yang berbeda dalam dokumen kependudukan/pertanahan merujuk pada satu orang yang sama.',
            'estimasi_proses' => '1-3 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Ketentuan administrasi kependudukan dan pencatatan sipil.',
            'status' => 'aktif',
        ]);

        $layanan3->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pemohon (yang berlaku saat ini)'],
            ['deskripsi_dokumen' => 'Surat Pernyataan bermaterai Rp 10.000 yang menyatakan perbedaan nama merujuk pada orang yang sama'],
            ['deskripsi_dokumen' => 'Dokumen-dokumen ASLI dan Fotokopi yang memiliki perbedaan nama (misal: KTP lama, Ijazah, Akta Lahir, Sertifikat Tanah, Buku Nikah, dll)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP 2 (dua) orang saksi (yang mengetahui identitas pemohon)'],
            ['deskripsi_dokumen' => 'Surat Kuasa bermaterai jika pengurusan diwakilkan'],
        ]);

        $layanan3->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online.'],
            ['deskripsi_alur' => 'Pemohon datang ke Kelurahan membawa dokumen asli dan fotokopi yang terdapat perbedaan data.'],
            ['deskripsi_alur' => 'Petugas FO melakukan wawancara singkat dan mencocokkan dokumen fisik.'],
            ['deskripsi_alur' => 'Petugas berwenang melakukan verifikasi data kependudukan.'],
            ['deskripsi_alur' => 'Surat Keterangan dibuat dan ditandatangani.'],
            ['deskripsi_alur' => 'Dokumen selesai dan diserahkan kembali kepada pemohon.'],
        ]);

        // ==========================================
        // 4. Layanan: Persyartan Alamat yang Sama
        // ==========================================
        $layanan4 = Layanan::create([
            'nama_layanan' => 'Persyaratan Keterangan Alamat Sama', // Sedikit perbaikan nama
            'deskripsi' => 'Surat keterangan yang menyatakan bahwa perbedaan penulisan alamat pada dokumen (misal: beda RT/RW karena pemekaran) merujuk pada lokasi yang sama.',
            'estimasi_proses' => '1-2 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Ketentuan administrasi wilayah dan kependudukan.',
            'status' => 'aktif',
        ]);

        $layanan4->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat yang menjelaskan perubahan/perbedaan alamat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pemohon'],
            ['deskripsi_dokumen' => 'Dokumen-dokumen ASLI dan Fotokopi yang memiliki perbedaan alamat (misal: Sertifikat, PBB, KTP lama)'],
            ['deskripsi_dokumen' => 'Fotokopi SPPT PBB tahun terakhir'],
            ['deskripsi_dokumen' => 'Foto lokasi objek (rumah/tanah) - Opsional, jika diperlukan'],
        ]);

        $layanan4->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online.'],
            ['deskripsi_alur' => 'Datang ke Kelurahan membawa dokumen yang menunjukkan perbedaan alamat.'],
            ['deskripsi_alur' => 'Petugas melakukan verifikasi data wilayah (RT/RW).'],
            ['deskripsi_alur' => 'Surat keterangan diproses dan ditandatangani.'],
            ['deskripsi_alur' => 'Dokumen selesai dan dapat diambil.'],
        ]);

        // ==========================================
        // 5. Layanan: Persyaratan Pernyataan Ahli Waris (Bujangan/Belum Nikah)
        // ==========================================
        $layanan5 = Layanan::create([
            'nama_layanan' => 'Persyaratan Ahli Waris (Pewaris Belum Menikah)',
            'deskripsi' => 'Surat Keterangan Waris untuk pewaris yang meninggal dalam status belum pernah menikah, di mana ahli warisnya adalah orang tua atau saudara kandung.',
            'estimasi_proses' => '2-5 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Hukum Waris yang berlaku.',
            'status' => 'aktif',
        ]);

        $layanan5->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi Surat/Akta Kematian Pewaris'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Belum Pernah Menikah dari RT/RW setempat'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pewaris'],
            ['deskripsi_dokumen' => 'Fotokopi Buku Nikah Orang Tua Pewaris'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Orang Tua (Ayah & Ibu) sebagai ahli waris utama'],
            ['deskripsi_dokumen' => 'Fotokopi Akta Kelahiran Pewaris'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Saudara Kandung Pewaris (jika orang tua sudah tiada)'],
            ['deskripsi_dokumen' => 'Bagan Silsilah Keluarga yang diketahui RT/RW'],
            ['deskripsi_dokumen' => 'Fotokopi KTP 2 (dua) orang saksi'],
        ]);

        $layanan5->alurProses()->createMany([
            ['deskripsi_alur' => 'Keluarga menyiapkan dokumen dan membuat bagan silsilah.'],
            ['deskripsi_alur' => 'Melakukan Booking Antrean Online di SiPentas.'],
            ['deskripsi_alur' => 'Menyerahkan berkas ke petugas FO Kelurahan.'],
            ['deskripsi_alur' => 'Verifikasi berkas oleh Seksi Pemerintahan, memastikan status "belum menikah" pewaris.'],
            ['deskripsi_alur' => 'Proses pembuatan dan penandatanganan surat oleh Lurah.'],
            ['deskripsi_alur' => 'Surat Keterangan Waris selesai.'],
        ]);

        // ==========================================
        // 6. Layanan: Persyaratan SPPT PBB Baru
        // ==========================================
        $layanan6 = Layanan::create([
            'nama_layanan' => 'Persyaratan Pendaftaran SPPT PBB Baru',
            'deskripsi' => 'Layanan untuk mendaftarkan objek pajak baru (tanah/bangunan) agar diterbitkan SPPT PBB.',
            'estimasi_proses' => '3-7 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Peraturan perpajakan daerah terkait PBB-P2.',
            'status' => 'aktif',
        ]);

        $layanan6->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Mengisi Formulir SPOP (Surat Pemberitahuan Objek Pajak) - disediakan di Kelurahan/UPPRD'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pemilik/Wajib Pajak'],
            ['deskripsi_dokumen' => 'Fotokopi Bukti Kepemilikan Tanah (Sertifikat/AJB/Girik)'],
            ['deskripsi_dokumen' => 'Fotokopi IMB/PBG (jika ada bangunan)'],
            ['deskripsi_dokumen' => 'Fotokopi SPPT PBB tetangga terdekat (untuk acuan NJOP)'],
            ['deskripsi_dokumen' => 'Foto lokasi objek pajak (tanah/bangunan)'],
            ['deskripsi_dokumen' => 'Surat Kuasa bermaterai jika pengurusan diwakilkan'],
        ]);

        $layanan6->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online.'],
            ['deskripsi_alur' => 'Datang ke Kelurahan, petugas FO akan membantu mengarahkan pengisian formulir SPOP.'],
            ['deskripsi_alur' => 'Berkas diverifikasi. Kelurahan akan membuat Surat Pengantar ke UPPRD (Unit Pelayanan Pajak & Retribusi Daerah) Kecamatan.'],
            ['deskripsi_alur' => 'Petugas Kelurahan/UPPRD mungkin akan melakukan survei lokasi jika diperlukan.'],
            ['deskripsi_alur' => 'Proses penerbitan NOP dan SPPT PBB dilakukan di UPPRD.'],
            ['deskripsi_alur' => 'Pemohon akan dihubungi jika SPPT PBB Baru sudah terbit.'],
        ]);

        // ==========================================
        // 7. Layanan: Persyaratan Sertifikat (Pendaftaran Tanah Pertama Kali)
        // ==========================================
        $layanan7 = Layanan::create([
            'nama_layanan' => 'Persyaratan Pendaftaran Tanah Pertama Kali (Sertifikat)',
            'deskripsi' => 'Layanan surat keterangan dari Kelurahan sebagai syarat untuk mengajukan permohonan sertifikat tanah (dari tanah adat/girik) ke Kantor Pertanahan (BPN).',
            'estimasi_proses' => '3-7 Hari Kerja (di Kelurahan)',
            'biaya' => 'Rp 0,- (Gratis di Kelurahan)',
            'dasar_hukum' => 'Peraturan Pemerintah tentang Pendaftaran Tanah.',
            'status' => 'aktif',
        ]);

        $layanan7->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pemohon'],
            ['deskripsi_dokumen' => 'Bukti kepemilikan tanah ASLI (Girik, Letter C, Petok D, atau surat keterangan tanah lainnya)'],
            ['deskripsi_dokumen' => 'Riwayat Tanah yang dibuat oleh RT/RW dan diketahui oleh sesepuh/tokoh masyarakat setempat'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Penguasaan Fisik Bidang Tanah (Sporadik) bermaterai, disaksikan 2 orang saksi'],
            ['deskripsi_dokumen' => 'Surat Pernyataan Tanah Tidak Sengketa bermaterai, diketahui RT/RW'],
            ['deskripsi_dokumen' => 'Fotokopi SPPT PBB tahun berjalan dan bukti lunas'],
            ['deskripsi_dokumen' => 'Fotokopi KTP saksi-saksi (batas tanah dan saksi penguasaan fisik)'],
        ]);

        $layanan7->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online.'],
            ['deskripsi_alur' => 'Datang ke Kelurahan membawa seluruh dokumen asli untuk diverifikasi.'],
            ['deskripsi_alur' => 'Petugas Kelurahan melakukan verifikasi mendalam terhadap riwayat tanah dan dokumen girik.'],
            ['deskripsi_alur' => 'Lurah menandatangani Surat Keterangan Riwayat Tanah dan Surat Pengantar ke BPN.'],
            ['deskripsi_alur' => 'Pemohon mengambil dokumen di Kelurahan untuk selanjutnya didaftarkan sendiri ke Kantor Pertanahan (BPN).'],
        ]);

        // ==========================================
        // 8. Layanan: Persyaratan Peningkatan Hak / Rumah Tinggal
        // ==========================================
        $layanan8 = Layanan::create([
            'nama_layanan' => 'Persyaratan Peningkatan Hak (HGB ke SHM)',
            'deskripsi' => 'Layanan surat pengantar dari Kelurahan untuk permohonan peningkatan hak atas tanah dari Hak Guna Bangunan (HGB) menjadi Sertifikat Hak Milik (SHM) untuk rumah tinggal.',
            'estimasi_proses' => '1-3 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis di Kelurahan)',
            'dasar_hukum' => 'Peraturan Menteri Agraria/Kepala BPN tentang Peningkatan Hak.',
            'status' => 'aktif',
        ]);

        $layanan8->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pemohon'],
            ['deskripsi_dokumen' => 'Fotokopi Sertifikat Hak Guna Bangunan (HGB) yang masih berlaku'],
            ['deskripsi_dokumen' => 'Fotokopi IMB/PBG (Izin Mendirikan Bangunan) rumah tinggal'],
            ['deskripsi_dokumen' => 'Fotokopi SPPT PBB tahun berjalan dan bukti lunas'],
            ['deskripsi_dokumen' => 'Surat Pernyataan bahwa tanah digunakan untuk rumah tinggal (bermaterai)'],
        ]);

        $layanan8->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online.'],
            ['deskripsi_alur' => 'Menyerahkan berkas ke petugas FO Kelurahan.'],
            ['deskripsi_alur' => 'Petugas melakukan verifikasi bahwa penggunaan tanah benar untuk rumah tinggal.'],
            ['deskripsi_alur' => 'Surat Pengantar Peningkatan Hak ditandatangani Lurah.'],
            ['deskripsi_alur' => 'Pemohon mengambil surat pengantar untuk dibawa ke BPN.'],
        ]);

        // ==========================================
        // 9. Layanan: Persyaratan Balik Nama SPPT PBB
        // ==========================================
        $layanan9 = Layanan::create([
            'nama_layanan' => 'Persyaratan Balik Nama SPPT PBB',
            'deskripsi' => 'Layanan untuk mengubah nama wajib pajak pada SPPT PBB karena jual beli, waris, atau hibah.',
            'estimasi_proses' => '3-7 Hari Kerja',
            'biaya' => 'Rp 0,- (Gratis)',
            'dasar_hukum' => 'Peraturan perpajakan daerah terkait PBB-P2.',
            'status' => 'aktif',
        ]);

        $layanan9->dokumenWajib()->createMany([
            ['deskripsi_dokumen' => 'Surat Pengantar dari RT dan RW setempat (Asli)'],
            ['deskripsi_dokumen' => 'Mengisi Formulir SPOP/LSPOP (Surat Pemberitahuan Objek Pajak)'],
            ['deskripsi_dokumen' => 'Fotokopi KTP dan KK Pemilik Baru'],
            ['deskripsi_dokumen' => 'Fotokopi Bukti Peralihan Hak (Akta Jual Beli/Akta Hibah/Surat Waris)'],
            ['deskripsi_dokumen' => 'Fotokopi Sertifikat Tanah (yang sudah balik nama, jika ada)'],
            ['deskripsi_dokumen' => 'ASLI SPPT PBB tahun terakhir atas nama pemilik lama'],
            ['deskripsi_dokumen' => 'Bukti lunas PBB 5 (lima) tahun terakhir (jika ada tunggakan)'],
        ]);

        $layanan9->alurProses()->createMany([
            ['deskripsi_alur' => 'Pemohon melakukan Booking Antrean Online.'],
            ['deskripsi_alur' => 'Datang ke Kelurahan, petugas FO membantu mengisi/memverifikasi formulir SPOP.'],
            ['deskripsi_alur' => 'Berkas diverifikasi kelengkapannya oleh petugas PBB Kelurahan.'],
            ['deskripsi_alur' => 'Kelurahan membuat pengantar dan meneruskan berkas ke UPPRD Kecamatan.'],
            ['deskripsi_alur' => 'Proses perubahan data (balik nama) dilakukan di sistem UPPRD.'],
            ['deskripsi_alur' => 'Pemohon akan menerima SPPT PBB dengan nama baru pada tahun pajak berikutnya, atau dapat meminta cetak salinan di UPPRD.'],
        ]);
    }
}