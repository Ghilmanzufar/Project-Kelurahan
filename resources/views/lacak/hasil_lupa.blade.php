<x-public-layout>
    {{-- Header Section dengan Background Hijau Muda --}}
    <div class="bg-primary-50 py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
            <h1 class="text-3xl font-bold tracking-tight text-primary-900 sm:text-4xl">Riwayat Pengajuan Anda</h1>
            <p class="mt-4 text-lg leading-8 text-primary-700">
                Halo, <strong>{{ $warga->nama_lengkap }}</strong>. Berikut adalah daftar pengajuan layanan yang pernah Anda buat.
            </p>
        </div>
    </div>

    <div class="bg-white py-12 sm:py-16">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            
            {{-- Breadcrumbs --}}
            <nav class="flex mb-8 justify-center" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2">
                    <li><a href="{{ route('beranda') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors">Beranda</a></li>
                    <li><span class="text-gray-400 text-sm">/</span></li>
                    <li><a href="{{ route('lacak.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors">Lacak Pengajuan</a></li>
                    <li><span class="text-gray-400 text-sm">/</span></li>
                    <li><a href="{{ route('lacak.showLupaForm') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 transition-colors">Lupa Nomor</a></li>
                    <li><span class="text-gray-400 text-sm">/</span></li>
                    <li><span class="text-sm font-medium text-primary-700">Hasil Pencarian</span></li>
                </ol>
            </nav>

            {{-- Info Hasil --}}
            <div class="mb-8 text-center">
                <p class="text-sm text-gray-600">
                    Ditemukan <span class="font-bold text-primary-700">{{ $riwayatBooking->count() }}</span> riwayat pengajuan untuk NIK: {{ $warga->nik }}
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
                {{-- PERBAIKAN: Gunakan $riwayatBooking, bukan $bookings --}}
                @foreach ($riwayatBooking as $booking)
                    <div class="relative flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        
                        {{-- Header Kartu: No Booking & Tanggal --}}
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                            <h3 class="text-lg font-bold text-gray-900 font-mono">{{ $booking->no_booking }}</h3>
                            <time class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d F Y') }}</time>
                        </div>

                        {{-- Isi Kartu --}}
                        <div class="flex-1 space-y-3 mb-6">
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Layanan</p>
                                <p class="text-sm text-gray-900">{{ $booking->layanan->nama_layanan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-semibold">Status Terakhir</p>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium mt-1
                                    @if($booking->status_berkas == 'SELESAI') bg-green-100 text-green-800
                                    @elseif($booking->status_berkas == 'DITOLAK') bg-red-100 text-red-800
                                    @elseif($booking->status_berkas == 'JANJI TEMU DIBUAT') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif
                                ">
                                    {{ $booking->status_berkas }}
                                </span>
                            </div>
                        </div>

                        {{-- Footer Kartu: Tombol Lacak --}}
                        <a href="{{ route('lacak.show', $booking->no_booking) }}" 
                           class="mt-auto w-full rounded-md bg-primary-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">
                            Lihat Detail Progres &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                 <a href="{{ route('lacak.showLupaForm') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600">
                    &larr; Kembali ke Pencarian
                 </a>
            </div>
        </div>
    </div>
</x-public-layout>