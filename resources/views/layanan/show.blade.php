<x-public-layout>
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION (JUDUL LAYANAN) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 py-16 sm:py-24 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            {{-- Pola dekoratif latar belakang --}}
            <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-primary-700 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <div class="flex items-center gap-x-3">
                    <a href="{{ route('layanan.index') }}" class="text-primary-200 hover:text-white transition-colors">
                        &larr; Kembali
                    </a>
                    <span class="h-1 w-1 rounded-full bg-primary-500"></span>
                    <span class="text-primary-200">Detail Layanan</span>
                </div>
                <h1 class="mt-6 text-4xl font-bold tracking-tight text-white sm:text-5xl">
                    {{ $layanan->nama_layanan }}
                </h1>
                <p class="mt-6 text-lg leading-8 text-primary-100">
                    {{ $layanan->deskripsi }}
                </p>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< KONTEN UTAMA >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                
                {{-- KOLOM KIRI (INFORMASI UTAMA) --}}
                <div class="lg:col-span-2 lg:pr-8">
                    
                    {{-- 1. Dokumen Wajib --}}
                    <div class="mb-16">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-white text-sm font-bold">1</span>
                            Dokumen Persyaratan
                        </h2>
                        <p class="mt-2 text-base leading-7 text-gray-600 mb-6">
                            Pastikan Anda membawa dokumen fisik <strong>Asli & Fotokopi</strong> berikut ini saat datang ke kelurahan.
                        </p>
                        <ul role="list" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @forelse ($layanan->dokumenWajib as $dokumen)
                                <li class="flex gap-x-3 rounded-lg bg-gray-50 p-4 ring-1 ring-gray-200">
                                    <svg class="h-6 w-6 flex-none text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm leading-6 text-gray-700">{{ $dokumen->deskripsi_dokumen }}</span>
                                </li>
                            @empty
                                <li class="text-gray-500 italic col-span-full">Belum ada daftar dokumen untuk layanan ini.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- 2. Alur Proses --}}
                    <div>
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 flex items-center gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-white text-sm font-bold">2</span>
                            Alur Pengurusan
                        </h2>
                        <div class="mt-6 space-y-8 border-l-2 border-primary-100 pl-6 ml-4">
                            @forelse ($layanan->alurProses as $index => $alur)
                                <div class="relative">
                                    <span class="absolute -left-[2.45rem] top-0 flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 ring-4 ring-white">
                                        <span class="text-xs font-bold text-primary-700">{{ $index + 1 }}</span>
                                    </span>
                                    <p class="text-base leading-7 text-gray-700 font-medium">{{ $alur->deskripsi_alur }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada alur proses untuk layanan ini.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN (RINGKASAN & CTA - STICKY) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 rounded-2xl bg-gray-50 p-8 ring-1 ring-gray-200 shadow-lg">
                        <h3 class="text-lg font-bold leading-7 text-gray-900 mb-6">Ringkasan Layanan</h3>
                        
                        <dl class="space-y-6 divide-y divide-gray-200">
                            {{-- Estimasi --}}
                            <div class="pt-6 first:pt-0">
                                <dt class="font-medium text-gray-900 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Estimasi Proses
                                </dt>
                                <dd class="mt-2 text-sm text-gray-600 pl-7">{{ $layanan->estimasi_proses }}</dd>
                            </div>

                            {{-- Biaya --}}
                            <div class="pt-6">
                                <dt class="font-medium text-gray-900 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6A.75.75 0 012.25 5.25v-.75m0 0A.75.75 0 013 4.5A.75.75 0 013.75 3.75m0 0A.75.75 0 013 3A.75.75 0 012.25 3.75m0 0A.75.75 0 011.5 4.5A.75.75 0 012.25 5.25m0 0A.75.75 0 013 6A.75.75 0 013.75 5.25M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-2.12 0l-2.12 2.12A1.5 1.5 0 005.25 6v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-.44-1.06z" />
                                    </svg>
                                    Biaya
                                </dt>
                                <dd class="mt-2 text-sm text-gray-600 pl-7">{{ $layanan->biaya }}</dd>
                            </div>

                            {{-- Dasar Hukum --}}
                            <div class="pt-6">
                                <dt class="font-medium text-gray-900 flex items-center gap-2">
                                    <svg class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    Dasar Hukum
                                </dt>
                                <dd class="mt-2 text-sm text-gray-600 pl-7">{{ $layanan->dasar_hukum }}</dd>
                            </div>
                        </dl>

                        {{-- TOMBOL CTA UTAMA --}}
                        <div class="mt-10 border-t border-gray-200 pt-6">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2">Siap Mengajukan?</h4>
                            <p class="text-xs text-gray-500 mb-4">Pastikan semua syarat sudah lengkap sebelum membuat janji.</p>
                            
                            {{-- Gunakan route() untuk menuju halaman booking --}}
                            <a href="{{ route('booking.step1', $layanan) }}" 
                               class="block w-full rounded-md bg-accent-500 px-3.5 py-3 text-center text-sm font-bold text-white shadow-sm hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500 transition-colors duration-300">
                                BUAT JANJI TEMU SEKARANG
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>