{{-- 
    File ini akan di-include oleh create.blade.php dan edit.blade.php
    Kita akan menggunakan Alpine.js untuk mengelola input dinamis
--}}

{{-- 
    Variabel $layananData diinisialisasi di sini untuk membersihkan logika di dalam x-data.
    Ini akan berisi data lama (untuk 'Edit') atau data kosong (untuk 'Create').
--}}
@php
    $layananData = $layanan ?? null; // Ambil $layanan jika ada (mode Edit)

    // Siapkan data untuk Alpine, pastikan selalu ada 1 baris kosong jika data tidak ada
    $dokumenWajibJson = (isset($layananData) && $layananData->dokumenWajib->count() > 0)
        ? $layananData->dokumenWajib->map(fn($d) => ['deskripsi' => $d->deskripsi_dokumen])
        : [['deskripsi' => '']];

    $alurProsesJson = (isset($layananData) && $layananData->alurProses->count() > 0)
        ? $layananData->alurProses->map(fn($a) => ['deskripsi' => $a->deskripsi_alur])
        : [['deskripsi' => '']];
@endphp

<div>

    @csrf {{-- Token CSRF akan di-include dari form utama --}}

    <div class="space-y-6">
        {{-- Bagian Informasi Dasar Layanan --}}
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Informasi Dasar Layanan</h3>
            
            {{-- Nama Layanan --}}
            <div>
                <label for="nama_layanan" class="block text-sm font-medium text-gray-700">Nama Layanan <span class="text-red-600">*</span></label>
                <input type="text" name="nama_layanan" id="nama_layanan" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       value="{{ old('nama_layanan', $layanan->nama_layanan ?? '') }}" required>
                @error('nama_layanan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mt-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Singkat <span class="text-red-600">*</span></label>
                <textarea name="deskripsi" id="deskripsi" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                          required>{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
                @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Grid untuk Estimasi, Biaya, Dasar Hukum --}}
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="estimasi_proses" class="block text-sm font-medium text-gray-700">Estimasi Proses <span class="text-red-600">*</span></label>
                    <input type="text" name="estimasi_proses" id="estimasi_proses" placeholder="Contoh: 1-2 Hari Kerja"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           value="{{ old('estimasi_proses', $layanan->estimasi_proses ?? '') }}" required>
                    @error('estimasi_proses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="biaya" class="block text-sm font-medium text-gray-700">Biaya <span class="text-red-600">*</span></label>
                    <input type="text" name="biaya" id="biaya" placeholder="Contoh: Rp 0,- (Gratis)"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           value="{{ old('biaya', $layanan->biaya ?? '') }}" required>
                    @error('biaya') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="dasar_hukum" class="block text-sm font-medium text-gray-700">Dasar Hukum <span class="text-red-600">*</span></label>
                    <input type="text" name="dasar_hukum" id="dasar_hukum" placeholder="Contoh: PP No. 24 Tahun 1997"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           value="{{ old('dasar_hukum', $layanan->dasar_hukum ?? '') }}" required>
                    @error('dasar_hukum') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="mt-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-600">*</span></label>
                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <option value="aktif" @if(old('status', $layanan->status ?? '') == 'aktif') selected @endif>Aktif</option>
                    <option value="tidak_aktif" @if(old('status', $layanan->status ?? '') == 'tidak_aktif') selected @endif>Tidak Aktif</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Bagian Dokumen Wajib (Dinamis) --}}
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Dokumen Wajib Dibawa</h3>
            <template x-for="(dokumen, index) in dokumenWajib" :key="index">
                <div class="flex items-center space-x-2 mb-2">
                    <input type="text" :name="`dokumen_wajib[${index}]`" x-model="dokumen.deskripsi" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Contoh: Fotokopi KTP Pemohon" required>
                    <button type="button" @click="removeDokumen(index)" 
                            class="p-2 bg-red-600 text-white rounded-md hover:bg-red-700" 
                            :disabled="dokumenWajib.length <= 1">
                        X
                    </button>
                </div>
            </template>
            @error('dokumen_wajib.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @error('dokumen_wajib') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror


            <button type="button" @click="addDokumen()" 
                    class="mt-2 inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                + Tambah Dokumen
            </button>
        </div>

        {{-- Bagian Alur Proses (Dinamis) --}}
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Alur Proses Pengurusan</h3>
            <template x-for="(alur, index) in alurProses" :key="index">
                <div class="flex items-center space-x-2 mb-2">
                    <input type="text" :name="`alur_proses[${index}]`" x-model="alur.deskripsi" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Contoh: Pemohon datang ke loket" required>
                    <button type="button" @click="removeAlur(index)" 
                            class="p-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                            :disabled="alurProses.length <= 1">
                        X
                    </button>
                </div>
            </template>
            @error('alur_proses.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @error('alur_proses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <button type="button" @click="addAlur()" 
                    class="mt-2 inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                + Tambah Alur
            </button>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.layanan.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                Simpan Layanan
            </button>
        </div>
    </div>
</div>