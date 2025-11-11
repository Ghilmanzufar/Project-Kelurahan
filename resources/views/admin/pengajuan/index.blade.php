<x-admin-layout>
    <x-slot name="header">
        {{ __('Manajemen Pengajuan Berkas') }}
    </x-slot>

    {{-- Alpine.js data untuk modal --}}
    {{-- showUpdateStatusModal: mengontrol modal update status --}}
    {{-- selectedBooking: objek booking yang dipilih untuk di-update --}}
    <div x-data="{ showUpdateStatusModal: false, selectedBooking: null, newStatus: '', newDeskripsi: '' }">

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

        {{-- =============================================== --}}
        {{-- <<< FORM FILTER (SAMA DENGAN MANAJEMEN BOOKING) >>> --}}
        {{-- =============================================== --}}
        <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Filter Pengajuan Berkas</h3>
                <form action="{{ route('admin.pengajuan.index') }}" method="GET" class="mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- Filter Status --}}
                        <div>
                            <label for="status_berkas" class="block text-sm font-medium text-gray-700">Status Berkas</label>
                            <select id="status_berkas" name="status_berkas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Semua Status (Default: Sedang Diproses)</option>
                                @foreach ($allStatus as $status)
                                    <option value="{{ $status }}" @if(request('status_berkas') == $status) selected @endif>
                                        {{ Str::title(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
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

                        {{-- Tombol Filter --}}
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Filter
                            </button>
                            <a href="{{ route('admin.pengajuan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- =============================================== --}}
        {{-- <<< TABEL DAFTAR PENGAJUAN BERKAS >>> --}}
        {{-- =============================================== --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Daftar Pengajuan Berkas</h3>
                <p class="mt-2 text-gray-600">Berikut adalah daftar berkas yang sedang dalam proses atau telah selesai.</p>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Booking</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Terakhir</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($pengajuanBerkas as $booking)
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
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($booking->status_berkas == 'JANJI TEMU DIKONFIRMASI') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status_berkas == 'BERKAS DITERIMA') bg-blue-100 text-blue-800
                                            @elseif($booking->status_berkas == 'VERIFIKASI BERKAS') bg-indigo-100 text-indigo-800
                                            @elseif($booking->status_berkas == 'SEDANG DIPROSES') bg-purple-100 text-purple-800
                                            @elseif($booking->status_berkas == 'SELESAI') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            {{ Str::title(str_replace('_', ' ', $booking->status_berkas)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="selectedBooking = {{ $booking->toJson() }}; showUpdateStatusModal = true; newStatus = selectedBooking.status_berkas; newDeskripsi = ''"
                                                class="text-blue-600 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md">
                                            Update Status / Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Tidak ada pengajuan berkas yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                <div class="mt-4">
                    {{ $pengajuanBerkas->links() }}
                </div>
            </div>
        </div>

        {{-- =============================================== --}}
        {{-- <<< MODAL "UPDATE STATUS" (BELUM LENGKAP) >>> --}}
        {{-- Ini akan dibuat di Langkah 3. Saat ini hanya kerangka. --}}
        {{-- =============================================== --}}
        <div x-show="showUpdateStatusModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showUpdateStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showUpdateStatusModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showUpdateStatusModal" x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    
                    <div class="bg-blue-600 px-4 py-3 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Update Status Pengajuan Berkas (No. <span x-text="selectedBooking ? selectedBooking.no_booking : ''"></span>)
                        </h3>
                    </div>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        {{-- Data Dasar Booking --}}
                        <div class="border-b pb-2 mb-4">
                            <h4 class="text-md font-semibold text-gray-800">Detail Booking:</h4>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-sm text-gray-700 mt-2">
                                <div><strong>Pemohon:</strong> <span x-text="selectedBooking ? selectedBooking.warga.nama_lengkap : ''"></span></div>
                                <div><strong>Layanan:</strong> <span x-text="selectedBooking ? selectedBooking.layanan.nama_layanan : ''"></span></div>
                                <div><strong>Jadwal:</strong> <span x-text="selectedBooking ? new Date(selectedBooking.jadwal_janji_temu).toLocaleString('id-ID', { dateStyle: 'long', timeStyle: 'short' }) : ''"></span></div>
                                <div><strong>Status Terkini:</strong> 
                                    <span x-text="selectedBooking ? selectedBooking.status_berkas : ''" 
                                          :class="{
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                                            'bg-yellow-100 text-yellow-800': selectedBooking && selectedBooking.status_berkas === 'JANJI TEMU DIKONFIRMASI',
                                            'bg-blue-100 text-blue-800': selectedBooking && selectedBooking.status_berkas === 'BERKAS DITERIMA',
                                            'bg-indigo-100 text-indigo-800': selectedBooking && selectedBooking.status_berkas === 'VERIFIKASI BERKAS',
                                            'bg-purple-100 text-purple-800': selectedBooking && selectedBooking.status_berkas === 'SEDANG DIPROSES',
                                            'bg-green-100 text-green-800': selectedBooking && selectedBooking.status_berkas === 'SELESAI',
                                            'bg-red-100 text-red-800': selectedBooking && selectedBooking.status_berkas === 'DITOLAK'
                                          }">
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Riwayat Log Status --}}
                        <h4 class="text-md font-semibold text-gray-800 mt-4">Riwayat Perubahan Status:</h4>
                        <div class="mt-2 space-y-2 max-h-48 overflow-y-auto border p-2 rounded-md bg-gray-50">
                            <template x-if="selectedBooking && selectedBooking.status_logs && selectedBooking.status_logs.length > 0">
                                <template x-for="log in selectedBooking.status_logs" :key="log.id">
                                    <div class="text-sm border-l-2 pl-3" 
                                         :class="{
                                            'border-yellow-500': log.status === 'JANJI TEMU DIKONFIRMASI',
                                            'border-blue-500': log.status === 'BERKAS DITERIMA',
                                            'border-indigo-500': log.status === 'VERIFIKASI BERKAS',
                                            'border-purple-500': log.status === 'SEDANG DIPROSES',
                                            'border-green-500': log.status === 'SELESAI',
                                            'border-red-500': log.status === 'DITOLAK'
                                         }">
                                        <p class="font-medium text-gray-900" x-text="log.status"></p>
                                        <p class="text-gray-700" x-text="log.deskripsi"></p>
                                        <p class="text-xs text-gray-500">
                                            <span x-text="new Date(log.created_at).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short' })"></span> 
                                            oleh <span x-text="log.petugas ? log.petugas.nama_lengkap : 'Sistem'"></span>
                                        </p>
                                    </div>
                                </template>
                            </template>
                            <template x-if="!selectedBooking || !selectedBooking.status_logs || selectedBooking.status_logs.length === 0">
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat status.</p>
                            </template>
                        </div>

                        {{-- Form Update Status --}}
                        <h4 class="text-md font-semibold text-gray-800 mt-6 border-b pb-2 mb-3">Perbarui Status:</h4>
                        <form x-data @submit.prevent="if (confirm('Apakah Anda yakin ingin memperbarui status ini?')) $el.submit()"
                              :action="selectedBooking ? `{{ url('admin/pengajuan-berkas') }}/${selectedBooking.id}/update-status` : '#'" 
                              method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="status_baru" class="block text-sm font-medium text-gray-700">Pilih Status Baru</label>
                                    <select x-model="newStatus" id="status_baru" name="status_baru" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="" disabled>Pilih Status</option>
                                        {{-- Filter status agar tidak bisa kembali ke JANJI TEMU DIBUAT atau DITOLAK --}}
                                        <template x-for="status in {{ json_encode(array_filter($allStatus, function($s) {
                                            return !in_array($s, ['JANJI TEMU DIBUAT', 'DITOLAK']);
                                        })) }}" :key="status">
                                            <option :value="status" x-text="status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())"></option>
                                        </template>
                                    </select>
                                </div>
                                <div>
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Catatan/Deskripsi (akan terlihat oleh warga)</label>
                                    <textarea x-model="newDeskripsi" id="deskripsi" name="deskripsi" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                              placeholder="Contoh: Berkas diterima di loket 1, Menunggu verifikasi petugas..."></textarea>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan Perubahan Status
                                </button>
                                <button type="button" @click="showUpdateStatusModal = false"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</x-admin-layout>