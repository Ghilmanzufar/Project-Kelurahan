<x-public-layout>
    <div class="bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-xl">
                
                {{-- Breadcrumbs --}}
                <nav class="flex mb-8" aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2">
                        <li><a href="{{ route('beranda') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Beranda</a></li>
                        <li>
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li><a href="{{ route('lacak.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Lacak Pengajuan</a></li>
                        <li>
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </li>
                        <li><span class="text-sm font-medium text-gray-700">Lupa Nomor Booking</span></li>
                    </ol>
                </nav>

                <div class="text-center">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Lupa Nomor Booking?</h1>
                    <p class="mt-4 text-lg leading-8 text-gray-600">
                        Tidak masalah. Masukkan data diri Anda yang sesuai saat mendaftar untuk melihat riwayat pengajuan.
                    </p>
                </div>

                {{-- Tampilkan error jika data tidak cocok --}}
                @if ($errors->any())
                    <div class="mt-8 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Pencarian Gagal</h3>
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

                <form action="{{ route('lacak.searchByWarga') }}" method="POST" class="mt-10 bg-white p-8 rounded-lg shadow-lg ring-1 ring-gray-900/5 space-y-6">
                    @csrf
                    <div>
                        <label for="nik" class="block text-sm font-medium leading-6 text-gray-900">Nomor Induk Kependudukan (NIK) <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="text" name="nik" id="nik"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   placeholder="Masukkan 16 digit NIK Anda" value="{{ old('nik') }}" required>
                        </div>
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="no_hp" class="block text-sm font-medium leading-6 text-gray-900">Nomor HP / WhatsApp <span class="text-red-600">*</span></label>
                        <div class="mt-2">
                            <input type="tel" name="no_hp" id="no_hp"
                                   class="block w-full rounded-md border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                   placeholder="Contoh: 081234567890" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="flex w-full justify-center rounded-md bg-blue-600 px-8 py-3 text-base font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            CARI RIWAYAT SAYA
                        </button>
                    </div>

                    <div class="text-center mt-6">
                        <a href="{{ route('lacak.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            &larr; Lacak menggunakan Nomor Booking Saja?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>