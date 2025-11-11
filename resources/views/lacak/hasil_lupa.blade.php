<x-public-layout>
    <div class="bg-gray-50 py-16">
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
                    <li><a href="{{ route('lacak.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Lacak Pengajuan</a></li>
                    <li>
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </li>
                    <li><span class="text-sm font-medium text-gray-700">Hasil Pencarian</span></li>
                </ol>
            </nav>

            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Hasil Pencarian untuk NIK: {{ $warga->nik }}</h1>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Menampilkan <span class="font-bold text-gray-900">{{ $bookings->count() }}</span> riwayat pengajuan (diurutkan dari yang terbaru).
                </p>
            </div>

            <div class="mt-12 space-y-8">
                @forelse ($bookings as $booking)
                    <div class="bg-white p-6 rounded-lg shadow-lg ring-1 ring-gray-900/5">
                        <div class="sm:flex sm:items-start sm:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">No. Booking: {{ $booking->no_booking }}</h2>
                                <p class="mt-2 text-gray-700"><strong>Layanan:</strong> {{ $booking->layanan->nama_layanan ?? 'N/A' }}</p>
                                <p class="text-gray-700"><strong>Tgl. Booking:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0">
                                <a href="{{ route('lacak.show', $booking->no_booking) }}"
                                   class="inline-flex w-full sm:w-auto items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                                    Lacak Detail &rarr;
                                </a>
                            </div>
                        </div>
                        <div class="mt-4 border-t border-gray-200 pt-4">
                            <p class="text-sm font-medium text-gray-600">Status Saat Ini:</p>
                            @php
                                // Ambil status terbaru dari log
                                $latestLog = $booking->statusLogs->first();
                                $latestStatus = $latestLog->status ?? $booking->status_berkas;
                                $statusColorClass = 'bg-gray-100 text-gray-800'; // Default
                                if ($latestStatus === 'JANJI TEMU DIBUAT') $statusColorClass = 'bg-blue-100 text-blue-800';
                                if ($latestStatus === 'BERKAS DITERIMA') $statusColorClass = 'bg-yellow-100 text-yellow-800';
                                if ($latestStatus === 'SEDANG DIPROSES') $statusColorClass = 'bg-orange-100 text-orange-800';
                                if ($latestStatus === 'SELESAI') $statusColorClass = 'bg-green-100 text-green-800';
                            @endphp
                            <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $statusColorClass }}">
                                {{ $latestStatus }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center bg-white p-8 rounded-lg shadow-lg ring-1 ring-gray-900/5">
                        <h2 class="text-2xl font-bold text-gray-900">Tidak Ada Riwayat Ditemukan</h2>
                        <p class="mt-4 text-gray-600">Kami tidak dapat menemukan riwayat pengajuan apa pun yang cocok dengan data diri yang Anda masukkan.</p>
                        <a href="{{ route('lacak.showLupaForm') }}"
                           class="mt-6 inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                            &larr; Coba Cari Lagi
                        </a>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('lacak.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    &larr; Kembali ke Pencarian Utama
                </a>
            </div>

        </div>
    </div>
</x-public-layout>