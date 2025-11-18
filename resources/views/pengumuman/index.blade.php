<x-public-layout>
    
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION (HIJAU TUA + SEARCH) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 py-24 sm:py-32 overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
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
                Berita & Pengumuman
            </h1>
            <p class="mt-6 text-lg leading-8 text-primary-100 max-w-2xl mx-auto">
                Dapatkan informasi terkini seputar layanan, kegiatan, dan kebijakan terbaru dari Kelurahan Klender.
            </p>

            {{-- Search Bar --}}
            <div class="mt-10 max-w-xl mx-auto">
                <form action="{{ route('pengumuman.index') }}" method="GET" class="relative">
                    <label for="search" class="sr-only">Cari pengumuman</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" 
                               value="{{ request('search') }}"
                               class="block w-full rounded-full border-0 py-4 pl-12 pr-32 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-accent-500 sm:text-sm sm:leading-6" 
                               placeholder="Cari judul atau topik...">
                        <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                            <button type="submit" class="inline-flex items-center rounded-full bg-accent-500 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-accent-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500 transition-colors">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< DAFTAR BERITA (GRID) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            @if(request('search'))
                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Hasil Pencarian: "{{ request('search') }}"</h2>
                    <a href="{{ route('pengumuman.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 mt-2 inline-block">
                        &larr; Reset pencarian
                    </a>
                </div>
            @endif

            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-4 sm:pt-4 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                
                @forelse ($pengumuman as $item)
                    <article class="flex max-w-xl flex-col items-start justify-between group">
                        {{-- Gambar Thumbnail --}}
                        <div class="relative w-full">
                            @if($item->featured_image)
                                <img src="{{ Storage::url($item->featured_image) }}" 
                                     alt="{{ $item->judul }}" 
                                     class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2] transition duration-300 group-hover:opacity-90 group-hover:shadow-lg">
                            @else
                                <div class="aspect-[16/9] w-full rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 sm:aspect-[2/1] lg:aspect-[3/2]">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>

                        <div class="flex items-center gap-x-4 text-xs mt-8">
                            {{-- Tanggal --}}
                            <time datetime="{{ $item->tanggal_publikasi->toDateString() }}" class="text-gray-500">
                                {{ $item->tanggal_publikasi->translatedFormat('d F Y') }}
                            </time>
                            {{-- Kategori Badge --}}
                            <span class="relative z-10 rounded-full bg-primary-50 px-3 py-1.5 font-medium text-primary-700 hover:bg-primary-100 transition-colors">
                                {{ $item->kategori }}
                            </span>
                        </div>

                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-primary-600 transition-colors">
                                <a href="{{ route('pengumuman.show', $item->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $item->judul }}
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                {{ Str::limit(strip_tags($item->isi_konten), 120) }}
                            </p>
                        </div>
                        
                        {{-- Footer Card (User & Read More) --}}
                        <div class="relative mt-8 flex items-center gap-x-4 w-full">
                            <div class="text-sm leading-6">
                                <p class="font-semibold text-gray-900">
                                    <span class="absolute inset-0"></span>
                                    Tim Kelurahan
                                </p>
                                <p class="text-gray-600">Admin</p>
                            </div>
                            
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Tidak ada berita ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">Coba cari dengan kata kunci lain.</p>
                        <div class="mt-6">
                            <a href="{{ route('pengumuman.index') }}" class="rounded-md bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600">
                                Lihat Semua Berita
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $pengumuman->links() }} {{-- Pastikan layout pagination sudah menggunakan Tailwind --}}
            </div>

        </div>
    </div>
</x-public-layout>