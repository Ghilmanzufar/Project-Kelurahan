<x-admin-layout>
    <x-slot name="header">
        {{ __('Halaman Laporan & Statistik') }}
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Laporan</h3>

                {{-- Filter Tanggal --}}
                <form action="{{ route('admin.laporan.index') }}" method="GET" class="mb-6 flex flex-wrap items-end gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Dari Tanggal:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Sampai Tanggal:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Filter
                        </button>
                    </div>
                    @if(request('start_date') || request('end_date'))
                        <div>
                            <a href="{{ route('admin.laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Reset Filter
                            </a>
                        </div>
                    @endif
                    {{-- <<< TOMBOL DOWNLOAD PDF BARU >>> --}}
                    <div>
                        <a href="{{ route('admin.laporan.download_pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download PDF
                        </a>
                    </div>
                </form>

                {{-- Kartu Statistik Utama --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <x-statistic-card title="Total Booking" :value="$totalBooking" icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" color="bg-blue-500"/>
                    <x-statistic-card title="Booking Selesai" :value="$bookingSelesai" icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" color="bg-green-500"/>
                    <x-statistic-card title="Booking Pending" :value="$bookingPending" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" color="bg-yellow-500"/>
                    <x-statistic-card title="Booking Ditolak" :value="$bookingDitolak" icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" color="bg-red-500"/>
                </div>

                {{-- Statistik Tambahan (Warga & Petugas) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <x-statistic-card title="Total Warga Terdaftar" :value="$totalWarga" icon="M17 20h5v-2a3 3 0 00-5.356-2.37M16 13A4 4 0 118 5a4 4 0 018 0zM4 20v-2a3 3 0 015.356-2.37m-5.356 2.37H2v-2a3 3 0 013-3h12a3 3 0 013 3v2z" color="bg-purple-500"/>
                    <x-statistic-card title="Total Petugas/Admin" :value="$totalPetugas" icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" color="bg-teal-500"/>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- 5 Layanan Paling Populer --}}
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">5 Layanan Paling Populer ({{ $startDate }} s/d {{ $endDate }})</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Booking</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($layananPopuler as $layanan)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $layanan->nama_layanan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-700">{{ $layanan->bookings_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data layanan populer.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Ringkasan Status Booking --}}
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Status Booking ({{ $startDate }} s/d {{ $endDate }})</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($bookingStatusCounts as $status => $count)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::title(str_replace('_', ' ', $status)) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-700">{{ $count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada ringkasan status booking.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> {{-- End grid --}}

                {{-- Tabel Booking Terbaru --}}
                <div class="bg-white p-6 shadow sm:rounded-lg mt-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">10 Booking Terbaru ({{ $startDate }} s/d {{ $endDate }})</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Booking</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Warga</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal/Waktu Booking</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Berkas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($recentBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking->no_booking }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $booking->warga->nama_lengkap ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $booking->layanan->nama_layanan ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }} / {{ $booking->jam_booking }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($booking->status_berkas == 'SELESAI') bg-green-100 text-green-800
                                                @elseif($booking->status_berkas == 'DITOLAK') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif
                                            ">
                                                {{ Str::title(str_replace('_', ' ', $booking->status_berkas)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada booking terbaru dalam periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>