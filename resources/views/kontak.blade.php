<x-public-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            {{-- Breadcrumbs --}}
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2">
                    <li><a href="{{ route('beranda') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Beranda</a></li>
                    <li>
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li><span class="text-sm font-medium text-gray-700">Kontak Kami</span></li>
                </ol>
            </nav>

            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Hubungi Kami</h1>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Kami siap membantu Anda. Jangan ragu untuk menghubungi Kelurahan Klender melalui informasi di bawah ini.
                </p>
            </div>

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 text-base leading-7 sm:grid-cols-2 sm:gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-4">
                {{-- Alamat --}}
                <div>
                    <h3 class="font-semibold text-gray-900">Alamat Kami</h3>
                    <address class="mt-4 not-italic text-gray-600">
                        <p>Jl. Pahlawan Revolusi No. 1</p>
                        <p>Kelurahan Klender, Kecamatan Duren Sawit</p>
                        <p>Jakarta Timur, DKI Jakarta 13470</p>
                    </address>
                </div>

                {{-- Telepon --}}
                <div>
                    <h3 class="font-semibold text-gray-900">Nomor Telepon</h3>
                    <p class="mt-4 text-gray-600">
                        <a href="tel:+6221xxxxxxx" class="hover:text-gray-900">(021) 1234 5678</a>
                    </p>
                    <p class="text-gray-600">
                        <a href="tel:+62812xxxxxxx" class="hover:text-gray-900">0812-3456-7890 (WhatsApp)</a>
                    </p>
                </div>

                {{-- Email --}}
                <div>
                    <h3 class="font-semibold text-gray-900">Email</h3>
                    <p class="mt-4 text-gray-600">
                        <a href="mailto:info@kelurahanklender.go.id" class="hover:text-gray-900">info@kelurahanklender.go.id</a>
                    </p>
                    <p class="text-gray-600">
                        <a href="mailto:pengaduan@kelurahanklender.go.id" class="hover:text-gray-900">pengaduan@kelurahanklender.go.id</a>
                    </p>
                </div>

                {{-- Jam Operasional --}}
                <div>
                    <h3 class="font-semibold text-gray-900">Jam Operasional</h3>
                    <p class="mt-4 text-gray-600">
                        Senin - Jumat: 08:00 - 15:00 WIB
                    </p>
                    <p class="text-gray-600">
                        Istirahat: 12:00 - 13:00 WIB
                    </p>
                    <p class="text-gray-600">
                        Sabtu, Minggu & Hari Libur Nasional: Tutup
                    </p>
                </div>
            </div>

            {{-- Peta Lokasi (Placeholder) --}}
            <div class="mx-auto mt-16 max-w-2xl lg:max-w-none">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl text-center">Lokasi Kami</h2>
                <div class="mt-8 overflow-hidden rounded-lg shadow-xl ring-1 ring-gray-900/5 aspect-w-16 aspect-h-9">
                    {{-- Placeholder untuk Google Maps Embed. Ganti dengan kode embed asli Anda. --}}
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.196500589139!2d106.89973687502758!3d-6.236681093740924!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d2495b4588d%3A0xb3a8e94e7b8a8e1b!2sKantor%20Kelurahan%20Klender!5e0!3m2!1sen!2sid!4v1700473852033!5m2!1sen!2sid"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <p class="mt-4 text-center text-sm text-gray-600">
                    Anda bisa menemukan kami di lokasi ini. Klik pada peta untuk melihat detail lebih lanjut di Google Maps.
                </p>
            </div>
        </div>
    </div>
</x-public-layout>