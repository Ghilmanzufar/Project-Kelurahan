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
                <form x-ref="formKonfirmasi" 
                      @submit.prevent="
                          confirmMessage = 'Apakah Anda yakin ingin MENGKONFIRMASI booking ini?'; 
                          formToSubmit = 'formKonfirmasi'; 
                          showConfirmModal = true;
                      "
                      :action="selectedBooking ? `{{ url('admin/booking') }}/${selectedBooking.id}/konfirmasi` : '#'" 
                      method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:w-auto sm:text-sm">
                        Konfirmasi
                    </button>
                </form>

                {{-- Tombol Tolak Janji --}}
                <form x-ref="formTolak" 
                      @submit.prevent="
                          confirmMessage = 'Apakah Anda yakin ingin MENOLAK booking ini?'; 
                          formToSubmit = 'formTolak'; 
                          showConfirmModal = true;
                      "
                      :action="selectedBooking ? `{{ url('admin/booking') }}/${selectedBooking.id}/tolak` : '#'" 
                      method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:w-auto sm:text-sm">
                        Tolak Janji
                    </button>
                </form>

                {{-- Tombol Tutup --}}
                <button type="button" @click="showModal = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>