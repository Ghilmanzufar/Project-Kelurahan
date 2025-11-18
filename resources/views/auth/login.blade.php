<x-guest-layout>
    {{-- 
        Kita override slot 'logo' di x-guest-layout (jika ada) atau 
        langsung buat desain custom di sini. 
        
        Asumsi: x-guest-layout adalah wrapper sederhana. 
        Kita akan styling ulang konten di dalamnya.
    --}}

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            {{-- Logo / Ikon --}}
            <div class="mx-auto h-20 w-20 bg-primary-100 rounded-full flex items-center justify-center shadow-md">
                <svg class="h-12 w-12 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>
            
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Login Petugas
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Sistem Informasi Pelayanan Pertanahan<br>
                Kelurahan Klender
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    <div class="mt-2">
                        <input id="username" name="username" type="text" autocomplete="username" required autofocus 
                               value="{{ old('username') }}"
                               class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-600 sm:text-sm sm:leading-6">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>
                
                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-semibold text-primary-600 hover:text-primary-500">Lupa password?</a>
                        </div>
                    @endif
                </div>

                {{-- Tombol Login --}}
                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-primary-600 px-3 py-2.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 transition-colors">
                        Masuk ke Dashboard
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Bukan petugas?
                <a href="{{ route('beranda') }}" class="font-semibold leading-6 text-primary-600 hover:text-primary-500">Kembali ke Halaman Utama</a>
            </p>
        </div>
    </div>
</x-guest-layout>