<x-public-layout>
    
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION (GAMBAR + SEARCH BAR) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 py-24 sm:py-32 overflow-hidden">
        {{-- Gambar Latar Belakang (Gunakan gambar yang sama dengan beranda atau beda) --}}
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                 alt="Latar Belakang Layanan" 
                 class="h-full w-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-b from-primary-900/80 via-primary-900/80 to-primary-900"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                Layanan Pertanahan
            </h1>
            <p class="mt-6 text-lg leading-8 text-primary-100 max-w-2xl mx-auto">
                Temukan informasi lengkap mengenai syarat, alur, dan biaya untuk setiap jenis layanan pertanahan di Kelurahan Klender.
            </p>

            {{-- Search Bar Besar --}}
            <div class="mt-10 max-w-xl mx-auto">
                <form action="{{ route('layanan.index') }}" method="GET" class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           class="block w-full rounded-full border-0 py-4 pl-12 pr-4 text-gray-900 shadow-xl ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-accent-500 sm:text-lg"
                           placeholder="Cari layanan... (misal: 'waris', 'jual beli')">
                    <button type="submit" class="absolute right-2 top-2 bottom-2 rounded-full bg-accent-500 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500 transition-all duration-300">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< DAFTAR LAYANAN (GRID KARTU) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            @if(request('search'))
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Hasil pencarian untuk "{{ request('search') }}"
                    </h2>
                    <a href="{{ route('layanan.index') }}" class="text-primary-600 hover:text-primary-800 text-sm mt-2 inline-block">
                        &larr; Kembali ke semua layanan
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($layanan as $item)
                    {{-- Kartu Layanan --}}
                    <article class="flex flex-col justify-between rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-2 hover:ring-primary-100">
                        <div>
                            <div class="flex items-center gap-x-4 text-xs">
                                <span class="relative z-10 rounded-full bg-primary-50 px-3 py-1.5 font-medium text-primary-700">Layanan Publik</span>
                                @if($item->estimasi_proses)
                                    <span class="text-gray-500 flex items-center">
                                        <svg class="mr-1.5 h-4 w-4 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $item->estimasi_proses }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="mt-4 text-xl font-bold leading-7 text-gray-900 group-hover:text-primary-600">
                                <a href="{{ route('layanan.show', $item->slug ?? $item->id) }}"> {{-- Gunakan slug jika ada, atau ID --}}
                                    {{ $item->nama_layanan }}
                                </a>
                            </h3>
                            
                            <p class="mt-4 text-base leading-7 text-gray-600 line-clamp-3">
                                {{ Str::limit($item->deskripsi, 120) }}
                            </p>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-100 pt-6">
                            <a href="{{ route('layanan.show', $item->slug ?? $item->id) }}"
                               class="flex items-center justify-center w-full rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-primary-600 shadow-sm ring-1 ring-inset ring-primary-200 hover:bg-primary-50 transition-colors duration-200">
                                Pelajari Selengkapnya
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak ada layanan ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba kata kunci pencarian lain atau hubungi petugas kami.</p>
                        <div class="mt-6">
                            <a href="{{ route('layanan.index') }}" class="inline-flex items-center rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                                Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< SECTION BANTUAN (CALL TO ACTION) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-16 px-6 sm:py-24 lg:px-8">
            <div class="relative isolate overflow-hidden bg-primary-900 px-6 py-24 text-center shadow-2xl sm:rounded-3xl sm:px-16">
                <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Tidak Menemukan Layanan yang Dicari?
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-primary-200">
                    Tim kami siap membantu Anda. Gunakan fitur Live Chat untuk bertanya langsung kepada petugas kami tentang prosedur yang belum jelas.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="#" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-primary-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors duration-200">
                        Mulai Chat Bantuan
                    </a>
                    <a href="{{ route('kontak') }}" class="text-sm font-semibold leading-6 text-white hover:text-accent-300 transition-colors duration-200">
                        Hubungi Kami <span aria-hidden="true">→</span>
                    </a>
                </div>
                {{-- Efek Dekorasi Lingkaran --}}
                <svg viewBox="0 0 1024 1024" class="absolute left-1/2 top-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]" aria-hidden="true">
                    <circle cx="512" cy="512" r="512" fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)" fill-opacity="0.7" />
                    <defs>
                        <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                            <stop stop-color="#10b981" /> {{-- Warna Hijau Terang --}}
                            <stop offset="1" stop-color="#064e3b" /> {{-- Warna Hijau Gelap --}}
                        </radialGradient>
                    </defs>
                </svg>
            </div>
        </div>
    </div>
</x-public-layout>