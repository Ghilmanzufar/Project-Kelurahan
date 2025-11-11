<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah Layanan Baru') }}
    </x-slot>

    <form action="{{ route('admin.layanan.store') }}" method="POST">
        @csrf
        
        {{-- Kirim data JSON kosong ke partial form --}}
        @include('admin.layanan._form', [
            'dokumenWajibJson' => $dokumenWajibJson,
            'alurProsesJson' => $alurProsesJson
        ])
        
    </form>
</x-admin-layout>