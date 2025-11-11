{{-- 
    File _form.blade.php
    Berisi semua field input.
    Variabel $pengumuman akan ada jika ini mode 'Edit', 
    dan tidak akan ada (null) jika mode 'Create'.
--}}

@csrf {{-- Token CSRF akan di-include dari form utama --}}

<div class="space-y-6">
    {{-- Judul --}}
    <div>
        <label for="judul" class="block text-sm font-medium text-gray-700">Judul Pengumuman <span class="text-red-600">*</span></label>
        <input type="text" name="judul" id="judul" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('judul', $pengumuman->judul ?? null) }}" required>
        @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Grid untuk Kategori, Tanggal, Status --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Kategori --}}
        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-600">*</span></label>
            <input type="text" name="kategori" id="kategori" placeholder="Contoh: Kebijakan, Kesehatan, Acara"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   value="{{ old('kategori', $pengumuman->kategori ?? null) }}" required>
            @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Tanggal Publikasi --}}
        <div>
            <label for="tanggal_publikasi" class="block text-sm font-medium text-gray-700">Tanggal Publikasi <span class="text-red-600">*</span></label>
            <input type="date" name="tanggal_publikasi" id="tanggal_publikasi"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   value="{{ old('tanggal_publikasi', (isset($pengumuman) && $pengumuman->tanggal_publikasi) ? $pengumuman->tanggal_publikasi->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
            @error('tanggal_publikasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-600">*</span></label>
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                @php $status = old('status', $pengumuman->status ?? 'aktif'); @endphp
                <option value="aktif" @if($status == 'aktif') selected @endif>Aktif (Publikasikan)</option>
                <option value="draft" @if($status == 'draft') selected @endif>Draft (Simpan sebagai draf)</option>
                <option value="tidak_aktif" @if($status == 'tidak_aktif') selected @endif>Tidak Aktif (Arsipkan)</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Isi Konten --}}
    <div>
        <label for="isi_konten" class="block text-sm font-medium text-gray-700">Isi Konten <span class="text-red-600">*</span></label>
        <textarea name="isi_konten" id="isi_konten" rows="10" 
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  placeholder="Anda bisa memasukkan kode HTML di sini untuk format tabel, paragraf, dll."
                  required>{{ old('isi_konten', $pengumuman->isi_konten ?? null) }}</textarea>
        <p class="mt-2 text-xs text-gray-500">Tips: Gunakan tag HTML seperti `<p>`, `<strong>`, `<ul>`, `<li>`, `<table>` untuk format.</p>
        @error('isi_konten') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- File PDF (Opsional) --}}
    <div>
        <label for="file_pdf_path" class="block text-sm font-medium text-gray-700">Unggah Dokumen PDF (Opsional)</label>
        <input type="file" name="file_pdf_path" id="file_pdf_path" 
               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        @if (isset($pengumuman) && $pengumuman->file_pdf_path)
            <p class="mt-2 text-sm text-gray-500">File saat ini: <a href="{{ Storage::url($pengumuman->file_pdf_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat PDF</a></p>
        @endif
        @error('file_pdf_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end space-x-4 border-t pt-4">
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