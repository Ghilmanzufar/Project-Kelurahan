<x-public-layout>
    <div class="bg-gradient-to-br from-white via-gray-50 to-gray-100 py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-base font-semibold leading-7 text-accent-600">Booking Online</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-primary-900 sm:text-4xl">
                    Pilih Layanan untuk Memulai
                </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Silakan pilih jenis layanan yang ingin Anda urus. Anda akan langsung diarahkan ke pemilihan jadwal petugas.
                </p>
            </div>

            {{-- Grid Layanan --}}
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @forelse ($layanan as $item)
                    <article class="flex flex-col items-start justify-between rounded-2xl bg-white p-8 shadow-lg ring-1 ring-gray-200 transition-all hover:shadow-xl hover:ring-primary-500">
                        <div class="flex items-center gap-x-4 text-xs">
                            <span class="relative z-10 rounded-full bg-primary-50 px-3 py-1.5 font-medium text-primary-600">Layanan Aktif</span>
                        </div>
                        
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-primary-600">
                                <a href="{{ route('booking.step1', $item) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $item->nama_layanan }}
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                {{ $item->deskripsi }}
                            </p>
                        </div>

                        <div class="relative mt-8 flex items-center gap-x-4 w-full">
                            <a href="{{ route('booking.step1', $item) }}" 
                               class="w-full rounded-md bg-primary-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">
                                Pilih & Lanjut ke Jadwal &rarr;
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Belum ada layanan yang tersedia untuk booking saat ini.</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Link Balik --}}
            <div class="mt-16 text-center">
                 <a href="{{ route('layanan.index') }}" class="text-sm font-semibold leading-6 text-primary-600 hover:text-primary-500">
                    <span aria-hidden="true">&larr;</span> Kembali ke Daftar Informasi Layanan
                 </a>
            </div>

        </div>
    </div>
</x-public-layout>