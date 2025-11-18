<x-public-layout>
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION (HIJAU TUA) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 py-24 sm:py-32 overflow-hidden">
        {{-- Dekorasi Background --}}
        <div class="absolute inset-0 overflow-hidden">
            <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-primary-700/50 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                Hubungi Kami
            </h1>
            <p class="mt-6 text-lg leading-8 text-primary-100 max-w-2xl mx-auto">
                Kami siap melayani Anda. Silakan hubungi kami melalui saluran di bawah ini atau datang langsung ke kantor pelayanan kami.
            </p>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< KARTU KONTAK & FORMULIR >>> --}}
    {{-- =============================================== --}}
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-16">
                
                {{-- KOLOM KIRI: INFORMASI KONTAK --}}
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Informasi Kontak</h2>
                    <p class="mt-4 text-lg leading-8 text-gray-600">
                        Tim pelayanan pertanahan Kelurahan Klender siap membantu menjawab pertanyaan Anda seputar prosedur dan persyaratan.
                    </p>

                    <dl class="mt-10 space-y-8 text-base leading-7 text-gray-600">
                        {{-- Alamat --}}
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Alamat</span>
                                <div class="h-10 w-10 rounded-lg bg-primary-50 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>
                            </dt>
                            <dd>
                                <strong class="font-semibold text-gray-900">Kantor Kelurahan Klender</strong><br>
                                Jl. Raya Klender No. 1, RT.01/RW.01<br>
                                Duren Sawit, Kota Jakarta Timur<br>
                                DKI Jakarta 13470
                            </dd>
                        </div>

                        {{-- Telepon --}}
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Telepon</span>
                                <div class="h-10 w-10 rounded-lg bg-primary-50 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                            </dt>
                            <dd>
                                <a class="hover:text-primary-600" href="tel:+62211234567">(021) 123-4567</a>
                            </dd>
                        </div>

                        {{-- Email --}}
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Email</span>
                                <div class="h-10 w-10 rounded-lg bg-primary-50 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                            </dt>
                            <dd>
                                <a class="hover:text-primary-600" href="mailto:kontak@kel-klender.go.id">kontak@kel-klender.go.id</a>
                            </dd>
                        </div>

                        {{-- Jam Operasional --}}
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Jam Operasional</span>
                                <div class="h-10 w-10 rounded-lg bg-primary-50 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </dt>
                            <dd>
                                <strong class="font-semibold text-gray-900">Jam Pelayanan:</strong><br>
                                Senin - Jumat: 08:00 - 15:00 WIB<br>
                                Sabtu - Minggu: Libur
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- KOLOM KANAN: PETA LOKASI --}}
                <div class="relative rounded-2xl bg-gray-50 p-2 ring-1 ring-gray-200 h-full min-h-[400px]">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.295658834759!2d106.8981330759576!3d-6.224691893764184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f34408f31d3b%3A0x3a90d8b65d72530!2sKantor%20Kelurahan%20Klender!5e0!3m2!1sid!2sid!4v1709220000000!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0; border-radius: 12px; min-height: 400px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< FORMULIR PESAN (AKSEN EMAS) >>> --}}
    {{-- =============================================== --}}
    <div class="bg-primary-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kirim Pesan</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">Masukan, saran, atau pertanyaan umum dapat Anda kirimkan melalui formulir ini.</p>
            </div>
            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="mx-auto max-w-xl mb-8 rounded-md bg-green-50 p-4 border border-green-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <form action="{{ route('kontak.store') }}" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
                @csrf
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                    <div>
                        <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">Nama Depan</label>
                        <div class="mt-2.5">
                            <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div>
                        <label for="last-name" class="block text-sm font-semibold leading-6 text-gray-900">Nama Belakang</label>
                        <div class="mt-2.5">
                            <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-semibold leading-6 text-gray-900">Email</label>
                        <div class="mt-2.5">
                            <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">Pesan</label>
                        <div class="mt-2.5">
                            <textarea name="message" id="message" rows="4" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    <button type="submit"
                            class="block w-full rounded-md bg-accent-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-accent-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-600 transition-colors duration-200">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>