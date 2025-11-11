<x-public-layout>
    <div class="mx-auto max-w-2xl px-6 py-12 lg:px-8 text-center">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8 justify-center" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="{{ route('beranda') }}" class="text-gray-500 hover:text-gray-700 text-sm">Beranda</a></li>
                <li>
                    <span class="text-gray-500 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><span class="text-gray-500 text-sm">Lacak Pengajuan</span></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Lacak Status Pengajuan Berkas Anda</h1>
        <p class="mt-4 text-lg leading-8 text-gray-700">
            Masukkan Nomor Booking / Registrasi yang Anda dapatkan saat pendaftaran janji temu.
        </p>

        <form action="{{ route('lacak.search') }}" method="POST" class="mt-12 max-w-md mx-auto">
            @csrf

            <div>
                <label for="nomor_booking" class="sr-only">Nomor Booking / Registrasi:</label>
                <input type="text" name="nomor_booking" id="nomor_booking"
                       class="block w-full rounded-md border-0 py-3.5 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-lg sm:leading-6"
                       placeholder="BKG-2023xxxx-xxx" value="{{ old('nomor_booking') }}" required>
            </div>

            @error('nomor_booking')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button type="submit"
                    class="mt-6 inline-flex w-full items-center justify-center rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                Lacak Sekarang
            </button>
        </form>

        <div class="mt-12 text-sm text-gray-600">
            <p>Lupa Nomor Booking? Lacak menggunakan NIK 
                <a href="{{ route('lacak.showLupaForm') }}" class="text-blue-600 hover:text-blue-500">di sini</a>
            .</p>
        </div>
    </div>
</x-public-layout>