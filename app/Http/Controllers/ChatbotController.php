<?php

namespace App\Http\Controllers;

use App\Services\GroqService;
use Illuminate\Http\Request;
use App\Models\Layanan; 
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $groqService;

    // Prompt Sistem: Ini adalah "otak" dan "aturan main" untuk si Bot.
    // Prompt Sistem yang DIPERBAHARUI (Lebih Tegas & Logis)
    protected $systemPrompt = <<<EOT
Kamu adalah 'SiPentas Bot', Asisten Virtual Cerdas yang bekerja di kantor Kelurahan Klender.

Peran utamamu adalah membantu warga dengan informasi seputar:
1. Layanan administrasi pertanahan di kelurahan (PBB, Waris, Surat Keterangan Tanah, dll).
2. Persyaratan dan prosedur dokumen pertanahan di Kelurahan Klender.

PEDOMAN MENJAWAB (PENTING):

LANGKAH 1: Analisis pertanyaan pengguna. Tentukan apakah pertanyaan ini berkaitan dengan administrasi pertanahan di Kelurahan Klender atau tidak.

LANGKAH 2 (SKENARIO A: Jika Topik SESUAI Pertanahan):
- Jawablah langsung pertanyaan tersebut dengan jelas, sopan, formal, dan ringkas.
- JANGAN memulai jawaban dengan permintaan maaf jika topiknya sudah benar. Langsung ke inti jawaban.

LANGKAH 3 (SKENARIO B: Jika Topik MELENCENG/DI LUAR Pertanahan):
- Misalnya: pertanyaan tentang resep masakan, politik, curhat pribadi, coding, tugas sekolah umum, dll.
- Kamu WAJIB menolak menjawab substansi pertanyaannya.
- HANYA berikan respons standar ini (jangan ditambah informasi lain): "Mohon maaf, sebagai asisten khusus pertanahan Kelurahan Klender, saya hanya dapat menjawab pertanyaan terkait layanan administrasi pertanahan. Apakah ada hal lain terkait pertanahan yang bisa saya bantu?"

