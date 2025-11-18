<div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Filter & Cari Pengajuan</h3>
        <form action="{{ route('admin.pengajuan.index') }}" method="GET" class="mt-4">
            
            {{-- =============================================== --}}
            {{-- <<< SEARCH BAR BARU >>> --}}
            {{-- =============================================== --}}
            <div class="mb-4">
                <label for="search" class="block text-sm font-medium text-gray-700">Cari (No. Booking, NIK, Nama Pemohon)</label>
                <input type="text" name="search" id="search"
                       value="{{ request('search') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       placeholder="Masukkan No. Booking, NIK, or Nama Pemohon...">
            </div>

            {{-- Filter Dropdown yang sudah ada --}}
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
                        Cari / Filter
                    </button>
                    <a href="{{ route('admin.pengajuan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                        Reset
                    </a>
                    <a href="{{ route('admin.pengajuan.download_pdf', request()->query()) }}" 
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>