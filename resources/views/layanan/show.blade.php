<x-public-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-3xl px-6 lg:px-8 space-y-16">

            <div class="text-center">
                <nav class="text-sm font-medium text-gray-500">
                    <a href="{{ route('layanan.index') }}" class="hover:text-gray-700">Beranda</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('layanan.index') }}" class="hover:text-gray-700">Jenis Layanan</a>
                </nav>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Layanan: {{ $layanan->nama_layanan }}
                </h1>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    {{ $layanan->deskripsi }}
                </p>
            </div>

            <div>
                <h2 class="text-center text-2xl font-semibold leading-7 text-gray-900">Infomasi</h2>
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="text-center rounded-2xl bg-gray-50 p-6 ring-1 ring-gray-900/5">
                        <svg class="mx-auto h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-base font-semibold text-gray-900">Estimasi Proses</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $layanan->estimasi_proses }}</p>
                    </div>
                    <div class="text-center rounded-2xl bg-gray-50 p-6 ring-1 ring-gray-900/5">
                        <svg class="mx-auto h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6A.75.75 0 012.25 5.25v-.75m0 0A.75.75 0 013 4.5A.75.75 0 013.75 3.75m0 0A.75.75 0 013 3A.75.75 0 012.25 3.75m0 0A.75.75 0 011.5 4.5A.75.75 0 012.25 5.25m0 0A.75.75 0 013 6A.75.75 0 013.75 5.25M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-2.12 0l-2.12 2.12A1.5 1.5 0 005.25 6v10.5a1.5 1.5 0 001.5 1.5h10.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-.44-1.06z" />
                        </svg>
                        <h3 class="mt-2 text-base font-semibold text-gray-900">Biaya Layanan</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $layanan->biaya }}</p>
                    </div>
                    <div class="text-center rounded-2xl bg-gray-50 p-6 ring-1 ring-gray-900/5">
                        <svg class="mx-auto h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                        <h3 class="mt-2 text-base font-semibold text-gray-900">Dasar Hukum</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $layanan->dasar_hukum }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-semibold leading-7 text-gray-900">
                    Dokumen yang WAJIB Dibawa Saat Janji Temu
                </h2>
                <p class="mt-2 text-base leading-7 text-gray-600">(Berkas Fisik Asli & Fotokopi)</p>

                <ul role="list" class="mt-8 space-y-4 text-gray-600">
                    @forelse ($layanan->dokumenWajib as $dokumen)
                        <li class="flex gap-x-3">
                            <svg class="mt-1 h-5 w-5 flex-none text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-base">{{ $dokumen->deskripsi_dokumen }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500">Belum ada daftar dokumen untuk layanan ini.</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h2 class="text-2xl font-semibold leading-7 text-gray-900">
                    Alur Proses Pengurusan Layanan Ini
                </h2>
                <ol role="list" class="mt-8 space-y-4 text-gray-600 list-decimal list-inside">
                    @forelse ($layanan->alurProses as $alur)
                        <li class="text-base">{{ $alur->deskripsi_alur }}</li>
                    @empty
                        <li class="text-gray-500 list-none">Belum ada alur proses untuk layanan ini.</li>
                    @endforelse
                </ol>
            </div>

            <div class="text-center border-t border-gray-200 pt-16">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    Sudah Membaca dan Menyiapkan Semua Dokumen?
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Pastikan semua dokumen lengkap untuk menghindari penolakan berkas.
                </p>
                <a href="#" 
                   class="mt-8 inline-block rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    SAYA SUDAH PAHAM & SIAPKAN BERKAS, BUAT JANJI TEMU
                </a>
            </div>

        </div>
    </div>
</x-public-layout>