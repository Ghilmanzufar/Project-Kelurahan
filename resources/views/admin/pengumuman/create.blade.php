<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah Pengumuman Baru') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Formulir Pengumuman Baru</h3>

            {{-- Formulir ini harus memiliki enctype untuk file upload --}}
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                
                {{-- Memuat formulir partial. 
                     Variabel $pengumuman yang dikirim adalah instance KOSONG, 
                     sehingga $pengumuman->judul akan kosong.
                --}}
                @include('admin.pengumuman._form', ['pengumuman' => $pengumuman])
                
            </form>
        </div>
    </div>
</x-admin-layout>