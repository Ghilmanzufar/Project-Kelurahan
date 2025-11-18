<x-public-layout>
    {{-- Header Section dengan Background Hijau Muda --}}
    <div class="bg-primary-50 py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold tracking-tight text-primary-900 sm:text-4xl">Bantuan Lacak Pengajuan</h1>
            <p class="mt-4 text-lg leading-8 text-primary-700">
                Lupa Nomor Booking Anda? Jangan khawatir.
                <br>
                Cukup masukkan data diri Anda untuk menemukan riwayat pengajuan.
            </p>
        </div>
    </div>

    <div class="bg-white py-12 sm:py-16">
        <div class="mx-auto max-w-xl px-6 lg:px-8">
            
            {{-- Breadcrumbs --}}
            <nav class="flex mb-8 justify-center" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2">
                    <li><a href="{{ route('beranda') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors">Beranda</a></li>
                    <li><span class="text-gray-400 text-sm">/</span></li>
                    <li><a href="{{ route('lacak.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors">Lacak Pengajuan</a></li>
                    <li><span class="text-gray-400 text-sm">/</span></li>
                    <li><span class="text-sm font-medium text-primary-700">Lupa Nomor Booking</span></li>
                </ol>
            </nav>

            <div class="bg-white shadow-xl ring-1 ring-gray-900/5 sm:rounded-2xl p-8 sm:p-10">
                {{-- Alert Error --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-md bg-red-50 p-4 border-l-4 border-red-500">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
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

                <form action="{{ route('lacak.searchByWarga') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="nik" class="block text-sm font-medium leading-6 text-gray-900">Nomor Induk Kependudukan (NIK)</label>
                        <div class="mt-2">
                            <input type="text" name="nik" id="nik"
                                   class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 transition-all"
                                   placeholder="Masukkan 16 digit NIK Anda" value="{{ old('nik') }}" required>
                        </div>
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium leading-6 text-gray-900">Tanggal Lahir</label>
                        <div class="mt-2">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                   class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 transition-all"
                                   value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="no_hp" class="block text-sm font-medium leading-6 text-gray-900">Nomor HP / WhatsApp</label>
                        <div class="mt-2">
                            <input type="tel" name="no_hp" id="no_hp"
                                   class="block w-full rounded-md border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6 transition-all"
                                   placeholder="Contoh: 081234567890" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="flex w-full justify-center rounded-md bg-accent-500 px-3 py-3 text-sm font-bold leading-6 text-white shadow-sm hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500 transition-all duration-200">
                            CARI RIWAYAT SAYA
                        </button>
                    </div>

                    <div class="text-center border-t border-gray-100 pt-6">
                        <p class="text-sm text-gray-500">Sudah ingat Nomor Booking Anda?</p>
                        <a href="{{ route('lacak.index') }}" class="font-semibold text-primary-600 hover:text-primary-500 hover:underline transition-colors">
                            &larr; Kembali ke Lacak dengan Nomor
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-public-layout>