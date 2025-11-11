<x-public-layout>
    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Pembaruan Terbaru dan Pengumuman Penting
                </h1>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Informasi resmi, kebijakan, dan jadwal penting terkait layanan pertanahan dan kelurahan.
                </p>
            </div>

            <form action="{{ route('pengumuman.index') }}" method="GET" class="mt-10 max-w-xl mx-auto">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" name="search" id="search"
                           class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-3 text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="Cari judul atau kata kunci pengumuman..." value="{{ $query ?? '' }}">
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl space-y-12">
                
                @forelse ($pengumuman as $item)
                    <article class="flex flex-col items-start justify-between sm:flex-row sm:gap-8">
                        <div class="relative w-full sm:w-64 flex-shrink-0">
                            <div class="aspect-[16/9] w-full rounded-2xl bg-gray-200 object-cover sm:aspect-[1/1] lg:aspect-[4/3]">
                                </div>
                        </div>
                        <div class="max-w-xl flex-grow">
                            <div class="mt-4 sm:mt-0 flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $item->tanggal_publikasi }}" class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->translatedFormat('d F Y') }}
                                </time>
                                <span class="relative z-10 rounded-full bg-blue-50 px-3 py-1.5 font-medium text-blue-700">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="{{ route('pengumuman.show', $item) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $item->judul }}
                                    </a>
                                </h3>
                                <p class="mt-5 text-sm leading-6 text-gray-600">
                                    {{ Str::limit(strip_tags($item->isi_konten), 200) }}
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('pengumuman.show', $item) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center bg-gray-50 p-8 rounded-lg">
                        <h3 class="text-2xl font-bold text-gray-900">Tidak Ada Hasil Ditemukan</h3>
                        <p class="mt-4 text-gray-600">
                            @if ($query)
                                Kami tidak dapat menemukan pengumuman yang cocok dengan kata kunci "{{ $query }}".
                            @else
                                Saat ini belum ada pengumuman yang dipublikasikan.
                            @endif
                        </p>
                        <a href="{{ route('pengumuman.index') }}" class="mt-6 inline-block text-sm font-semibold text-blue-600 hover:text-blue-500">
                            Lihat Semua Pengumuman
                        </a>
                    </div>
                @endforelse

                <div class="mt-16">
                    {{ $pengumuman->appends(['search' => $query])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-public-layout>