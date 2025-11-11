<x-public-layout>
    <div class="mx-auto max-w-2xl px-6 py-12 lg:px-8 text-center">

        {{-- Icon Ceklis Hijau --}}
        <div class="mb-8 flex justify-center">
            <svg class="h-24 w-24 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Janji Temu Berhasil Dibuat!</h1>
        <p class="mt-6 text-lg leading-8 text-gray-700">
            Bukti booking dan detail lengkap telah dikirimkan ke email Anda 
            <span class="font-semibold italic">({{ $emailPemohon ?? 'email_anda@contoh.com' }})</span>
            dan notifikasi singkat ke No. HP Anda 
            <span class="font-semibold italic">({{ $nomorHpPemohon ?? '0812xxxxxx' }})</span>.
        </p>
        <p class="mt-2 text-md leading-7 text-gray-600">
            Mohon segera periksa kotak masuk (atau folder spam) email Anda.
        </p>

        <div class="mt-10 p-6 bg-blue-50 border-l-4 border-blue-400 text-blue-800 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold text-blue-800">Nomor Booking Anda adalah:</h2>
            <div class="mt-4 flex flex-col items-center">
                <div class="inline-block bg-white text-gray-900 font-extrabold text-3xl sm:text-4xl px-6 py-4 rounded-lg shadow-md border border-gray-200">
                    {{ $nomorBooking }}
                </div>
                <button id="copyBookingCode"
                        class="mt-4 inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.25M15.75 17.25H12m0-5.438V7.5m0 5.438H12m7.5-3.047v3.375C19.5 17.61 17.61 19.5 15.25 19.5H12m0-5.438V7.5" />
                    </svg>
                    <span>Salin Kode Booking</span>
                </button>
            </div>
        </div>

        <div class="mt-12 text-left">
            <h3 class="text-xl font-bold text-gray-900">Apa Langkah Selanjutnya?</h3>
            <ul class="mt-4 space-y-3 text-lg text-gray-700 list-decimal list-inside">
                <li>Harap simpan Nomor Booking ini. Anda dapat menggunakannya untuk:</li>
                <li>Ditunjukkan kepada petugas saat datang ke kelurahan.</li>
                <li>Melacak status pengajuan berkas Anda secara online.</li>
            </ul>
        </div>

        {{-- Tombol Navigasi --}}
        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-x-6 gap-y-4">
            <a href="#" {{-- Nanti akan diarahkan ke halaman Lacak Pengajuan --}}
               class="inline-flex w-full sm:w-auto items-center justify-center rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v6m-4.5-18H15M2.25 5.25h1.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-1.5a2.25 2.25 0 01-2.25-2.25V7.5A2.25 2.25 0 013.75 5.25z" />
                </svg>
                Lacak Pengajuan Saya
            </a>
            <a href="{{ route('beranda') }}"
               class="inline-flex w-full sm:w-auto items-center justify-center rounded-md bg-gray-200 px-8 py-4 text-base font-semibold text-gray-800 shadow-sm hover:bg-gray-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-200 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21.75h8.25a.75.75 0 00.75-.75v-6a.75.75 0 00-.75-.75H8.25a.75.75 0 00-.75.75v6a.75.75 0 00.75.75z" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    {{-- Script untuk menyalin kode booking --}}
    <script>
        document.getElementById('copyBookingCode').addEventListener('click', function() {
            const bookingCode = this.previousElementSibling.textContent.trim();
            navigator.clipboard.writeText(bookingCode)
                .then(() => {
                    alert('Nomor booking berhasil disalin!');
                    this.querySelector('span').textContent = 'Tersalin!';
                    setTimeout(() => {
                        this.querySelector('span').textContent = 'Salin Kode Booking';
                    }, 2000);
                })
                .catch(err => {
                    console.error('Gagal menyalin teks: ', err);
                    alert('Gagal menyalin nomor booking. Silakan salin secara manual.');
                });
        });
    </script>
</x-public-layout>