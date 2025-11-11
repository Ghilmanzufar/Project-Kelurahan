<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengumuman; // Import Model Pengumuman
use Carbon\Carbon; // Untuk tanggal yang mudah

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh Pengumuman 1: Kebijakan Layanan
        Pengumuman::create([
            'judul' => 'Penyesuaian Jam Layanan Terkait Cuti Bersama Akhir Tahun',
            'slug' => 'penyesuaian-jam-layanan-cuti-bersama-akhir-tahun',
            'isi_konten' => '
                <p>Yth. Warga Kelurahan Klender,</p>
                <p>Berikut adalah informasi lengkap mengenai penyesuaian jam layanan administrasi Kelurahan Klender terkait dengan periode cuti bersama akhir tahun.</p>
                
                <h3 class="text-lg font-semibold mt-4 mb-2">Tabel Rincian Jadwal Penyesuaian:</h3>
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">24 Des 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">08:00 - 11:00 WIB</td>
                            <td class="px-6 py-4 whitespace-nowrap">Layanan Khusus</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">25-26 Des 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">TUTUP</td>
                            <td class="px-6 py-4 whitespace-nowrap">Libur Nasional</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">27 Des 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">Normal (08:00 - 15:00)</td>
                            <td class="px-6 py-4 whitespace-nowrap">Normal</td>
                        </tr>
                    </tbody>
                </table>
                <p class="mt-4">Kami mohon maaf atas ketidaknyamanan yang mungkin timbul akibat penyesuaian jadwal ini.</p>
                <p class="mt-2">Hormat Kami,</p>
                <p class="font-semibold">Tim Administrasi Kelurahan Klender</p>
            ',
            'kategori' => 'Kebijakan',
            'tanggal_publikasi' => Carbon::parse('2025-10-28'),
            'file_pdf_path' => null, // Atau berikan path jika ada file dummy
            'status' => 'aktif',
        ]);

        // Contoh Pengumuman 2: Informasi Umum
        Pengumuman::create([
            'judul' => 'Sosialisasi Program Vaksinasi COVID-19 Tahap Lanjut',
            'slug' => 'sosialisasi-program-vaksinasi-covid-19-tahap-lanjut',
            'isi_konten' => '
                <p>Kepada seluruh warga Kelurahan Klender yang terhormat,</p>
                <p>Kami menginformasikan akan diadakannya sosialisasi program vaksinasi COVID-19 tahap lanjut. Sosialisasi ini bertujuan untuk memberikan informasi terkini mengenai pentingnya vaksinasi booster dan lokasi sentra vaksinasi terdekat.</p>
                <p>Mohon partisipasi aktif Bapak/Ibu sekalian demi kesehatan dan keselamatan bersama.</p>
                <p><strong>Tanggal:</strong> 15 November 2025</p>
                <p><strong>Waktu:</strong> 09:00 - Selesai</p>
                <p><strong>Tempat:</strong> Aula Kelurahan Klender</p>
            ',
            'kategori' => 'Kesehatan',
            'tanggal_publikasi' => Carbon::parse('2025-11-01'),
            'file_pdf_path' => null,
            'status' => 'aktif',
        ]);

        // Contoh Pengumuman 3: Peringatan Hari Besar
        Pengumuman::create([
            'judul' => 'Peringatan Hari Kemerdekaan RI ke-80',
            'slug' => 'peringatan-hari-kemerdekaan-ri-ke-80',
            'isi_konten' => '
                <p>Dirgahayu Republik Indonesia!</p>
                <p>Mari kita merayakan Hari Ulang Tahun Kemerdekaan Republik Indonesia yang ke-80 dengan semangat persatuan dan kesatuan. Berbagai kegiatan akan diselenggarakan di tingkat RT/RW.</p>
                <p>Informasi lebih lanjut mengenai jadwal lomba dan acara akan diumumkan oleh pengurus RT/RW masing-masing.</p>
            ',
            'kategori' => 'Hari Besar',
            'tanggal_publikasi' => Carbon::parse('2025-08-10'),
            'file_pdf_path' => null,
            'status' => 'aktif',
        ]);

        // Contoh Pengumuman 4: Pengumuman Tidak Aktif (Tidak akan muncul di frontend)
        Pengumuman::create([
            'judul' => 'Pengumuman Uji Coba Internal Sistem',
            'slug' => 'pengumuman-uji-coba-internal-sistem',
            'isi_konten' => '<p>Ini adalah pengumuman uji coba internal yang tidak seharusnya terlihat oleh publik.</p>',
            'kategori' => 'Internal',
            'tanggal_publikasi' => Carbon::parse('2025-10-01'),
            'file_pdf_path' => null,
            'status' => 'tidak_aktif', // Status non-aktif
        ]);
    }
}