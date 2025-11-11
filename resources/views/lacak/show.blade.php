<x-public-layout>
    <div class="mx-auto max-w-4xl px-6 py-12 lg:px-8">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="{{ route('beranda') }}" class="text-gray-500 hover:text-gray-700 text-sm">Beranda</a></li>
                <li>
                    <span class="text-gray-500 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><a href="{{ route('lacak.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Lacak Pengajuan</a></li>
                <li>
                    <span class="text-gray-500 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><span class="text-gray-500 text-sm">{{ $booking->nomor_booking }}</span></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Hasil Pelacakan untuk: {{ $booking->nomor_booking }}</h1>

        {{-- Detail Pengajuan --}}
        <div class="mt-8 p-6 rounded-lg border border-gray-300 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-900">Detail Pengajuan:</h2>
            <div class="mt-4 space-y-3">
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Nama Pemohon:</span>
                    <span class="text-gray-900">{{ $booking->nama_pemohon }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Jenis Layanan:</span>
                    <span class="text-gray-900">{{ $booking->layanan->nama_layanan }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 pb-2">
                    <span class="text-gray-600 font-medium">Tanggal Pertemuan:</span>
                    <span class="text-gray-900">
                        {{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->translatedFormat('d F Y') }} Pukul {{ $booking->waktu_kunjungan }} WIB
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 font-medium">Petugas Loket:</span>
                    <span class="text-gray-900">{{ $booking->petugas->name }}</span>
                </div>
            </div>
        </div>

        {{-- Status Saat Ini --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900">STATUS SAAT INI:</h2>
            <div class="mt-4 p-4 rounded-md bg-blue-100 text-blue-800 font-semibold text-lg text-center shadow-sm">
                {{ $booking->latest_status }} {{-- Menggunakan accessor latest_status dari model Booking --}}
            </div>
        </div>

        {{-- Progres Berkas Anda --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900">Progres Berkas Anda:</h2>
            <div class="mt-6 relative pl-6">
                @foreach ($progresSteps as $key => $label)
                    @php
                        // Cek apakah status ini sudah ada di log atau merupakan status terkini
                        $isCompleted = $booking->statusLogs->where('status', $key)->isNotEmpty();
                        $isCurrent = ($key === $latestStatus);
                    @endphp
                    <div class="mb-8 flex items-start">
                        {{-- Icon Progres --}}
                        <div class="absolute -left-1.5 transform -translate-x-1/2 rounded-full border-2 
                                    {{ $isCompleted ? 'bg-blue-600 border-blue-600' : 'bg-white border-gray-300' }} 
                                    h-4 w-4 flex items-center justify-center">
                            @if ($isCompleted)
                                <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <span class="text-gray-500 text-xs {{ $isCurrent ? 'text-blue-600' : '' }}"></span>
                            @endif
                        </div>
                        {{-- Garis vertikal --}}
                        @if (!$loop->last)
                            <div class="absolute left-0 top-0 bottom-0 w-0.5 ml-0.5 
                                        {{ $isCompleted ? 'bg-blue-600' : 'bg-gray-300' }}"></div>
                        @endif

                        {{-- Teks Progres --}}
                        <div class="ml-8">
                            <p class="font-semibold text-gray-900 {{ $isCurrent ? 'text-blue-600' : '' }}">{{ $label }}</p>
                            @if ($isCurrent)
                                <p class="text-sm text-blue-600">(Status Saat Ini)</p>
                            @elseif ($isCompleted)
                                <p class="text-sm text-gray-500">(Status Selesai)</p>
                            @else
                                <p class="text-sm text-gray-500">(Status Berikutnya)</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Riwayat Status (Log) --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900">Riwayat Status (Log):</h2>
            <div class="mt-6 p-6 rounded-lg border border-gray-300 bg-gray-50">
                <div class="space-y-4">
                    @forelse ($booking->statusLogs as $log)
                        <div class="border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M, H:i') }} - 
                                <span class="font-semibold text-gray-800">{{ $log->status }}</span>
                            </p>
                            <p class="mt-1 text-gray-700">{{ $log->deskripsi }}</p>
                        </div>
                    @empty
                        <p class="text-gray-600 italic">Belum ada riwayat status.</p>
                    @endforelse
                </div>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('lacak.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                    Lacak Nomor Booking Lainnya &rarr;
                </a>
            </div>
        </div>
    </div>
</x-public-layout>