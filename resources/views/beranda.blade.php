<x-public-layout>
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION BARU (DENGAN GAMBAR) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                {{-- Tambahan untuk SVG Shape di kanan --}}
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                    fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
                    {{-- Navigasi Anda akan muncul di sini dari layout --}}
                </div>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl md:text-5xl">
                            <span class="block xl:inline">Sistem Informasi Pelayanan</span>
                            {{-- AKSEN WARNA BARU --}}
                            <span class="block text-primary-700 xl:inline">Pertanahan Kelurahan Klender</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-600 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            "Mudahkan Urusan Tanah Anda."
                            <br>
                            Pahami alurnya, lengkapi syaratnya, dan buat janji temu. Pelayanan lebih cepat dan pasti.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('layanan.index') }}"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 transition duration-300 md:py-4 md:text-lg md:px-10">
                                    Lihat Semua Layanan
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ route('lacak.index') }}"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md ext-primary-700 bg-primary-50 hover:bg-primary-100 transition duration-300 md:py-4 md:text-lg md:px-10">
                                    Lacak Pengajuan
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full"
                src="{{ asset('images/Kelurahan_Klender_2020.jpg') }}"
                alt="Kantor Kelurahan Klender">
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< LAYANAN POPULER (DENGAN AKSEN PINK) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900 mb-12">
                Layanan Pertanahan Paling Sering Diajukan
            </h2>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                
                @forelse ($layananPopuler as $layanan)
                    {{-- PERUBAHAN: bg-gray-50 -> bg-white, hover:shadow-xl, hover:-translate-y-1 --}}
                    <div class="flex flex-col justify-between rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div>
                            {{-- PERUBAHAN: text-blue-600 -> text-primary-700 (Aksen Pink) --}}
                            <div class="text-primary-700 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold leading-7 text-gray-900">
                                {{ $layanan->nama_layanan }}
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                {{ Str::limit($layanan->deskripsi, 60) }} </p>
                        </div>
                        {{-- PERUBAHAN: bg-primary-600 -> bg-accent-500 (Aksen Pink) --}}
                        <a href="{{ route('layanan.show', $layanan) }}"
                           class="mt-6 block rounded-md bg-accent-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition-all hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600">
                            Pelajari dan Booking
                        </a>
                    </div>
                @empty
                    <p class="text-center text-gray-500 md:col-span-3">
                        Layanan populer akan segera ditampilkan di sini.
                    </p>
                @endforelse

            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< MENGAPA MENGGUNAKAN KAMI (AKSEN PINK) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Mengapa Menggunakan Sistem Pelayanan Online Kami?
                </h2>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                {{-- PERUBAHAN: Tambah hover effect --}}
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                    {{-- PERUBAHAN: text-blue-600 -> text-primary-700 (Aksen Pink) --}}
                    <div class="text-primary-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">Informasi Akurat</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Pahami setiap syarat dan alur layanan sebelum datang ke kelurahan.</p>
                </div>
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">Tanpa Antre Panjang</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Buat janji temu dengan petugas pilihan Anda dari rumah.</p>
                </div>
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25C6.477 2.25 2 6.727 2 12s4.477 9.75 10 9.75 10-4.477 10-10S17.523 2.25 12 2.25z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">Status Transparan</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Lacak progres pengajuan Anda kapan saja, 24/7, secara online.</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- =============================================== --}}
    {{-- <<< BAGAIMANA CARA MEMULAI (AKSEN PINK) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Bagaimana Cara Memulai Layanan?
                </h2>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                {{-- 1. PILIH & PELAJARI --}}
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-600 mb-4">
                        {{-- <<< IKON BARU: PENCARIAN DOKUMEN >>> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">1. Pilih & Pelajari</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Pilih jenis layanan yang Anda butuhkan dan pahami semua syaratnya.</p>
                </div>

                {{-- 2. BUAT JANJI TEMU --}}
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-600 mb-4">
                        {{-- <<< IKON BARU: KALENDER >>> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5-2.25v2.25m-10.5 0L6.75 7.5h10.5l-.375-2.25M19.5 10.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-7.5a.75.75 0 01.75-.75h15z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25h-15a.75.75 0 00-.75.75v12a.75.75 0 00.75.75h15a.75.75 0 00.75-.75v-12a.75.75 0 00-.75-.75z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">2. Buat Janji Temu</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Isi formulir singkat, pilih petugas, dan tentukan jadwal Anda.</p>
                </div>

                {{-- 3. LACAK BERKAS --}}
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1">
                    <div class="text-primary-600 mb-4">
                        {{-- <<< IKON BARU: KOMPAS (SAMA SEPERTI DI ATAS) >>> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25C6.477 2.25 2 6.727 2 12s4.477 9.75 10 9.75 10-4.477 10-10S17.523 2.25 12 2.25z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">3. Lacak Berkas</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Gunakan nomor booking Anda untuk memantau progres berkas secara real-time.</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- =============================================== --}}
    {{-- <<< PENGUMUMAN (AKSEN PINK) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Pembaruan Terbaru dan Pengumuman Penting
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Informasi resmi, kebijakan, dan jadwal penting terkait layanan pertanahan.
                </p>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($pengumumanTerbaru as $pengumuman)
                    {{-- PERUBAHAN: Tambah hover effect --}}
                    <article class="flex flex-col items-start justify-between rounded-2xl p-6 ring-1 ring-gray-900/5 shadow-sm transition duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="relative w-full">
                            {{-- Tampilkan gambar jika ada, jika tidak, tampilkan placeholder --}}
                            @if($pengumuman->featured_image)
                                <img src="{{ Storage::url($pengumuman->featured_image) }}" alt="Gambar Pengumuman" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            @else
                                <div class="aspect-[16/9] w-full rounded-2xl bg-gray-100 flex items-center justify-center sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $pengumuman->tanggal_publikasi }}" class="text-gray-500">
                                    {{ $pengumuman->tanggal_publikasi->translatedFormat('d F Y') }}
                                </time>
                                {{-- PERUBAHAN: bg-blue-50 -> bg-pink-50 (Aksen Pink) --}}
                                <span class="relative z-10 rounded-full bg-primary-50 px-3 py-1.5 font-medium text-primary-700">
                                    {{ $pengumuman->kategori }}
                                </span>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    {{-- PERUBAHAN: Link sekarang mengarah ke detail pengumuman --}}
                                    <a href="{{ route('pengumuman.show', $pengumuman->slug) }}"> 
                                        <span class="absolute inset-0"></span>
                                        {{ $pengumuman->judul }}
                                    </a>
                                </h3>
                                <p class="mt-5 text-sm leading-6 text-gray-600">
                                    {{ Str::limit(strip_tags($pengumuman->isi_konten), 150) }}
                                </p>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-center text-gray-500 md:col-span-3">
                        Belum ada pengumuman terbaru.
                    </p>
                @endforelse
                
            </div>
        </div>
    </div>
</x-public-layout>