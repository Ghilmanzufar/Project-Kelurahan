{{-- Menggunakan layout admin baru --}}
<x-admin-layout>
    <x-slot name="header">
        {{ __('Ringkasan Admin Panel') }} {{-- Judul untuk slot header di admin-layout --}}
    </x-slot>

    {{-- 
        Inisialisasi Alpine.js:
        - showModal: false (modal tertutup)
        - selectedBooking: null (data booking untuk modal masih kosong)
    --}}
    <div x-data="{ showModal: false, selectedBooking: null }">

        {{-- Konten Dashboard --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</h3>
            <p class="mt-4 text-gray-700">
                Anda berhasil login sebagai **{{ Str::title(str_replace('_', ' ', Auth::user()->role)) }}**.
                Di sini Anda dapat mengelola berbagai aspek sistem.
            </p>
            
            {{-- Bagian Statistik --}}
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-indigo-500 text-white p-6 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold">Total Layanan</h4>
                    <p class="text-3xl font-bold mt-2">{{ $totalLayanan }}</p>
                    <p class="text-sm mt-1">Layanan aktif</p>
                </div>
                <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold">Booking Hari Ini</h4>
                    <p class="text-3xl font-bold mt-2">{{ $totalBookingHariIni }}</p>
                    <p class="text-sm mt-1">Booking baru</p>
                </div>
                <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
                    <h4 class="text-lg font-semibold">Pengumuman Aktif</h4>
                    <p class="text-3xl font-bold mt-2">{{ $totalPengumuman }}</p>
                    <p class="text-sm mt-1">Pengumuman terbaru</p>
                </div>
            </div>
            
            {{-- Akses Cepat --}}
            <div class="mt-8">
                <h4 class="text-xl font-semibold text-gray-800">Akses Cepat</h4>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.booking.index') }}" class="bg-blue-100 text-blue-800 p-4 rounded-lg shadow hover:bg-blue-200 text-center">
                        <p class="font-medium">Lihat Semua Booking</p>
                    </a>
                    <a href="{{ route('admin.layanan.index') }}" class="bg-red-100 text-red-800 p-4 rounded-lg shadow hover:bg-red-200 text-center">
                        <p class="font-medium">Kelola Layanan</p>
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}" class="bg-purple-100 text-purple-800 p-4 rounded-lg shadow hover:bg-purple-200 text-center">
                        <p class="font-medium">Buat Pengumuman Baru</p>
                    </a>
                </div>
            </div>
        </div>

        {{-- =============================================== --}}
        {{-- <<< BAGIAN BARU: TABEL BOOKING TERBARU >>> --}}
        {{-- =============================================== --}}
        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Booking Perlu Dikonfirmasi</h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bookingsPerluKonfirmasi as $booking)
                                <tr>
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
                                                class="text-indigo-600 hover:text-indigo-900">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Tidak ada booking baru yang perlu dikonfirmasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- =============================================== --}}
        {{-- <<< BAGIAN BARU: MODAL POPUP DETAIL >>> --}}
        {{-- =============================================== --}}
        <div x-show="showModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                {{-- Latar belakang overlay --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

                {{-- Konten Modal --}}
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showModal" x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Detail Booking: <span x-text="selectedBooking ? selectedBooking.no_booking : ''"></span>
                                </h3>
                                <div class="mt-4 text-sm text-gray-600 space-y-3">
                                    <p><strong>Pemohon:</strong> <span x-text="selectedBooking ? selectedBooking.warga.nama_lengkap : ''"></span></p>
                                    <p><strong>NIK:</strong> <span x-text="selectedBooking ? selectedBooking.warga.nik : ''"></span></p>
                                    <p><strong>No. HP:</strong> <span x-text="selectedBooking ? selectedBooking.warga.no_hp : ''"></span></p>
                                    <hr>
                                    <p><strong>Layanan:</strong> <span x-text="selectedBooking ? selectedBooking.layanan.nama_layanan : ''"></span></p>
                                    <p><strong>Petugas:</strong> <span x-text="selectedBooking ? selectedBooking.petugas.nama_lengkap : ''"></span></p>
                                    <p><strong>Jadwal:</strong> <span x-text="selectedBooking ? new Date(selectedBooking.jadwal_janji_temu).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' }) : ''"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>