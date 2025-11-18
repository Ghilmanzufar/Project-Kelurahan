<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Data Warga') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            {{-- Form untuk mengupdate data warga --}}
            <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing untuk UPDATE --}}
                
                <div class="space-y-6">
                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK <span class="text-red-600">*</span></label>
                        <input type="text" name="nik" id="nik" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               value="{{ old('nik', $warga->nik) }}" required>
                        @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="mt-4">
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-600">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               value="{{ old('nama_lengkap', $warga->nama_lengkap) }}" required>
                        @error('nama_lengkap') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="mt-4">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-600">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               value="{{ old('tanggal_lahir', $warga->tanggal_lahir ? $warga->tanggal_lahir->format('Y-m-d') : '') }}" required>
                        @error('tanggal_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="mt-4">
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP <span class="text-red-600">*</span></label>
                        <input type="text" name="no_hp" id="no_hp" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               value="{{ old('no_hp', $warga->no_hp) }}" required>
                        @error('no_hp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email (Opsional)</label>
                        <input type="email" name="email" id="email" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               value="{{ old('email', $warga->email) }}">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mt-4">
                        <label for="alamat_terakhir" class="block text-sm font-medium text-gray-700">Alamat (Opsional)</label>
                        <textarea name="alamat_terakhir" id="alamat_terakhir" rows="3"
                                  class="mt-1 block w-full ...">{{ old('alamat_terakhir', $warga->alamat_terakhir) }}</textarea>
                        @error('alamat_terakhir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-4 border-t pt-4">
                        <a href="{{ route('admin.warga.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>