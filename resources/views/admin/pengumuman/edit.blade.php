<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Pengumuman') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            {{-- Formulir ini harus memiliki enctype untuk file upload --}}
            <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- Method spoofing untuk UPDATE --}}
                
                {{-- Memuat formulir partial dan mengirim data $pengumuman --}}
                @include('admin.pengumuman._form', ['pengumuman' => $pengumuman])
                
            </form>
        </div>
    </div>
</x-admin-layout>