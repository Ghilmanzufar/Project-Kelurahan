{{-- 
    File: _form.blade.php
    Berisi semua field input.
    Variabel $pengumuman akan ada (bisa kosong atau terisi)
--}}

<div class="space-y-6">
    {{-- Judul --}}
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengumuman <span class="text-red-600">*</span></label>
        <input type="text" name="judul" id="judul" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('judul', $pengumuman->judul) }}" required>
        @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Grid untuk Kategori, Tanggal, Status --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Kategori --}}
        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-600">*</span></label>
            <input type="text" name="kategori" id="kategori" placeholder="Contoh: Kebijakan, Kesehatan, Acara"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   value="{{ old('kategori', $pengumuman->kategori) }}" required>
            @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Tanggal Publikasi --}}
        <div>
            <label for="tanggal_publikasi" class="block text-sm font-medium text-gray-700">Tanggal Publikasi <span class="text-red-600">*</span></label>
            <input type="date" name="tanggal_publikasi" id="tanggal_publikasi"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   value="{{ old('tanggal_publikasi', $pengumuman->tanggal_publikasi ? $pengumuman->tanggal_publikasi->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
            @error('tanggal_publikasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-600">*</span></label>
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @php $status = old('status', $pengumuman->status ?? 'draft'); @endphp
                <option value="aktif" @if($status == 'aktif') selected @endif>Aktif (Publikasikan)</option>
                <option value="draft" @if($status == 'draft') selected @endif>Draft (Simpan sebagai draf)</option>
                <option value="tidak_aktif" @if($status == 'tidak_aktif') selected @endif>Tidak Aktif (Arsipkan)</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- <<< INPUT GAMBAR BARU >>> --}}
    {{-- =============================================== --}}
    <div class="mt-4">
        <label for="featured_image" class="block text-sm font-medium text-gray-700">Gambar Utama (Featured Image)</label>
        <input type="file" name="featured_image" id="featured_image" accept="image/jpeg,image/png,image/jpg"
               class="mt-1 block w-full text-sm text-gray-500 ...">
        @error('featured_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        
        @if($pengumuman->featured_image)
            <div class="mt-2">
                <p class="text-sm text-gray-500">Gambar saat ini:</p>
                <img src="{{ Storage::url($pengumuman->featured_image) }}" alt="Gambar Utama" class="mt-2 h-32 w-auto rounded-md shadow-sm">
                
                {{-- <<< TAMBAHKAN CHECKBOX INI >>> --}}
                <div class="mt-2 flex items-center">
                    <input type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <label for="hapus_gambar" class="ml-2 block text-sm text-red-700 font-medium">Hapus gambar ini saat disimpan</label>
                </div>
            </div>
        @endif
    </div>

    {{-- =============================================== --}}
    {{-- <<< IMPLEMENTASI TRIX EDITOR >>> --}}
    {{-- =============================================== --}}
    <div class="mt-4">
        <label for="isi_konten_trix" class="block text-sm font-medium text-gray-700">Isi Konten <span class="text-red-600">*</span></label>
        {{-- Input tersembunyi yang akan menyimpan HTML dari Trix --}}
        <input id="isi_konten_trix" type="hidden" name="isi_konten" value="{{ old('isi_konten', $pengumuman->isi_konten) }}">
        
        {{-- Trix Editor yang terhubung ke input tersembunyi --}}
        <trix-editor input="isi_konten_trix" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 trix-content"></trix-editor>
        
        <p class="mt-2 text-xs text-gray-500">Gunakan tombol di atas untuk memformat teks (Bold, Italic, List, dll).</p>
        @error('isi_konten') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>
    
    {{-- File PDF (Opsional) --}}
    <div class="mt-4">
        <label for="file_pdf_path" class="block text-sm font-medium text-gray-700">Lampirkan File PDF (Opsional)</label>
        <input type="file" name="file_pdf_path" id="file_pdf_path" accept=".pdf"
               class="mt-1 block w-full text-sm text-gray-500 ...">
        @if ($pengumuman->file_pdf_path)
            <p class="mt-2 text-sm text-gray-500">File PDF saat ini: 
                <a href="{{ Storage::url($pengumuman->file_pdf_path) }}" target="_blank" class="text-blue-600 hover:underline">
                    Lihat PDF
                </a>
            </p>
            
            {{-- <<< TAMBAHKAN CHECKBOX INI >>> --}}
            <div class="mt-2 flex items-center">
                <input type="checkbox" name="hapus_pdf" id="hapus_pdf" value="1" class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                <label for="hapus_pdf" class="ml-2 block text-sm text-red-700 font-medium">Hapus file PDF ini saat disimpan</label>
            </div>
        @endif
        @error('file_pdf_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end space-x-4 border-t pt-6 mt-6">
        <a href="{{ route('admin.pengumuman.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
            Batal
        </a>
        <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
            Simpan Pengumuman
        </button>
    </div>
</div>

{{-- CSS Kustom untuk Trix agar menyatu dengan form Tailwind --}}
@push('styles')
<style>
    .trix-content {
        min-height: 200px; /* Atur tinggi minimal editor */
        background-color: white;
    }
    /* Menyesuaikan toolbar Trix agar tidak terlalu besar */
    trix-toolbar .trix-button-group {
        margin-bottom: 0.5rem;
    }
    trix-toolbar .trix-button {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

{{-- 
    PENTING: Kita perlu @push('styles') 
    Pastikan layout admin Anda (<x-admin-layout>) memiliki @stack('styles') di dalam <head>
--}}