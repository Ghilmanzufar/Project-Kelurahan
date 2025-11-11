<x-public-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Semua Layanan Pertanahan Kelurahan Klender
                </h1>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Pahami alur dan syarat setiap layanan sebelum Anda membuat janji temu.
                </p>
            </div>

            <div class="mt-10 max-w-xl mx-auto">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text"
                           class="block w-full rounded-md border-gray-300 py-3 pl-10 pr-3 text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           placeholder="Cari layanan... (contoh: 'jual beli', 'waris', 'SKT')">
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h2 class="text-center text-2xl font-bold tracking-tight text-gray-900 mb-12">
                Daftar Layanan
            </h2>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">

                @forelse ($layanan as $item)
                    <div class="flex flex-col justify-between rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-900/5">
                        <div>
                            <h3 class="text-lg font-semibold leading-7 text-gray-900">
                                {{ $item->nama_layanan }}
                            </h3>
                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                {{ Str::limit($item->deskripsi, 100) }}
                            </p>
                        </div>
                        <a href="{{ route('layanan.show', $item) }}"
                           class="mt-6 block rounded-md bg-white px-3.5 py-2.5 text-center text-sm font-semibold text-blue-600 shadow-sm ring-1 ring-inset ring-blue-600 transition-all hover:bg-blue-50">
                            Pelajari Selengkapnya
                        </a>
                    </div>
                @empty
                    <p class="text-center text-gray-500 md:col-span-2 lg:col-span-3">
                        Saat ini belum ada layanan yang tersedia.
                    </p>
                @endforelse

            </div>
        </div>
    </div>

    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-2xl text-center px-6 lg:px-8">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Tidak Menemukan Layanan?
            </h2>
            <p class="mt-4 text-lg leading-8 text-gray-600">
                Tim kami siap membantu. Gunakan fitur Live Chat yang ada di pojok kanan bawah
                untuk bertanya langsung kepada petugas kami.
            </p>
            </div>
    </div>
</x-public-layout>