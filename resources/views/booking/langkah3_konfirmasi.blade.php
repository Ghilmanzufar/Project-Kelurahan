<x-public-layout>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-500 hover:text-gray-700 text-sm">Beranda</a></li>
                <li>
                    <span class="text-gray-500 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><span class="text-gray-500 text-sm">Buat Janji Temu</span></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Buat Janji Temu Pelayanan</h1>

        {{-- Step Indicator --}}
        <div class="mt-8 flex items-center space-x-4">
            <div class="flex items-center text-blue-600">
                <div class="h-8 w-8 flex items-center justify-center rounded-full border border-blue-600 font-bold text-sm mr-2">1</div>
                <span class="font-semibold">PILIH JADWAL</span>
            </div>
            <div class="flex-grow border-t border-blue-600"></div>
            <div class="flex items-center text-blue-600">
                <div class="h-8 w-8 flex items-center justify-center rounded-full border border-blue-600 font-bold text-sm mr-2">2</div>
                <span class="font-semibold">ISI DATA DIRI</span>
            </div>
            <div class="flex-grow border-t border-blue-600"></div> {{-- Garis aktif --}}
            <div class="flex items-center text-blue-600">
                <div class="h-8 w-8 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-sm mr-2">3</div>
                <span class="font-semibold">KONFIRMASI</span>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900">LANGKAH 3: KONFIRMASI JANJI TEMU ANDA</h2>
            <p class="mt-4 text-gray-700">Mohon periksa kembali semua data Anda sebelum konfirmasi.</p>

            {{-- Menampilkan Error Validasi (jika ada) --}}
            @if ($errors->any())
                <div class="mt-4 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat {{ $errors->count() }} kesalahan pada input Anda:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('booking.storeBooking') }}" method="POST" class="mt-8" x-data="{ agreed: false }">
                @csrf
                
                {{-- Detail Layanan & Jadwal (sesuai mockup image_057e10.png) --}}
                <div class="p-6 rounded-lg border border-gray-300 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Detail Layanan & Jadwal:</h3>
                        <a href="{{ route('booking.showStep1', $bookingData['layanan_id']) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Ubah Jadwal
                        </a>
                    </div>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Layanan:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $bookingData['layanan_nama'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Petugas:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $bookingData['petugas_nama'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Waktu:</span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($bookingData['tanggal_kunjungan'])->translatedFormat('l, d F Y') }}, 
                                Pukul {{ $bookingData['waktu_kunjungan'] ?? 'N/A' }} WIB
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Data Diri Pemohon (sesuai mockup image_057e10.png) --}}
                <div class="mt-8 p-6 rounded-lg border border-gray-300 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Data Diri Pemohon:</h3>
                        <a href="{{ route('booking.showStep2') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Ubah Data Diri
                        </a>
                    </div>
                    
                    <div class="mt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Nama:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $bookingData['nama_lengkap'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">NIK:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $bookingData['nik'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">No. HP:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $bookingData['nomor_hp'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Email:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $bookingData['email'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Checkbox Konfirmasi (sesuai mockup image_057e12.png) --}}
                <div class="mt-10 flex items-start">
                    <div class="flex h-6 items-center">
                        <input id="konfirmasi" name="konfirmasi" type="checkbox" x-model="agreed"
                               class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-600">
                    </div>
                    <div class="ml-3 text-sm leading-6">
                        <label for="konfirmasi" class="font-medium text-gray-900">
                            "Saya menyatakan data di atas benar dan saya bersedia membawa SEMUA berkas fisik (Asli & Fotokopi) sesuai daftar persyaratan saat datang ke kelurahan."
                        </label>
                    </div>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="mt-12 flex items-center justify-between border-t border-gray-200 pt-8">
                    <a href="{{ route('booking.showStep2') }}"
                       class="rounded-md bg-gray-700 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-600">
                        &larr; Kembali ke Data Diri
                    </a>
                    
                    <button type="submit"
                            :disabled="!agreed"
                            :class="{'opacity-50 cursor-not-allowed': !agreed}"
                            class="rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        KONFIRMASI & BUAT JANJI TEMU
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>