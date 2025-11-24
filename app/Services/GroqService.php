<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Exception;

class GroqService
{
    protected $client;
    protected $apiKey;
    protected $modelId;
    protected $baseUrl = 'https://api.groq.com/openai/v1/';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY');
        $this->modelId = env('GROQ_MODEL_ID', 'llama3-8b-8192');

        // Inisialisasi Guzzle Client dengan konfigurasi dasar
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'timeout'  => 30, // Waktu tunggu maksimal 30 detik
        ]);
    }

    /**
     * Mengirim pesan obrolan ke Groq AI dan mendapatkan balasannya.
     *
     * @param array $messages Array riwayat chat (format: [['role' => 'user', 'content' => '...']])
     * @return string Balasan teks dari AI
     * @throws Exception Jika terjadi error koneksi
     */
    public function chat(array $messages)
    {
        try {
            // Mempersiapkan data yang akan dikirim (Request Body)
            // Sesuai dokumentasi Groq (mirip OpenAI API)
            $body = [
                'model' => $this->modelId,
                'messages' => $messages,
                'temperature' => 0.7, // 0.0 = kaku/pasti, 1.0 = kreatif/acak. 0.7 seimbang.
                'max_tokens' => 1024, // Batas panjang jawaban AI
            ];

            // Mengirim permintaan POST ke endpoint 'chat/completions'
            $response = $this->client->post('chat/completions', [
                'json' => $body,
            ]);

            // Mengubah respons JSON menjadi Array PHP
            $data = json_decode($response->getBody()->getContents(), true);

            // Mengambil isi pesan balasan (assisten)
            // Struktur: choices[0] -> message -> content
            return $data['choices'][0]['message']['content'] ?? 'Maaf, terjadi kesalahan dalam memproses respons AI.';

        } catch (Exception $e) {
            // Catat error ke log file (storage/logs/laravel.log) agar mudah didebug
            Log::error('Groq API Error: ' . $e->getMessage());
            
            // Lempar error agar diketahui oleh pemanggil
            throw new Exception('Gagal menghubungi layanan AI. Silakan coba lagi nanti. (Cek log untuk detail)');
        }
    }
}