<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Pengumuman') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Edit Pengumuman: {{ $pengumuman->judul }}</h3>
            
            {{-- Formulir ini harus memiliki enctype untuk file upload --}}
            <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                @method('PUT') {{-- Method spoofing untuk UPDATE --}}
                
                {{-- Memuat formulir partial dan mengirim data $pengumuman yang akan diedit --}}
                @include('admin.pengumuman._form', ['pengumuman' => $pengumuman])
                
            </form>
        </div>
    </div>
</x-admin-layout>