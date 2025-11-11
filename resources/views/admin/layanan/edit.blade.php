<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Layanan: ') }} {{ $layanan->nama_layanan }}
    </x-slot>

    <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Kirim data $layanan DAN data JSON ke partial form --}}
        @include('admin.layanan._form', [
            'layanan' => $layanan,
            'dokumenWajibJson' => $dokumenWajibJson,
            'alurProsesJson' => $alurProsesJson
        ])
        
    </form>
</x-admin-layout>