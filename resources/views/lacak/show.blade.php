<x-public-layout>
    {{-- =============================================== --}}
    {{-- <<< HERO SECTION (BACKGROUND HIJAU TUA) >>> --}}
    {{-- =============================================== --}}
    <div class="relative bg-primary-900 pt-24 pb-32 overflow-hidden">
        {{-- Dekorasi Background (Pola Garis Halus) --}}
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
                Status Pengajuan Anda
            </h1>
            <p class="mt-6 text-lg leading-8 text-primary-100 max-w-2xl mx-auto">
                Berikut adalah detail dan progres terbaru dari pengajuan berkas Anda dengan Nomor Booking:
            </p>
            <p class="mt-2 text-2xl sm:text-3xl font-bold text-accent-300">{{ $booking->no_booking }}</p>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< KONTEN UTAMA (KARTU INFORMASI) >>> --}}
    {{-- =============================================== --}}
    <div class="relative z-10 mx-auto max-w-5xl px-6 lg:px-8 -mt-24">
        <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12 ring-1 ring-gray-200">
            
            {{-- Bagian Atas: Ringkasan Booking dan Status Terakhir --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-8 border-b border-gray-200 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Detail Pengajuan</h2>
                    <p class="mt-2 text-base text-gray-600">Layanan: <span class="font-semibold text-primary-700">{{ $booking->layanan->nama_layanan }}</span></p>
                    <p class="text-base text-gray-600">Jadwal Temu: <span class="font-semibold text-primary-700">{{ \Carbon\Carbon::parse($booking->jadwal_janji_temu)->locale('id')->isoFormat('dddd, D MMMM YYYY [Pukul] HH:mm') }} WIB</span></p>
                </div>
                <div class="mt-6 md:mt-0 text-right md:text-left">
                    <span class="inline-flex items-center rounded-full bg-accent-100 px-4 py-1.5 text-sm font-bold text-accent-700 ring-1 ring-inset ring-accent-200">
                        STATUS: {{ $booking->status_berkas }}
                    </span>
                </div>
            </div>

            {{-- Timeline Status Pengajuan --}}
            <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Progres Berkas</h3>
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @foreach ($booking->statusLogs->sortBy('created_at') as $index => $log)
                        <li>
                            <div class="relative pb-8">
                                {{-- Garis Vertikal Kecuali Item Terakhir --}}
                                @if (!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        {{-- Icon Status --}}
                                        <span class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center ring-8 ring-white">
                                            @if($log->status == 'JANJI TEMU DIBUAT')
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            @elseif(Str::contains($log->status, ['DITERIMA', 'VERIFIKASI']))
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M17 16l4-4m-4 4l-4-4" />
                                                </svg>
                                            @elseif($log->status == 'SELESAI')
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @else {{-- Default atau 'DITOLAK' --}}
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-base text-gray-900 font-semibold">{{ $log->status }}</p>
                                            <p class="mt-0.5 text-sm text-gray-500">{{ $log->deskripsi }}</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $log->created_at->toISOString() }}">
                                                {{ $log->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Informasi Pemohon --}}
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Pemohon</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $booking->warga->nama_lengkap }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">NIK</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $booking->warga->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nomor HP</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $booking->warga->no_hp }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $booking->warga->email ?? '-' }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $booking->warga->alamat_terakhir ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-12 text-center">
                <a href="{{ route('lacak.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-primary-700 bg-primary-100 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Cari Pengajuan Lain
                </a>
            </div>

        </div>
    </div>
</x-public-layout>