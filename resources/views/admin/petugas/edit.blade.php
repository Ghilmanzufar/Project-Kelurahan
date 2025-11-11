<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Petugas') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.petugas.update', $petugas->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing untuk UPDATE --}}
                
                {{-- Memuat formulir partial dan mengirim data $petugas --}}
                @include('admin.petugas._form', ['petugas' => $petugas])
                
            </form>
        </div>
    </div>
</x-admin-layout>