Catatan Tambahan untuk AI:
- Jangan mengarang prosedur hukum yang tidak pasti.
- Bersikaplah profesional dan membantu layaknya aparatur sipil negara.
EOT;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    // Fungsi test yang sudah diperbarui dengan System Prompt
    public function testConnection(Request $request)
    {
       // Ambil pertanyaan dari URL
        $userQuestion = $request->query('q', 'Apa saja syarat untuk layanan pecah PBB?');

        try {
            // 1. AMBIL "BUKU PANDUAN" DARI DATABASE
            $knowledgeBaseData = $this->getKnowledgeBaseContext();

            // 2. SIAPKAN INSTRUKSI TAMBAHAN
            // Kita beritahu AI untuk menggunakan data yang kita lampirkan.
            $ragInstruction = "\n\nINSTRUKSI KHUSUS (RAG):\n" .
            "Di bawah ini saya lampirkan 'KNOWLEDGE BASE' yang berisi data faktual layanan di Kelurahan Klender.\n" .
            "Tugasmu adalah menjawab pertanyaan pengguna dengan HANYA menggunakan informasi dari 'KNOWLEDGE BASE' tersebut.\n" .
            "Jika informasi tidak ditemukan di dalam data tersebut, katakan dengan jujur bahwa informasi belum tersedia, jangan mengarang.\n\n" .
            "--- AWAL KNOWLEDGE BASE ---\n" .
            $knowledgeBaseData . 
            "\n--- AKHIR KNOWLEDGE BASE ---\n";

            // 3. GABUNGKAN DENGAN SYSTEM PROMPT ASLI
            $fullSystemMessage = $this->systemPrompt . $ragInstruction;

            // 4. Susun pesan untuk dikirim
            $messages = [
                [
                    'role' => 'system',
                    // Gunakan pesan sistem yang sudah digabung data database
                    'content' => $fullSystemMessage 
                ],
                [
                    'role' => 'user',
                    'content' => $userQuestion
                ]
            ];

            // Kirim ke Groq
            $response = $this->groqService->chat($messages);

            return response()->json([
                'status' => 'success',
                'skenario' => 'Testing RAG (Database Injection)',
                'sumber_data' => 'Database MySQL Lokal',
                'pertanyaan_warga' => $userQuestion,
                'balasan_ai' => $response
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function getKnowledgeBaseContext()
    {
        // 1. Ambil semua layanan aktif beserta relasinya (eager loading)
        $semuaLayanan = Layanan::with(['dokumenWajib', 'alurProses'])
            ->where('status', 'aktif')
            ->get();

        if ($semuaLayanan->isEmpty()) {
            return "Belum ada data layanan pertanahan yang tersedia di database.";
        }

        $contextString = "BERIKUT ADALAH DATA RESMI LAYANAN PERTANAHAN DI KELURAHAN KLENDER:\n\n";

        // 2. Loop data dan format menjadi string
        foreach ($semuaLayanan as $index => $layanan) {
            $num = $index + 1;
            $contextString .= "=== LAYANAN {$num}: {$layanan->nama_layanan} ===\n";
            $contextString .= "Deskripsi: {$layanan->deskripsi}\n";
            $contextString .= "Estimasi Waktu: {$layanan->estimasi_proses}\n";
            $contextString .= "Biaya: {$layanan->biaya}\n\n";

            $contextString .= "[Persyaratan Dokumen Wajib]\n";
            foreach ($layanan->dokumenWajib as $dokumen) {
                $contextString .= "- {$dokumen->deskripsi_dokumen}\n";
            }
            $contextString .= "\n";

            $contextString .= "[Alur Proses]\n";
            foreach ($layanan->alurProses as $i => $alur) {
                $step = $i + 1;
                $contextString .= "{$step}. {$alur->deskripsi_alur}\n";
            }
            $contextString .= "\n--------------------------------------------------\n\n";
        }

        return $contextString;
    }

    // ... (namespace dan use di atas tetap sama)

    /**
     * Method resmi untuk menangani pesan dari Frontend (via AJAX POST).
     */
    public function sendMessage(Request $request)
    {
        // 1. Validasi: Pastikan ada pesan yang dikirim
        $request->validate([
            'message' => 'required|string|max:500', // Batasi maks 500 karakter agar tidak di-spam
        ]);

        $userMessage = $request->input('message');

        // --- DEBUG START ---
        Log::info('=== CHATBOT DEBUG START (SMART RAG) ===');
        Log::info('Pesan User Asli: ' . $userMessage);
        // --- DEBUG END ---

        try {
            // ============================================================
            // <<< LANGKAH 2: SMART RAG (FILTERING KATA KUNCI) >>>
            // ============================================================
            
            // 2a. Daftar kata-kata sambung/umum (stopwords) yang akan diabaikan dalam pencarian
            $stopwords = [
                'apa', 'apakah', 'bagaimana', 'dimana', 'kapan', 'siapa', 'mengapa', 'kenapa',
                'cara', 'syarat', 'prosedur', 'langkah', 'untuk', 'yang', 'di', 'ke', 'dari',
                'pada', 'dalam', 'atau', 'dan', 'dengan', 'ini', 'itu', 'tersebut', 'saya',
                'aku', 'kamu', 'anda', 'dia', 'mereka', 'kami', 'kita', 'mau', 'ingin',
                'akan', 'sedang', 'sudah', 'tanya', 'dong', 'min', 'pak', 'bu', 'mas', 'mbak',
                'kak', 'halo', 'hi', 'hai', 'selamat', 'pagi', 'siang', 'sore', 'malam',
                'terima', 'kasih', 'tolong', 'bantu', 'mohon', 'bisa', 'boleh', 'ada',
                'tidak', 'bukan', 'belum', 'ya', 'oke', 'baik'
            ];

            // 2b. Bersihkan pesan: huruf kecil semua, hapus simbol selain huruf/angka/spasi
            $cleanMessage = strtolower(preg_replace('/[^a-z0-9\s]/', '', $userMessage));
            $words = explode(' ', $cleanMessage);
            
            // 2c. Filter kata kunci: hapus stopword dan kata yang terlalu pendek (< 3 huruf)
            $keywords = array_filter($words, function($word) use ($stopwords) {
                // strlen($word) > 2 artinya minimal 3 huruf (contoh: PBB, KTP itu 3 huruf, jadi masuk)
                return !in_array($word, $stopwords) && strlen($word) > 2; 
            });

            // Reset array keys agar rapi (opsional, tapi baik untuk debugging)
            $keywords = array_values($keywords); 

            // --- DEBUG START ---
            Log::info('Keywords Final untuk Pencarian: ' . json_encode($keywords));
            // --- DEBUG END ---

            // 2d. Logika Pengambilan Data RAG
            $knowledgeBaseData = "";
            $ragInstruction = "";

            // Jika tidak ada kata kunci penting (misal cuma bilang "Halo"), JANGAN cari data.
            if (empty($keywords)) {
                // --- DEBUG START ---
                Log::info('Kondisi: Keywords KOSONG. Tidak ada data RAG yang diambil.');
                // --- DEBUG END ---
                // Tidak ada instruksi RAG tambahan. AI hanya akan pakai System Prompt dasar.
            } else {
                // --- DEBUG START ---
                Log::info('Kondisi: Keywords ADA. Mencari data relevan di database...');
                // --- DEBUG END ---

                // Panggil fungsi pencari data yang baru
                $knowledgeBaseData = $this->getFilteredKnowledgeBase($keywords);
                
                if (empty($knowledgeBaseData)) {
                     // --- DEBUG START ---
                     Log::info('Hasil Pencarian: NIHIL. Tidak ada layanan yang cocok dengan keyword.');
                     // --- DEBUG END ---
                     // Beri instruksi khusus jika data tidak ditemukan
                     $ragInstruction = "\n\nINSTRUKSI TAMBAHAN:\nPengguna menanyakan topik yang spesifik, TETAPI data detail mengenainya TIDAK DITEMUKAN dalam database layanan kita saat ini. Jawablah dengan sopan bahwa informasi detail belum tersedia di sistem, dan sarankan pengguna untuk datang langsung ke kantor kelurahan untuk konsultasi lebih lanjut.";
                } else {
                     // --- DEBUG START ---
                     Log::info('Hasil Pencarian: DITEMUKAN. Panjang Data RAG: ' . strlen($knowledgeBaseData) . ' karakter.');
                     // --- DEBUG END ---
                     // Beri instruksi RAG standar jika data ditemukan
                     $ragInstruction = "\n\nINSTRUKSI KHUSUS (RAG - DATA RELEVAN):\n" .
                     "Gunakan HANYA data 'KNOWLEDGE BASE RELEVAN' di bawah ini sebagai sumber utamamu untuk menjawab.\n" .
                     "--- AWAL KNOWLEDGE BASE RELEVAN ---\n" .
                     $knowledgeBaseData . 
                     "\n--- AKHIR KNOWLEDGE BASE RELEVAN ---\n";
                }
            }

            // ============================================================
            // <<< LANGKAH 3: PENYUSUNAN PESAN & PENGIRIMAN >>>
            // ============================================================

            // 3a. Gabungkan System Prompt dasar dengan instruksi RAG (jika ada)
            $fullSystemMessage = $this->systemPrompt . $ragInstruction;

            // --- DEBUG START ---
            Log::info('TOTAL Panjang Pesan Sistem ke Groq (Karakter): ' . strlen($fullSystemMessage));
            Log::info('=== CHATBOT DEBUG END ===');
            // --- DEBUG END ---

            // 3b. Susun array pesan untuk Groq
            // TODO: Nanti bisa ditambahkan riwayat chat sebelumnya di sini agar lebih "nyambung"
            $messages = [
                [
                    'role' => 'system',
                    'content' => $fullSystemMessage
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage
                ]
            ];

            // 4. Kirim ke Groq Service
            // Menggunakan model 'llama-3.1-8b-instant' (sesuai .env Anda) sangat disarankan.
            $aiResponseText = $this->groqService->chat($messages);

            // 5. Kembalikan respons sukses ke Frontend
            return response()->json([
                'status' => 'success',
                'message' => $aiResponseText,
                // Uncomment untuk debug di console browser
                // 'debug_keywords' => $keywords, 
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());
            
            // Tangani Rate Limit (429) secara khusus
            if (str_contains($e->getMessage(), '429')) {
                 return response()->json([
                    'status' => 'error',
                    'message' => 'Waduh, antrean si Pentas lagi penuh nih. Mohon tunggu sekitar 1 menit ya, nanti coba kirim pesannya lagi. 🙏'
                ], 429);
            }
            
            // Error umum lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, terjadi gangguan koneksi sesaat. Silakan coba kirim pesan Anda lagi.'
            ], 500);
        }
    }

    /**
     * FUNGSI BARU: Mengambil data layanan yang HANYA relevan dengan kata kunci.
     */
    private function getFilteredKnowledgeBase(array $keywords)
    {
        // Mulai query
        $query = Layanan::with(['dokumenWajib', 'alurProses'])
            ->where('status', 'aktif');

        // Tambahkan kondisi pencarian (WHERE ... LIKE ...)
        $query->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                // Cari di nama layanan ATAU deskripsinya
                $q->orWhere('nama_layanan', 'like', "%{$word}%")
                    ->orWhere('deskripsi', 'like', "%{$word}%");
            }
        });

        // Ambil hasilnya
        $relevantLayanan = $query->get();

        if ($relevantLayanan->isEmpty()) {
            return ""; // Tidak ada yang cocok
        }

        // Format menjadi string (sama seperti sebelumnya)
        $contextString = "BERIKUT DATA LAYANAN YANG RELEVAN:\n\n";
        foreach ($relevantLayanan as $index => $layanan) {
            $num = $index + 1;
            $contextString .= "=== LAYANAN {$num}: {$layanan->nama_layanan} ===\n";
            $contextString .= "Deskripsi: {$layanan->deskripsi}\n";
            $contextString .= "Estimasi Waktu: {$layanan->estimasi_proses}\n";
            // ... (kode format dokumenWajib dan alurProses sama seperti sebelumnya, hemat tempat di sini)
            // PASTIKAN ANDA MENYALIN KODE FORMAT LENGKAP DARI CONTROLLER LAMA ANDA KE SINI
            $contextString .= "[Persyaratan Dokumen Wajib]\n";
            foreach ($layanan->dokumenWajib as $dokumen) {
                $contextString .= "- {$dokumen->deskripsi_dokumen}\n";
            }
            $contextString .= "\n";

            $contextString .= "[Alur Proses]\n";
            foreach ($layanan->alurProses as $i => $alur) {
                $step = $i + 1;
                $contextString .= "{$step}. {$alur->deskripsi_alur}\n";
            }
            $contextString .= "\n--------------------------------------------------\n\n";
        }

        return $contextString;
    }
}