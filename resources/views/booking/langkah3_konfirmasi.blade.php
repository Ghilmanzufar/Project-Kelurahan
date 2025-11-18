<x-public-layout>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Beranda</a></li>
                <li>
                    <span class="text-gray-400 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Layanan</a></li>
                <li>
                    <span class="text-gray-400 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><span class="text-primary-700 font-medium text-sm">Buat Janji Temu</span></li>
            </ol>
        </nav>

        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-4xl sm:tracking-tight">
                    Konfirmasi Janji Temu
                </h2>
                <p class="mt-2 text-lg text-gray-600">Mohon periksa kembali semua data Anda sebelum melakukan konfirmasi akhir.</p>
            </div>
        </div>

        {{-- Stepper Indicator (Langkah 3 Aktif) --}}
        <div class="mt-10">
            <div class="flex items-center justify-center w-full">
                <div class="flex items-center w-full max-w-3xl">
                    {{-- Step 1: Selesai --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-primary-600 bg-primary-600 text-white flex items-center justify-center font-bold">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-primary-600">Jadwal Terpilih</div>
                    </div>
                    
                    {{-- Garis Penghubung (Hijau) --}}
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-primary-600"></div>

                    {{-- Step 2: Selesai --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-primary-600 bg-primary-600 text-white flex items-center justify-center font-bold">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-primary-600">Data Lengkap</div>
                    </div>
                    
                    {{-- Garis Penghubung (Hijau) --}}
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-primary-600"></div>

                    {{-- Step 3: Aktif (Hijau Outline) --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-primary-600 flex items-center justify-center font-bold">
                            3
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-primary-600">Konfirmasi</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="mt-16">
            
            {{-- Menampilkan Error Validasi (jika ada) --}}
            @if ($errors->any())
                <div class="mb-8 rounded-md bg-red-50 p-4 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada konfirmasi Anda:</h3>
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

            <form action="{{ route('booking.storeBooking') }}" method="POST" x-data="{ agreed: false }">
                @csrf
                
                <div class="lg:flex lg:gap-x-12">
                    
                    {{-- Kolom Kiri: Review Jadwal (Sticky) --}}
                    <div class="lg:w-1/3 lg:flex-shrink-0 mb-8 lg:mb-0">
                        <div class="sticky top-24 rounded-2xl bg-primary-50 p-6 ring-1 ring-primary-200 shadow-lg">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold leading-7 text-primary-900">Detail Layanan</h3>
                                <a href="{{ route('booking.step1', $bookingData['layanan_id']) }}" class="text-sm font-medium text-accent-600 hover:text-accent-500 underline">
                                    Ubah
                                </a>
                            </div>
                            
                            <dl class="space-y-4 text-sm text-gray-700">
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Layanan</dt>
                                    <dd class="mt-1 font-medium text-gray-900 text-base">{{ $bookingData['layanan_nama'] ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Petugas</dt>
                                    <dd class="mt-1 font-medium text-gray-900 text-base">{{ $bookingData['petugas_nama'] ?? 'N/A' }}</dd>
                                </div>
                                <div class="pt-4 border-t border-primary-200">
                                    <dt class="text-xs text-gray-500 uppercase tracking-wide">Waktu Pertemuan</dt>
                                    <dd class="mt-1 font-bold text-primary-700 text-lg">
                                        {{ \Carbon\Carbon::parse($bookingData['tanggal_kunjungan'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    </dd>
                                    <dd class="font-bold text-primary-700 text-lg">
                                        Pukul {{ $bookingData['waktu_kunjungan'] ?? 'N/A' }} WIB
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Review Data Diri & Persetujuan --}}
                    <div class="lg:w-2/3">
                        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold leading-7 text-gray-900">Data Diri Pemohon</h3>
                                <a href="{{ route('booking.step2') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500 underline">
                                    Edit Data
                                </a>
                            </div>

                            <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="mt-1 text-base text-gray-900">{{ $bookingData['nama_lengkap'] ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">NIK</dt>
                                    <dd class="mt-1 text-base text-gray-900">{{ $bookingData['nik'] ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nomor HP / WA</dt>
                                    <dd class="mt-1 text-base text-gray-900">{{ $bookingData['no_hp'] ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-base text-gray-900">{{ $bookingData['email'] ?? '-' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-base text-gray-900">{{ $bookingData['alamat_terakhir'] ?? '-' }}</dd>
                                </div>
                                @if(isset($bookingData['tanggal_lahir']))
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">Tanggal Lahir</dt>
                                        <dd class="mt-1 text-base text-gray-900">{{ \Carbon\Carbon::parse($bookingData['tanggal_lahir'])->format('d-m-Y') }}</dd>
                                    </div>
                                @endif
                            </div>

                            {{-- Checkbox Persetujuan --}}
                            <div class="mt-10 rounded-lg bg-yellow-50 p-4 border border-yellow-200">
                                <div class="relative flex items-start">
                                    <div class="flex h-6 items-center">
                                        <input id="konfirmasi" name="konfirmasi" type="checkbox" x-model="agreed"
                                               class="h-5 w-5 rounded border-gray-300 text-accent-600 focus:ring-accent-600 cursor-pointer">
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="konfirmasi" class="font-medium text-gray-900 cursor-pointer">
                                            Saya menyatakan bahwa data yang saya isi adalah benar. 
                                            <br>
                                            Saya bersedia membawa <strong>SEMUA BERKAS FISIK (Asli & Fotokopi)</strong> sesuai persyaratan saat datang ke kelurahan.
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Tombol Navigasi --}}
                        <div class="mt-10 flex justify-between items-center">
                            <a href="{{ route('booking.step2') }}"
                               class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                                <span aria-hidden="true">&larr;</span> Kembali
                            </a>
                            
                            <button type="submit"
                                    :disabled="!agreed"
                                    :class="{'opacity-50 cursor-not-allowed bg-gray-400': !agreed, 'bg-accent-500 hover:bg-accent-600': agreed}"
                                    class="rounded-md px-8 py-4 text-base font-bold text-white shadow-sm transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500">
                                KONFIRMASI & BUAT JANJI TEMU
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>