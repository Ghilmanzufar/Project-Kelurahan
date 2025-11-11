<x-admin-layout>
    <x-slot name="header">
        {{ __('Manajemen Booking (Menunggu Konfirmasi)') }}
    </x-slot>

    {{-- =============================================== --}}
    {{-- <<< FORM FILTER YANG DIPERBARUI >>> --}}
    {{-- =============================================== --}}
    <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Filter Booking</h3>
            <form action="{{ route('admin.booking.index') }}" method="GET" class="mt-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4"> {{-- Ubah grid jadi 5 kolom --}}
                    
                    {{-- Filter Tanggal Janji Temu (BARU) --}}
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

                    {{-- Filter Urutkan (BARU) --}}
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

    {{-- Alpine.js data untuk modal --}}
    <div x-data="{ showModal: false, selectedBooking: null }">

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
        {{-- <<< MODAL POPUP DETAIL (SESUAI MOCKUP ANDA) >>> --}}
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
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                    
                    <div class="bg-blue-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Detail Booking (No. <span x-text="selectedBooking ? selectedBooking.no_booking : ''"></span>)
                        </h3>

                    </div>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        {{-- Data Janji Temu --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Data Janji Temu:</h4>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                            <div><strong>Layanan:</strong></div>
                            <div x-text="selectedBooking ? selectedBooking.layanan.nama_layanan : ''"></div>
                            
                            <div><strong>Petugas:</strong></div>
                            <div x-text="selectedBooking ? selectedBooking.petugas.nama_lengkap : ''"></div>
                            
                            <div><strong>Waktu:</strong></div>
                            <div x-text="selectedBooking ? new Date(selectedBooking.jadwal_janji_temu).toLocaleString('id-ID', { dateStyle: 'full', timeStyle: 'short' }) : ''"></div>
                            
                            <div><strong>Status:</strong></div>
                            <div>
                                <span x-text="selectedBooking ? selectedBooking.status_berkas : ''" 
                                      :class="{
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                                        'bg-blue-100 text-blue-800': selectedBooking && selectedBooking.status_berkas === 'JANJI TEMU DIBUAT',
                                        'bg-green-100 text-green-800': selectedBooking && selectedBooking.status_berkas === 'JANJI TEMU DIKONFIRMASI',
                                        'bg-red-100 text-red-800': selectedBooking && selectedBooking.status_berkas === 'DITOLAK'
                                      }">
                                </span>
                            </div>
                        </div>

                        {{-- Data Diri Pemohon --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-6 mb-3">Data Diri Pemohon:</h4>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                            <div><strong>Nama Lengkap:</strong></div>
                            <div x-text="selectedBooking ? selectedBooking.warga.nama_lengkap : ''"></div>

                            <div><strong>NIK:</strong></div>
                            <div x-text="selectedBooking ? selectedBooking.warga.nik : ''"></div>

                            <div><strong>No. HP/WA:</strong></div>
                            <div x-text="selectedBooking ? selectedBooking.warga.no_hp : ''"></div>

                            <div><strong>Email:</strong></div>
                            <div x-text="selectedBooking ? selectedBooking.warga.email : ''"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row justify-end gap-3">
                        {{-- Tombol Konfirmasi --}}
                        <form x-data @submit.prevent="if (confirm('Apakah Anda yakin ingin mengkonfirmasi booking ini?')) $el.submit()"
                              :action="selectedBooking ? `{{ url('admin/booking') }}/${selectedBooking.id}/konfirmasi` : '#'" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:w-auto sm:text-sm">
                                Konfirmasi
                            </button>
                        </form>

                        {{-- Tombol Tolak Janji --}}
                        <form x-data @submit.prevent="if (confirm('Apakah Anda yakin ingin menolak booking ini?')) $el.submit()"
                              :action="selectedBooking ? `{{ url('admin/booking') }}/${selectedBooking.id}/tolak` : '#'" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                Tolak Janji
                            </button>
                        </form>

                        {{-- Tombol Tutup --}}
                        <button type="button" @click="showModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>