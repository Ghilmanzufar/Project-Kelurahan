<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah Petugas Baru') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.petugas.store') }}" method="POST">
                @csrf
                
                {{-- Memuat formulir partial. 
                     Variabel $petugas tidak didefinisikan, jadi form akan kosong. 
                --}}
                @include('admin.petugas._form')
                
            </form>
        </div>
    </div>
</x-admin-layout>