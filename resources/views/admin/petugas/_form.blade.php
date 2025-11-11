{{-- 
    File _form.blade.php
    Berisi semua field input untuk user/petugas.
    Variabel $petugas akan ada jika ini mode 'Edit', 
    dan tidak akan ada (null) jika mode 'Create'.
--}}

@csrf {{-- Token CSRF akan di-include dari form utama --}}

<div class="space-y-6">
    {{-- Nama Lengkap --}}
    <div>
        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-600">*</span></label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('nama_lengkap', $petugas->nama_lengkap ?? null) }}" required>
        @error('nama_lengkap') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Username --}}
    <div class="mt-4">
        <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-600">*</span></label>
        <input type="text" name="username" id="username" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('username', $petugas->username ?? null) }}" required>
        @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Email --}}
    <div class="mt-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-600">*</span></label>
        <input type="email" name="email" id="email" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('email', $petugas->email ?? null) }}" required>
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Jabatan (Opsional) --}}
    <div class="mt-4">
        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan (Opsional)</label>
        <input type="text" name="jabatan" id="jabatan" placeholder="Contoh: Staff Pelayanan, Kepala Seksi"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
               value="{{ old('jabatan', $petugas->jabatan ?? null) }}">
        @error('jabatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Role --}}
    <div class="mt-4">
        <label for="role" class="block text-sm font-medium text-gray-700">Role <span class="text-red-600">*</span></label>
        <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            <option value="">Pilih Role</option>
            @php $currentRole = old('role', $petugas->role ?? null); @endphp
            <option value="super_admin" @if($currentRole == 'super_admin') selected @endif>Super Admin</option>
            <option value="petugas_layanan" @if($currentRole == 'petugas_layanan') selected @endif>Petugas Layanan</option>
            <option value="pimpinan" @if($currentRole == 'pimpinan') selected @endif>Pimpinan</option>
        </select>
        @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Password (Hanya diisi jika membuat baru atau ingin mengubah password) --}}
    <div class="mt-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password 
            @if(isset($petugas)) <span class="text-gray-500 text-xs">(Biarkan kosong jika tidak ingin mengubah)</span> @else <span class="text-red-600">*</span> @endif
        </label>
        <input type="password" name="password" id="password" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Konfirmasi Password --}}
    <div class="mt-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password 
            @if(isset($petugas)) <span class="text-gray-500 text-xs">(Biarkan kosong jika tidak ingin mengubah)</span> @else <span class="text-red-600">*</span> @endif
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation" 
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>


    {{-- Tombol Aksi --}}
    <div class="flex justify-end space-x-4 border-t pt-4">
        <a href="{{ route('admin.petugas.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
            Batal
        </a>
        <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
            Simpan Petugas
        </button>
    </div>
</div>