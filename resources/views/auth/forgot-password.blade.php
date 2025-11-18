<x-guest-layout>
    {{-- Logo / Ikon Kunci (Opsional, untuk estetika) --}}
    <div class="mb-6 flex justify-center">
        <div class="h-16 w-16 bg-primary-100 rounded-full flex items-center justify-center">
            <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
            </svg>
        </div>
    </div>

    <h2 class="mb-4 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
        Lupa Kata Sandi?
    </h2>

    {{-- PESAN YANG ANDA MINTA UNTUK DIUBAH --}}
    <div class="mb-8 text-sm text-gray-600 text-center">
        {{ __('Jika Anda lupa kata sandi akun petugas Anda, silakan masukkan alamat email yang terdaftar. Sistem akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.') }}
        <br><br>
        <span class="font-medium text-primary-700">
            {{ __('Atau hubungi Super Admin jika Anda mengalami kendala teknis.') }}
        </span>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Alamat Email Terdaftar')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="contoh: petugas@kel-klender.go.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center bg-primary-600 hover:bg-primary-700">
                {{ __('Kirim Tautan Reset Password') }}
            </x-primary-button>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-primary-600 hover:text-primary-500">
                &larr; Kembali ke Halaman Login
            </a>
        </div>
    </form>
</x-guest-layout>