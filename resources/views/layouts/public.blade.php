<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kelurahan Klender') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Stack untuk CSS kustom per halaman (seperti Trix Editor) --}}
    @stack('styles')
</head>
<body class="h-full font-sans antialiased">
<div class="flex min-h-full flex-col">

    {{-- HEADER (Menggunakan Warna Primary-900 / Hijau Tua) --}}
    <header class="bg-primary-900 sticky top-0 z-50 shadow-sm" x-data="{ open: false }">
        <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="{{ route('beranda') }}">
                        {{-- KODE LOGO BARU --}}
                        <img class="block h-12 w-auto" src="{{ asset('images/logo-kelurahan.png') }}" alt="Logo Kelurahan">
                    </a>
            </div>

            <div class="flex lg:hidden">
                <button type="button" @click="open = true" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-primary-200 hover:text-white">
                    <span class="sr-only">Buka menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            {{-- Link Navigasi Desktop --}}
            <div class="hidden lg:flex lg:gap-x-12">
                {{-- PERUBAHAN: hover:text-accent-300 (Emas Muda) --}}
                <a href="/" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Beranda</a>
                <a href="{{ route('booking.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">
                    Booking Online
                </a>
                <a href="{{ route('layanan.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Jenis Layanan</a>
                <a href="{{ route('lacak.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Lacak Pengajuan</a>
                <a href="{{ route('bantuan.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Bantuan & Chatbot</a>
                <a href="{{ route('pengumuman.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Berita</a>
                <a href="{{ route('kontak') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Kontak Kami</a>
            </div>

            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                {{-- PERUBAHAN: hover:text-accent-300 (Emas Muda) --}}
                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Log in Petugas <span aria-hidden="true">&rarr;</span></a>
            </div>
        </nav>

        {{-- Menu Mobile --}}
        <div class="lg:hidden" x-show="open" @click.away="open = false" x-transition>
            <div class="fixed inset-0 z-50"></div>
            <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-primary-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
                <div class="flex items-center justify-between">
                    <a href="/" class="-m-1.5 p-1.5">
                        <span class="text-lg font-bold text-white">KEL. KLENDER</span>
                    </a>
                    <button type="button" @click="open = false" class="-m-2.5 rounded-md p-2.5 text-primary-200 hover:text-white">
                        <span class="sr-only">Tutup menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-primary-700/50">
                        <div class="space-y-2 py-6">
                            {{-- PERUBAHAN: hover:bg-primary-800 --}}
                            <a href="/" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Beranda</a>
                            <a href="{{ route('layanan.index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Jenis Layanan</a>
                            <a href="{{ route('booking.index') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">
                                Booking Online
                            </a>
                            <a href="{{ route('lacak.index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Lacak Pengajuan</a>
                            <a href="{{ route('bantuan.index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Bantuan & Chatbot</a>
                            <a href="{{ route('pengumuman.index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Berita</a>
                            <a href="{{ route('kontak') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Kontak Kami</a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Log in Petugas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    {{-- Konten Utama Halaman --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- FOOTER (Menggunakan Warna Primary-900 / Hijau Tua) --}}
    <footer class="bg-primary-900 text-white" aria-labelledby="footer-heading">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8">
                     <span class="text-2xl font-bold text-white">KELURAHAN KLENDER</span>
                    <p class="text-sm leading-6 text-primary-200">
                        Website Sistem Informasi Pelayanan Pertanahan Kelurahan Klender. Melayani masyarakat dengan cepat, transparan, dan akuntabel.
                    </p>
                </div>
                
                <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Layanan Utama</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                {{-- PERUBAHAN: hover:text-accent-300 (Emas Muda) --}}
                                <li><a href="#" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Surat Jual Beli</a></li>
                                <li><a href="#" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Surat Waris</a></li>
                                <li><a href="#" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Riwayat Tanah</a></li>
                            </ul>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Navigasi</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                {{-- PERUBAHAN: hover:text-accent-300 (Emas Muda) --}}
                                <li><a href="{{ route('pengumuman.index') }}" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Berita</a></li>
                                <li><a href="{{ route('lacak.index') }}" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Lacak Pengajuan</a></li>
                                <li><a href="{{ route('bantuan.index') }}" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Bantuan</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold leading-6 text-white">Kontak</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li><p class="text-sm leading-6 text-primary-200">Jl. Raya Klender No. 1, Jakarta Timur, DKI Jakarta 13470</p></li>
                                <li><p class="text-sm leading-6 text-primary-200">(021) 123-4567</p></li>
                                <li><p class="text-sm leading-6 text-primary-200">kontak@kel-klender.go.id</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 border-t border-primary-700 pt-8 sm:mt-20 lg:mt-24">
                <p class="text-xs leading-5 text-primary-300">&copy; {{ date('Y') }} Kelurahan Klender. Dibuat oleh Mahasiswa Gunadarma.</p>
            </div>
        </div>
    </footer>

    {{-- ================================================================== --}}
    {{-- <<< FLOATING CHATBOT WIDGET (SiPentas Bot) >>> --}}
    {{-- ================================================================== --}}
    
    <div x-data="chatBotData()" x-init="initChat()" class="fixed bottom-4 right-4 z-50 flex flex-col items-end font-sans">

        {{-- 1. JENDELA CHAT (Muncul jika isOpen = true) --}}
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-10 scale-95"
             class="mb-4 w-full max-w-[350px] sm:w-[400px] bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col"
             style="height: 500px; max-height: 80vh; display: none;"> {{-- Style display:none agar tidak kedip saat load --}}

            {{-- Header Jendela Chat --}}
            <div class="bg-primary-600 p-4 text-white flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    {{-- Avatar Robot --}}
                    <div class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm p-1">
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-white">
                          <path d="M16.5 7.5h-9v9h9v-9z" opacity=".3"/><path d="M21.75 10.5h-1.5v-3a2.25 2.25 0 00-2.25-2.25h-1.5v-3a2.25 2.25 0 00-2.25-2.25h-4.5a2.25 2.25 0 00-2.25 2.25v3h-1.5A2.25 2.25 0 003.75 7.5v3H2.25A2.25 2.25 0 000 12.75v4.5a2.25 2.25 0 002.25 2.25h1.5v3a2.25 2.25 0 002.25 2.25h4.5a2.25 2.25 0 002.25-2.25v-3h1.5a2.25 2.25 0 002.25-2.25v-4.5a2.25 2.25 0 00-2.25-2.25zM6.75 2.25h4.5v3h-4.5v-3zm9 15h-1.5v3h-4.5v-3h-1.5v-4.5h7.5v4.5zm4.5-4.5h-1.5v-3h1.5v3zm-18 0h-1.5v-3h1.5v3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">SiPentas Bot</h3>
                        <p class="text-xs text-primary-100 flex items-center">
                            <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                            Online - Asisten Pertanahan
                        </p>
                    </div>
                </div>
                {{-- Tombol Tutup (X) --}}
                <button @click="toggleChat()" class="text-white/80 hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Area Riwayat Pesan (Scrollable) --}}
            <div x-ref="chatContainer" class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-4">
                
                {{-- Looping pesan dari array 'messages' --}}
                <template x-for="(msg, index) in messages" :key="index">
                    <div class="flex flex-col" :class="msg.isBot ? 'items-start' : 'items-end'">
                        <div class="max-w-[85%] rounded-2xl px-4 py-3 shadow-sm text-sm leading-relaxed"
                             :class="msg.isBot ? 'bg-white text-gray-800 rounded-tl-none border border-gray-100' : 'bg-primary-600 text-white rounded-tr-none'">
                            {{-- Menampilkan teks pesan (mendukung newline \n) --}}
                            <p class="whitespace-pre-wrap" x-text="msg.text"></p>
                        </div>
                        {{-- Waktu pesan (opsional, bisa dikembangkan nanti) --}}
                        <span class="text-[10px] text-gray-400 mt-1.5 mx-1" x-text="msg.isBot ? 'SiPentas Bot' : 'Anda'"></span>
                    </div>
                </template>

                {{-- Indikator Loading (Muncul saat isLoading = true) --}}
                <div x-show="isLoading" class="flex items-start animate-pulse">
                    <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">
                        <div class="flex space-x-1.5">
                            <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Area Input Pesan --}}
            <div class="p-3 bg-white border-t border-gray-100">
                <form @submit.prevent="sendMessage" class="flex items-center space-x-2 relative">
                    <input 
                        type="text" 
                        x-model="userInput"
                        :disabled="isLoading"
                        placeholder="Ketik pertanyaan pertanahan..." 
                        class="w-full border-gray-200 rounded-full py-3 pl-5 pr-12 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 disabled:bg-gray-50 text-sm"
                    >
                    <button 
                        type="submit"
                        :disabled="isLoading || userInput.trim() === ''"
                        class="absolute right-2 bg-primary-600 text-white p-2 rounded-full hover:bg-primary-700 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center"
                    >
                        {{-- Ikon Kirim --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 pl-0.5">
                          <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                        </svg>
                    </button>
                </form>
            </div>

        </div>

        {{-- 2. TOMBOL PEMICU (TRIGGER BUTTON) --}}
        <button @click="toggleChat()" 
                class="bg-primary-600 text-white p-4 rounded-full shadow-lg hover:bg-primary-700 hover:scale-110 transition-all duration-300 focus:outline-none group relative z-50">
            {{-- Ikon Chat Bubble --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            {{-- Badge Notifikasi Palsu (Pemanis) --}}
            <span class="absolute top-0 right-0 block h-3 w-3 transform -translate-y-1/2 translate-x-1/2 rounded-full ring-2 ring-white bg-red-500 animate-pulse"></span>
        </button>

    </div>

    {{-- SCRIPT LOGIKA (Alpine.js) --}}
    <script>
        function chatBotData() {
            return {
                isOpen: false,      // Status jendela chat (terbuka/tertutup)
                userInput: '',      // Teks yang diketik user
                isLoading: false,   // Status loading saat menunggu AI
                messages: [],       // Array untuk menyimpan riwayat chat

                // Fungsi inisialisasi (dijalankan saat halaman muat)
                initChat() {
                    // Tambahkan pesan pembuka dari Bot
                    this.messages.push({
                        text: "Halo! 👋 Saya SiPentas Bot, asisten virtual pertanahan Kelurahan Klender.\n\nAda yang bisa saya bantu terkait layanan atau persyaratan dokumen pertanahan hari ini?",
                        isBot: true
                    });
                },

                // Fungsi untuk buka/tutup jendela chat
                toggleChat() {
                    this.isOpen = !this.isOpen;
                    this.scrollToBottom(); // Scroll ke bawah saat dibuka
                },

                // Fungsi Utama: Mengirim Pesan ke Backend Laravel
                sendMessage() {
                    const message = this.userInput.trim();
                    if (message === '' || this.isLoading) return;

                    // 1. Tampilkan pesan user di layar
                    this.messages.push({ text: message, isBot: false });
                    this.userInput = ''; // Kosongkan input
                    this.isLoading = true; // Nyalakan loading
                    this.scrollToBottom();

                    // 2. Kirim ke Rute API Laravel via FETCH
                    fetch("{{ route('chat.send') }}", { // Memanggil rute POST yang kita buat tadi
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Wajib untuk keamanan Laravel
                        },
                        body: JSON.stringify({ message: message }) // Kirim data pesan
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        // 3. Terima balasan AI dan tampilkan
                        if (data.status === 'success') {
                            this.messages.push({ text: data.message, isBot: true });
                        } else {
                             this.messages.push({ text: "Maaf, terjadi kesalahan sistem.", isBot: true });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.messages.push({ text: "Maaf, saya tidak dapat terhubung ke server saat ini. Mohon periksa koneksi internet Anda.", isBot: true });
                    })
                    .finally(() => {
                        // 4. Matikan loading & scroll ke bawah apapun hasilnya
                        this.isLoading = false;
                        this.scrollToBottom();
                    });
                },

                // Helper untuk auto-scroll ke pesan terakhir
                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = this.$refs.chatContainer;
                        container.scrollTop = container.scrollHeight;
                    });
                }
            }
        }
    </script>
    
</div> 

{{-- Stack untuk Skrip kustom per halaman --}}
@stack('scripts')
</body>
</html>