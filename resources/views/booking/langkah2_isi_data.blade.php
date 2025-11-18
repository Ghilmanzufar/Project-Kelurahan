<x-public-layout>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Beranda</a></li>
                <li><span class="text-gray-400 text-sm">/</span></li>
                <li><a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Layanan</a></li>
                <li><span class="text-gray-400 text-sm">/</span></li>
                <li><span class="text-primary-700 font-medium text-sm">Buat Janji Temu</span></li>
            </ol>
        </nav>

        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-4xl sm:tracking-tight">
                    Buat Janji Temu Pelayanan
                </h2>
                <p class="mt-2 text-lg text-gray-600">Lengkapi data diri Anda untuk proses booking.</p>
            </div>
        </div>

        {{-- Stepper Indicator --}}
        <div class="mt-10">
            <div class="flex items-center justify-center w-full">
                <div class="flex items-center w-full max-w-3xl">
                    {{-- Step 1: Selesai --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full h-10 w-10 py-3 border-2 border-primary-600 bg-primary-600 text-white flex items-center justify-center font-bold">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-primary-600">Jadwal Terpilih</div>
                    </div>
                    <div class="flex-auto border-t-2 border-primary-600"></div>

                    {{-- Step 2: Aktif --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full h-10 w-10 py-3 border-2 border-primary-600 flex items-center justify-center font-bold">
                            2
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-primary-600">Isi Data Diri</div>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300"></div>

                    {{-- Step 3: Pending --}}
                    <div class="relative flex flex-col items-center text-gray-400">
                        <div class="rounded-full h-10 w-10 py-3 border-2 border-gray-300 flex items-center justify-center font-bold">
                            3
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Konfirmasi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16 lg:flex lg:gap-x-12">
            {{-- Kolom Kiri: Ringkasan Booking --}}
            <div class="lg:w-1/3 lg:flex-shrink-0">
                <div class="sticky top-24 rounded-2xl bg-primary-50 p-6 ring-1 ring-primary-200 shadow-lg">
                    <h3 class="text-lg font-bold leading-7 text-primary-900 mb-6">Ringkasan Janji Temu</h3>
                    
                    <dl class="space-y-4 text-sm text-gray-700">
                        <div>
                            <dt class="font-medium text-primary-800">Layanan:</dt>
                            <dd class="ml-2">{{ $bookingData['layanan_nama'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-primary-800">Petugas:</dt>
                            <dd class="ml-2">{{ $bookingData['petugas_nama'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-primary-800">Tanggal:</dt>
                            <dd class="ml-2">
                                @if(isset($bookingData['tanggal_kunjungan']))
                                    {{ \Carbon\Carbon::parse($bookingData['tanggal_kunjungan'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-primary-800">Waktu:</dt>
                            <dd class="ml-2">{{ $bookingData['waktu_kunjungan'] ?? '-' }} WIB</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Kolom Kanan: Form Data Diri --}}
            <div class="lg:w-2/3 lg:mt-0 mt-12">
                <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4">Lengkapi Data Diri Anda</h3>
                
                <form action="{{ route('booking.storeStep2') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium leading-6 text-gray-900">Nama Lengkap (Sesuai KTP) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nama_lengkap" id="nama_lengkap" autocomplete="name"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                   placeholder="Masukkan nama lengkap Anda" 
                                   value="{{ old('nama_lengkap', Session::get('booking.nama_lengkap')) }}" required>
                            @error('nama_lengkap')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    
                    {{-- NIK (PERBAIKAN NAMA FIELD) --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium leading-6 text-gray-900">Nomor Induk Kependudukan (NIK) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            {{-- Ubah name="nomor_ktp" menjadi name="nik" agar sesuai controller --}}
                            <input type="text" name="nik" id="nik"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                   placeholder="Masukkan 16 digit NIK Anda" 
                                   value="{{ old('nik', Session::get('booking.nik')) }}" required>
                            @error('nik')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">(Digunakan untuk Lacak Pengajuan Anda jika lupa No. Booking)</p>
                    </div>

                    {{-- Tanggal Lahir (Opsional, tapi dikirim controller) --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</label>
                        <div class="mt-2">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                   value="{{ old('tanggal_lahir', Session::get('booking.tanggal_lahir')) }}">
                            @error('tanggal_lahir')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    
                    {{-- Nomor HP (PERBAIKAN NAMA FIELD) --}}
                    <div>
                        <label for="nomor_hp" class="block text-sm font-medium leading-6 text-gray-900">Nomor HP / WhatsApp (Wajib Aktif) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            {{-- Ubah name="nomor_telepon" menjadi name="nomor_hp" agar sesuai controller --}}
                            <input type="tel" name="nomor_hp" id="nomor_hp" autocomplete="tel"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                   placeholder="Contoh: 081234567890" 
                                   value="{{ old('nomor_hp', Session::get('booking.no_hp')) }}" required>
                            @error('nomor_hp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <p class="mt-2 text-xs text-gray-500">(Kami akan mengirimkan notifikasi booking ke nomor ini)</p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Alamat Email (Opsional)</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"
                                   placeholder="Contoh: nama@email.com" 
                                   value="{{ old('email', Session::get('booking.email')) }}">
                            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    
                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium leading-6 text-gray-900">Alamat Lengkap (Opsional)</label>
                        <div class="mt-2">
                            <textarea id="alamat" name="alamat" rows="3"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">{{ old('alamat', Session::get('booking.alamat_terakhir')) }}</textarea>
                            @error('alamat')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Tombol Navigasi --}}
                    <div class="mt-10 flex justify-between">
                        <a href="{{ route('booking.step1', $bookingData['layanan_id'] ?? 1) }}" class="rounded-md bg-gray-200 px-6 py-2 text-base font-semibold text-gray-700 shadow-sm hover:bg-gray-300 transition-colors">
                            &larr; Kembali
                        </a>
                        <button type="submit"
                                class="rounded-md bg-accent-500 px-10 py-3 text-base font-bold text-white shadow-sm hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500 transition-colors duration-300">
                            Lanjut ke Konfirmasi &rarr;
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-public-layout>