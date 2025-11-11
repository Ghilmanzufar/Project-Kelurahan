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
            <div class="flex-grow border-t border-blue-600"></div> {{-- Garis aktif --}}
            <div class="flex items-center text-blue-600">
                <div class="h-8 w-8 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-sm mr-2">2</div>
                <span class="font-semibold">ISI DATA DIRI</span>
            </div>
            <div class="flex-grow border-t border-gray-300"></div>
            <div class="flex items-center text-gray-500">
                <div class="h-8 w-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-500 font-bold text-sm mr-2">3</div>
                <span>KONFIRMASI</span>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900">LANGKAH 2: ISI DATA DIRI ANDA</h2>

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

            <form action="{{ route('booking.storeStep2') }}" method="POST" class="mt-10">
                @csrf

                {{-- Ringkasan Pilihan (sesuai mockup image_057da7.png) --}}
                <div class="p-6 rounded-lg border border-gray-300 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Pilihan Anda:</h3>
                    
                    {{-- Data ini diambil dari Session ($bookingData) --}}
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
                    
                    <a href="{{ route('booking.showStep1', $bookingData['layanan_id']) }}" class="mt-4 inline-block text-sm font-medium text-blue-600 hover:text-blue-500">
                        &larr; Ubah Jadwal (Kembali ke Langkah 1)
                    </a>
                </div>

                {{-- Formulir Data Diri --}}
                <div class="mt-8 space-y-6">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap (Sesuai KTP) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nama_lengkap" id="nama_lengkap" autocomplete="name"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   placeholder="Masukkan nama lengkap Anda" value="{{ old('nama_lengkap', Session::get('booking.nama_lengkap')) }}" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="nik" class="block text-sm font-medium leading-6 text-gray-900">Nomor Induk Kependudukan (NIK) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nik" id="nik"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   placeholder="Masukkan 16 digit NIK Anda" value="{{ old('nik', Session::get('booking.nik')) }}" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">(Digunakan untuk Lacak Pengajuan Anda jika lupa No. Booking)</p>
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   value="{{ old('tanggal_lahir', Session::get('booking.tanggal_lahir')) }}" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">(Digunakan untuk Lupa Nomor Booking)</p>
                    </div>
                    
                    <div>
                        <label for="nomor_hp" class="block text-sm font-medium leading-6 text-gray-900">Nomor HP / WhatsApp (Wajib Aktif) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="tel" name="nomor_hp" id="nomor_hp" autocomplete="tel"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   placeholder="Contoh: 081234567890" value="{{ old('nomor_hp', Session::get('booking.nomor_hp')) }}" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">(Kami akan mengirimkan notifikasi booking ke nomor ini)</p>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Alamat Email (Wajib Aktif) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   placeholder="Contoh: nama@email.com" value="{{ old('email', Session::get('booking.email')) }}" required>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">(Kami akan mengirimkan BUKTI BOOKING lengkap ke email ini)</p>
                    </div>
                </div>

                {{-- Tombol Navigasi (sesuai mockup image_057dc9.png) --}}
                <div class="mt-12 flex items-center justify-between border-t border-gray-200 pt-8">
                    <a href="{{ route('booking.showStep1', $bookingData['layanan_id']) }}"
                       class="rounded-md bg-gray-700 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-600">
                        &larr; Kembali ke Jadwal
                    </a>
                    
                    <button type="submit"
                            class="rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        Lanjut ke Konfirmasi &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>