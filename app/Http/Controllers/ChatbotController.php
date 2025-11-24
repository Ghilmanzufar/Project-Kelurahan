<?php

namespace App\Http\Controllers;

use App\Services\GroqService;
use Illuminate\Http\Request;
use App\Models\Layanan; 

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

        try {
            // 2. Ambil Knowledge Base (RAG) - Sama seperti di testConnection
            $knowledgeBaseData = $this->getKnowledgeBaseContext();

            // 3. Siapkan Instruksi RAG - Sama seperti di testConnection
            $ragInstruction = "\n\nINSTRUKSI KHUSUS (RAG):\n" .
            "Di bawah ini saya lampirkan 'KNOWLEDGE BASE' yang berisi data faktual layanan di Kelurahan Klender.\n" .
            "Tugasmu adalah menjawab pertanyaan pengguna dengan HANYA menggunakan informasi dari 'KNOWLEDGE BASE' tersebut.\n" .
            "Jika informasi tidak ditemukan di dalam data tersebut, katakan dengan jujur bahwa informasi belum tersedia, jangan mengarang.\n\n" .
            "--- AWAL KNOWLEDGE BASE ---\n" .
            $knowledgeBaseData . 
            "\n--- AKHIR KNOWLEDGE BASE ---\n";

            // 4. Gabungkan System Prompt
            $fullSystemMessage = $this->systemPrompt . $ragInstruction;

            // 5. Susun Pesan (TODO: Nanti kita tambahkan riwayat chat di sini)
            // Untuk sekarang, kita kirim single-turn (satu tanya satu jawab) dulu.
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

            // 6. Kirim ke Groq
            $aiResponseText = $this->groqService->chat($messages);

            // 7. Kembalikan respons bersih untuk Frontend
            return response()->json([
                'status' => 'success',
                'message' => $aiResponseText, // Hanya teks jawaban AI yang kita butuhkan di UI
            ]);

        } catch (\Exception $e) {
            // Log error untuk developer
            \Log::error('Chatbot Error: ' . $e->getMessage());
            
            // Kembalikan pesan error yang ramah untuk pengguna
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, SiPentas sedang mengalami gangguan sesaat. Mohon coba beberapa saat lagi.'
            ], 500);
        }
    }
}