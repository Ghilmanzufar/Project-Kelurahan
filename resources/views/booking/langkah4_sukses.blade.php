<x-public-layout>
    <div class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100 text-center">
            
            {{-- Ikon Sukses Animasi --}}
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-primary-100 mb-6 animate-bounce-slow">
                <svg class="h-12 w-12 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <div>
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
                    Janji Temu Berhasil Dibuat!
                </h2>
                <p class="mt-4 text-lg text-gray-500">
                    Terima kasih, permohonan Anda telah kami terima.
                    <br>
                    Bukti booking lengkap telah dikirimkan ke email: 
                    <span class="font-bold text-primary-700">{{ $emailPemohon ?? '-' }}</span>
                </p>
            </div>

            {{-- Kotak Nomor Booking & QR Code --}}
            <div class="mt-8 bg-primary-50 rounded-xl p-6 border-2 border-primary-100 border-dashed relative overflow-hidden group hover:border-primary-300 transition-colors duration-300">
                <div class="absolute top-0 left-0 w-full h-1 bg-primary-500"></div>
                
                <h3 class="text-sm font-medium text-primary-600 uppercase tracking-wider mb-4">Tunjukkan QR Code Ini Kepada Petugas</h3>
                
                {{-- =============================================== --}}
                {{-- <<< QR CODE GENERATOR >>> --}}
                {{-- =============================================== --}}
                <div class="flex justify-center mb-6">
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        {{-- Generate QR Code dari Nomor Booking --}}
                        {!! QrCode::size(160)->generate($nomorBooking) !!}
                    </div>
                </div>
                {{-- =============================================== --}}
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <span id="booking-code" class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight font-mono selection:bg-primary-200 selection:text-primary-900">
                        {{ $nomorBooking }}
                    </span>
                    
                    <button onclick="copyToClipboard()" 
                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-primary-700 bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
                            title="Salin Nomor Booking">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin
                    </button>
                </div>
                <p id="copy-feedback" class="text-xs text-primary-600 mt-2 opacity-0 transition-opacity duration-300">Berhasil disalin!</p>
            </div>

            {{-- Langkah Selanjutnya --}}
            <div class="mt-8 text-left bg-gray-50 rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-5 w-5 text-accent-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Apa yang harus dilakukan selanjutnya?
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="flex-shrink-0 h-5 w-5 flex items-center justify-center rounded-full bg-primary-100 text-primary-600 text-xs font-bold mt-0.5 mr-3">1</span>
                        <span class="text-sm text-gray-600">Simpan <strong>QR Code</strong> atau Nomor Booking ini (Screenshot layar ini).</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 h-5 w-5 flex items-center justify-center rounded-full bg-primary-100 text-primary-600 text-xs font-bold mt-0.5 mr-3">2</span>
                        <span class="text-sm text-gray-600">Datang ke Kantor Kelurahan sesuai jadwal yang dipilih.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="flex-shrink-0 h-5 w-5 flex items-center justify-center rounded-full bg-primary-100 text-primary-600 text-xs font-bold mt-0.5 mr-3">3</span>
                        <span class="text-sm text-gray-600">Tunjukkan QR Code ini kepada petugas di loket untuk <strong>Check-in Otomatis</strong>.</span>
                    </li>
                </ul>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                {{-- Tombol Primary: Lacak --}}
                <a href="{{ route('lacak.index', ['search' => $nomorBooking]) }}" 
                   class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 md:py-4 md:text-lg md:px-10 shadow-sm transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Lacak Status Saya
                </a>

                {{-- Tombol Secondary: Beranda --}}
                <a href="{{ route('beranda') }}" 
                   class="w-full sm:w-auto flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10 shadow-sm transition-all duration-200">
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    {{-- Script Sederhana untuk Copy to Clipboard --}}
    <script>
        function copyToClipboard() {
            const bookingCode = document.getElementById('booking-code').innerText.trim();
            navigator.clipboard.writeText(bookingCode).then(() => {
                const feedback = document.getElementById('copy-feedback');
                feedback.classList.remove('opacity-0');
                setTimeout(() => {
                    feedback.classList.add('opacity-0');
                }, 2000);
            });
        }
    </script>
</x-public-layout>