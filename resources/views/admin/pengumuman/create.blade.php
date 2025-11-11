<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah Pengumuman Baru') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            {{-- Formulir ini harus memiliki enctype untuk file upload --}}
            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Memuat formulir partial. 
                     Variabel $pengumuman tidak didefinisikan, jadi form akan kosong. 
                --}}
                @include('admin.pengumuman._form')
                
            </form>
        </div>
    </div>
</x-admin-layout>