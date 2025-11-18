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
                <a href="/" class="-m-1.5 p-1.5">
                    <span class="sr-only">Kelurahan Klender</span>
                    <span class="text-lg font-bold text-white">KEL. KLENDER</span>
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
                <a href="#" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition duration-300">Bantuan & Chatbot</a>
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
                            <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white hover:bg-primary-800 transition duration-300">Bantuan & Chatbot</a>
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
                                <li><a href="#" class="text-sm leading-6 text-primary-200 hover:text-accent-300 transition duration-300">Bantuan</a></li>
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

    {{-- =============================================== --}}
    {{-- <<< TOMBOL CHAT (Menggunakan Warna Accent-500 / Emas) >>> --}}
    {{-- =============================================== --}}
    <button class="fixed bottom-4 right-4 bg-accent-500 text-white p-4 rounded-full shadow-lg z-50 transition-transform hover:scale-110 hover:bg-accent-600">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25a9.76 9.76 0 01-2.53-.388 1.875 1.875 0 01-1.025-.618C7.83 19.24 7.333 18.25 7 17.25m-3.998.908l-.622-1.42V8.25a.75.75 0 01.75-.75h13.5a.75.75 0 01.75.75v7.688a1.875 1.875 0 01-1.649 1.84l-6.331.84c-.377.05-.754.074-1.13.074H8.25a.75.75 0 01-.75-.75V8.25M3 16.812V8.25" />
        </svg>
    </button>
    
</div> 

{{-- Stack untuk Skrip kustom per halaman --}}
@stack('scripts')
</body>
</html>