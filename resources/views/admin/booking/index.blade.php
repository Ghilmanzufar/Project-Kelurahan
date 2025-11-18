<x-admin-layout>
    <x-slot name="header">
        {{ __('Manajemen Booking (Menunggu Konfirmasi)') }}
    </x-slot>

    {{-- 
        Inisialisasi Alpine.js untuk semua state modal.
        File _modal-detail.blade.php dan _modal-konfirmasi.blade.php akan membaca state ini.
    --}}
    <div x-data="{ 
        showModal: false, 
        selectedBooking: null, 
        showConfirmModal: false, 
        confirmMessage: '', 
        formToSubmit: '' 
    }">

        {{-- =============================================== --}}
        {{-- <<< FORM FILTER YANG DIPERBARUI >>> --}}
        {{-- =============================================== --}}
        <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Filter Booking</h3>
                <form action="{{ route('admin.booking.index') }}" method="GET" class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        
                        {{-- Filter Tanggal Janji Temu --}}
                        <div>
                            <label for="tanggal_janji_temu" class="block text-sm font-medium text-gray-700">Tanggal Janji Temu</label>
                            <input type="date" name="tanggal_janji_temu" id="tanggal_janji_temu" 
                                   value="{{ request('tanggal_janji_temu') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Filter Layanan --}}
                        <div>
                            <label for="layanan_id" class="block text-sm font-medium text-gray-700">Layanan</label>
                            <select id="layanan_id" name="layanan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Semua Layanan</option>
                                @foreach ($allLayanan as $layanan)
                                    <option value="{{ $layanan->id }}" @if(request('layanan_id') == $layanan->id) selected @endif>{{ $layanan->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Petugas --}}
                        <div>
                            <label for="petugas_id" class="block text-sm font-medium text-gray-700">Petugas</label>
                            <select id="petugas_id" name="petugas_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Semua Petugas</option>
                                @foreach ($allPetugas as $petugas)
                                    <option value="{{ $petugas->id }}" @if(request('petugas_id') == $petugas->id) selected @endif>{{ $petugas->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Urutkan --}}
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan</label>
                            <select id="sort" name="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="terbaru" @if(request('sort', 'terbaru') == 'terbaru') selected @endif>Terbaru Dibuat</option>
                                <option value="terlama" @if(request('sort') == 'terlama') selected @endif>Terlama Dibuat</option>
                                <option value="jadwal_terdekat" @if(request('sort') == 'jadwal_terdekat') selected @endif>Jadwal Terdekat</option>
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Filter
                            </button>
                            <a href="{{ route('admin.booking.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Pesan Sukses/Gagal (dari redirect controller) --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Daftar Booking Baru</h3>
                <p class="mt-2 text-gray-600">Berikut adalah daftar booking janji temu yang perlu dikonfirmasi atau ditolak.</p>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Booking</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Janji Temu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $booking->no_booking }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->warga->nama_lengkap }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->warga->nik }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->layanan->nama_layanan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $booking->jadwal_janji_temu->translatedFormat('d F Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->jadwal_janji_temu->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="selectedBooking = {{ $booking->toJson() }}; showModal = true"
                                                class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-md">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Tidak ada booking baru yang perlu dikonfirmasi saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>

        {{-- =============================================== --}}
        {{-- <<< KODE MODAL SEKARANG DIMASUKKAN DI SINI >>> --}}
        {{-- =============================================== --}}

        @include('admin.booking._modal-detail')
        
        @include('admin.booking._modal-konfirmasi')

    </div> {{-- Penutup x-data --}}
</x-admin-layout>