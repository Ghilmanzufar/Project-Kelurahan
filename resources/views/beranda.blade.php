<x-public-layout>
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl py-16 px-6 sm:py-24 lg:px-8">
            <div class="text-center">
                <div class="inline-block bg-gray-200 px-6 py-4 rounded-lg">
                    <h1 class="text-lg font-semibold tracking-tight text-gray-700 sm:text-xl">
                        SISTEM INFORMASI PELAYANAN PERTANAHAN KELURAHAN KLENDER
                    </h1>
                </div>
                
                <p class="mt-8 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                    "Mudahkan Urusan Tanah Anda."
                </p>
                <p class="mt-4 mx-auto max-w-2xl text-lg text-gray-600">
                    Pahami alurnya, lengkapi syaratnya, dan buat janji temu. Pelayanan lebih cepat dan pasti.
                </p>
                
                <div class="mt-10">
                    <a href="{{ route('layanan.index') }}"
                       class="rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        LIHAT SEMUA LAYANAN & DAFTAR SEKARANG
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h2 class="text-center text-2xl font-bold tracking-tight text-gray-900 mb-12">
                Layanan Pertanahan Paling Sering Diajukan
            </h2>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                
                @forelse ($layananPopuler as $layanan)
                    <div class="flex flex-col justify-between rounded-2xl bg-gray-50 p-8 shadow-sm ring-1 ring-gray-200">
                        <div>
                            <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
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
                        <a href="{{ route('layanan.show', $layanan) }}"
                           class="mt-6 block rounded-md bg-blue-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition-all hover:bg-blue-700">
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

    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Mengapa Menggunakan Sistem Pelayanan Online Kami?
                </h2>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5"> {{-- Warna Putih --}}
                    <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">Informasi Akurat</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Pahami setiap syarat dan alur layanan sebelum datang ke kelurahan.</p>
                </div>
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5"> {{-- Warna Putih --}}
                    <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">Tanpa Antre Panjang</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Buat janji temu dengan petugas pilihan Anda dari rumah.</p>
                </div>
                <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5"> {{-- Warna Putih --}}
                    <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122l-1.577 1.577a.75.75 0 01-1.06-.06L2.25 19.5m11.5-11.25h-9M18 7.5h-9m3 4.5h-9m-3 0V8.25m15.75 9.75H12V16.5a3 3 0 00-3-3H6m3-6h.008v.008H9v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">Status Transparan</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Lacak progres pengajuan Anda kapan saja, 24/7, secara online.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Bagaimana Cara Memulai Layanan?
                </h2>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="rounded-2xl bg-gray-50 p-8 shadow-sm ring-1 ring-gray-200">
                    <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m-4.5-6H5.25c-.621 0-1.125-.504-1.125-1.125V11.25c0-1.066.849-1.895 1.914-1.125l11.334 7.556a4.5 4.5 0 01-.122 6.551L9 18z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">1. Pilih & Pelajari</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Pilih jenis layanan yang Anda butuhkan dan pahami semua syaratnya.</p>
                </div>
                <div class="rounded-2xl bg-gray-50 p-8 shadow-sm ring-1 ring-gray-200">
                    <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m-3.75 9V1.5M19.5 9.75v-2.25m-3.75 9V1.5m-3 9L9.75 3v11.25m6-4.5l-2.25 2.25L9.75 9.75m-3 0V3M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">2. Buat Janji Temu</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Isi formulir singkat, pilih petugas, dan tentukan jadwal Anda.</p>
                </div>
                <div class="rounded-2xl bg-gray-50 p-8 shadow-sm ring-1 ring-gray-200">
                    <div class="text-blue-600 mb-4"> {{-- Icon warna biru --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122l-1.577 1.577a.75.75 0 01-1.06-.06L2.25 19.5m11.5-11.25h-9M18 7.5h-9m3 4.5h-9m-3 0V8.25m15.75 9.75H12V16.5a3 3 0 00-3-3H6m3-6h.008v.008H9v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold leading-7 text-gray-900">3. Lacak Berkas</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">Gunakan nomor booking Anda untuk memantau progres berkas secara real-time.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Pembaruan Terbaru dan Pengumuman Penting
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Informasi resmi, kebijakan, dan jadwal penting terkait layanan pertanahan.
                </p>
            </div>
            
            <div class="mt-16 grid grid-cols-1 gap-12 md:grid-cols-2">

                @forelse ($pengumumanTerbaru as $pengumuman)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <div class="aspect-[16/9] w-full rounded-2xl bg-gray-200 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                {{-- Placeholder for image --}}
                            </div>
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $pengumuman->tanggal_publikasi }}" class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y') }}
                                </time>
                                <span class="relative z-10 rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-700"> {{-- Warna biru --}}
                                    {{ $pengumuman->kategori }}
                                </span>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="#"> <span class="absolute inset-0"></span>
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
                    <p class="text-center text-gray-500 md:col-span-2">
                        Belum ada pengumuman terbaru.
                    </p>
                @endforelse
                
            </div> </div>
    </div>
</x-public-layout>