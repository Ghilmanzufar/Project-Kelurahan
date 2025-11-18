<x-public-layout>
    
    {{-- =============================================== --}}
    {{-- <<< HEADER BERITA (HIJAU TUA) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 py-16 sm:py-24 overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute inset-0 overflow-hidden">
             <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-primary-700 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>

        <div class="relative mx-auto max-w-3xl px-6 lg:px-8 text-center">
            {{-- Breadcrumbs Mini --}}
            <div class="flex justify-center items-center gap-x-2 text-sm text-primary-200 mb-6">
                <a href="{{ route('pengumuman.index') }}" class="hover:text-white transition-colors">Berita</a>
                <svg viewBox="0 0 2 2" width="3" height="3" aria-hidden="true" class="fill-current"><circle cx="1" cy="1" r="1" /></svg>
                <span>{{ $pengumuman->kategori }}</span>
            </div>

            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-5xl leading-tight">
                {{ $pengumuman->judul }}
            </h1>
            
            <div class="mt-6 flex items-center justify-center gap-x-4 text-sm text-primary-200">
                <div class="flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <time datetime="{{ $pengumuman->tanggal_publikasi->toDateString() }}">
                        {{ $pengumuman->tanggal_publikasi->translatedFormat('d F Y') }}
                    </time>
                </div>
                <svg viewBox="0 0 2 2" width="3" height="3" aria-hidden="true" class="fill-current"><circle cx="1" cy="1" r="1" /></svg>
                <div class="flex items-center gap-x-2">
                    <svg class="h-5 w-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Admin Kelurahan</span>
                </div>
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< KONTEN BERITA >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            
            {{-- Gambar Utama (Featured Image) --}}
            @if($pengumuman->featured_image)
                <div class="mb-10 rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-900/5">
                    <img src="{{ Storage::url($pengumuman->featured_image) }}" 
                         alt="{{ $pengumuman->judul }}" 
                         class="w-full object-cover h-auto max-h-[500px]">
                </div>
            @endif

            {{-- Isi Konten (Rich Text) --}}
            {{-- Class 'prose' dari Tailwind Typography plugin akan otomatis mempercantik HTML dari Trix --}}
            <article class="prose prose-lg prose-green mx-auto text-gray-600">
                {!! $pengumuman->isi_konten !!}
            </article>

            {{-- Tombol Download PDF (Jika Ada) --}}
            @if($pengumuman->file_pdf_path)
                <div class="mt-12 p-6 bg-primary-50 rounded-xl border border-primary-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-red-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Dokumen Lampiran</h4>
                            <p class="text-xs text-gray-500">Unduh dokumen resmi terkait pengumuman ini.</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($pengumuman->file_pdf_path) }}" target="_blank"
                       class="inline-flex items-center rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-primary-700 shadow-sm ring-1 ring-inset ring-primary-300 hover:bg-primary-50 transition-colors">
                        <svg class="h-5 w-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download PDF
                    </a>
                </div>
            @endif

            {{-- Tombol Share / Kembali --}}
            <div class="mt-16 border-t border-gray-200 pt-8 flex justify-between items-center">
                <a href="{{ route('pengumuman.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                    &larr; Kembali ke Daftar Berita
                </a>
                {{-- (Opsional) Tombol Share Media Sosial bisa ditambahkan di sini --}}
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< BERITA TERKAIT (3 TERBARU) >>> --}}
    {{-- =============================================== --}}
    @if(isset($beritaTerkait) && $beritaTerkait->count() > 0)
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center mb-12">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Berita Lainnya</h2>
            </div>
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-12 border-t border-gray-200 pt-12 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($beritaTerkait as $item)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            @if($item->featured_image)
                                <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->judul }}" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            @else
                                <div class="aspect-[16/9] w-full rounded-2xl bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 14m6-6l.01.01" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="max-w-xl">
                            <div class="mt-6 flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $item->tanggal_publikasi->toDateString() }}" class="text-gray-500">
                                    {{ $item->tanggal_publikasi->translatedFormat('d M Y') }}
                                </time>
                                <span class="relative z-10 rounded-full bg-primary-50 px-3 py-1.5 font-medium text-primary-700">{{ $item->kategori }}</span>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-primary-600">
                                    <a href="{{ route('pengumuman.show', $item->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $item->judul }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</x-public-layout>