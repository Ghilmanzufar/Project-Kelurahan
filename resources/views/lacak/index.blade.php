<x-public-layout>
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION (BACKGROUND HIJAU TUA) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 pt-24 pb-48 overflow-hidden">
        {{-- Dekorasi Background (Pola Garis Halus) --}}
        <div class="absolute inset-0 overflow-hidden">
            <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-primary-700/50 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                Lacak Status Pengajuan
            </h1>
            <p class="mt-6 text-lg leading-8 text-primary-100 max-w-2xl mx-auto">
                Pantau progres berkas Anda secara real-time. Masukkan Nomor Booking yang Anda dapatkan saat pendaftaran.
            </p>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< KARTU PENCARIAN (FLOATING CARD) >>> --}}
    {{-- =============================================== --}}
    <div class="relative z-10 mx-auto max-w-3xl px-6 lg:px-8 -mt-32">
        <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 ring-1 ring-gray-200">
            
            {{-- Pesan Error (Jika Nomor Tidak Ditemukan) --}}
            @if (session('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">{{ session('error') }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('lacak.search') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="no_booking" class="block text-sm font-medium leading-6 text-gray-900">Nomor Booking / Registrasi</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="no_booking" id="no_booking" 
                               class="block w-full rounded-md border-0 py-4 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-accent-500 sm:text-lg sm:leading-6 transition-all" 
                               placeholder="Contoh: BKG-20251028-001" required>
                    </div>
                </div>

                <button type="submit" class="flex w-full justify-center rounded-md bg-accent-500 px-3 py-4 text-base font-bold leading-6 text-white shadow-sm hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500 transition-all duration-300 transform hover:-translate-y-0.5">
                    LACAK STATUS SAYA SEKARANG
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Lupa nomor booking Anda? 
                    <a href="{{ route('lacak.showLupaForm') }}" class="font-semibold text-primary-600 hover:text-primary-500 hover:underline transition-colors">
                        Cari menggunakan NIK di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< PANDUAN SINGKAT (3 LANGKAH) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-gray-50 pt-32 pb-24"> {{-- pt-32 untuk memberi ruang bagi kartu floating --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Bagaimana Cara Kerjanya?</h2>
            </div>
            <div class="mx-auto mt-12 grid max-w-lg grid-cols-1 gap-8 sm:max-w-none sm:grid-cols-3">
                
                {{-- Langkah 1 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold leading-7 text-gray-900">1. Daftar & Dapat Nomor</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Lakukan booking online dan simpan Nomor Booking yang Anda dapatkan.</p>
                </div>

                {{-- Langkah 2 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold leading-7 text-gray-900">2. Serahkan Berkas</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Datang ke kelurahan dan serahkan berkas fisik untuk diverifikasi oleh petugas.</p>
                </div>

                {{-- Langkah 3 --}}
                <div class="flex flex-col items-center text-center">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary-100">
                        <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold leading-7 text-gray-900">3. Pantau & Selesai</h3>
                    <p class="mt-1 text-sm leading-6 text-gray-600">Pantau status di sini. Jika sudah "Selesai", dokumen Anda siap diambil.</p>
                </div>

            </div>
        </div>
    </div>
</x-public-layout>