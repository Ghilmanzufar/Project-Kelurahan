<x-public-layout>
    <div class="bg-white px-6 py-16 sm:py-24 lg:px-8">
        <div class="mx-auto max-w-3xl">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2">
                    <li><a href="{{ route('beranda') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Beranda</a></li>
                    <li>
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li><a href="{{ route('pengumuman.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Pengumuman</a></li>
                </ol>
            </nav>

            <div class="flex items-center gap-x-4 text-sm">
                <time datetime="{{ $pengumuman->tanggal_publikasi }}" class="text-gray-500">
                    {{ \Carbon\Carbon::parse($pengumuman->tanggal_publikasi)->translatedFormat('d F Y') }}
                </time>
                <span class="relative z-10 rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-700">
                    {{ $pengumuman->kategori }}
                </span>
            </div>
            
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                {{ $pengumuman->judul }}
            </h1>

            <div class="mt-8 aspect-[16/9] w-full rounded-2xl bg-gray-200 object-cover">
                </div>

            <div class="mt-10 max-w-2xl mx-auto">
                <div class="prose prose-lg prose-indigo max-w-none">
                    {!! $pengumuman->isi_konten !!}
                </div>
            </div>

            @if ($pengumuman->file_pdf_path)
                <div class="mt-12 text-center">
                    <a href="{{ Storage::url($pengumuman->file_pdf_path) }}" target="_blank"
                       class="inline-flex items-center gap-x-2 rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.7a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z" clip-rule="evenodd" />
                        </svg>
                        Link Download: Unduh Dokumen Resmi (PDF)
                    </a>
                </div>
            @endif

            <div class="mt-16 border-t border-gray-200 pt-8 text-center">
                <a href="{{ route('pengumuman.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500">
                    &larr; Kembali ke Daftar Pengumuman
                </a>
            </div>
        </div>
    </div>
</x-public-layout>