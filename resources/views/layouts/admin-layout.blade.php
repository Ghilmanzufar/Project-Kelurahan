<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    {{-- 
        PERUBAHAN 1: x-data sekarang memiliki 2 state:
        - sidebarOpen: untuk slide-menu di MOBILE
        - isSidebarMinimized: untuk minimize/collapse di DESKTOP
    --}}
    <div x-data="{ sidebarOpen: false, isSidebarMinimized: false }" class="flex h-screen bg-gray-200">

        <div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-gray-900 opacity-50 lg:hidden" @click="sidebarOpen = false" x-transition:opacity></div>

        {{-- ================== SIDEBAR ================== --}}
        {{-- 
            PERUBAHAN 2: 
            - Sidebar sekarang 'fixed' di desktop (lg:fixed)
            - 'width' dikontrol oleh 'isSidebarMinimized' (lg:w-64 atau lg:w-20)
            - 'translate' dikontrol oleh 'sidebarOpen' (Hanya untuk mobile)
        --}}
        <div class="fixed z-40 inset-y-0 left-0 bg-gray-800 overflow-y-auto transform transition-all duration-300
                    lg:fixed lg:inset-0"
             :class="{
                'translate-x-0 w-64': sidebarOpen,      // Mobile: Terbuka
                '-translate-x-full w-64': !sidebarOpen, // Mobile: Tertutup
                'lg:w-64': !isSidebarMinimized,         // Desktop: Normal
                'lg:w-20': isSidebarMinimized,          // Desktop: Minimize
                'lg:translate-x-0': true                // Selalu terlihat di desktop
             }">
            
            {{-- Logo & Tombol Toggle --}}
            <div class="flex items-center justify-between h-16 bg-gray-900 text-white px-4">
                {{-- Judul (hanya terlihat jika tidak minimize) --}}
                <span x-show="!isSidebarMinimized" class="text-xl font-semibold">Admin Panel</span>
                
                {{-- Tombol Toggle (Hanya Desktop) --}}
                <button @click="isSidebarMinimized = !isSidebarMinimized" class="hidden lg:block text-gray-400 hover:text-white focus:outline-none">
                    <svg x-show="!isSidebarMinimized" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <svg x-show="isSidebarMinimized" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Tombol Tutup (Hanya Mobile) --}}
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Navigasi Sidebar --}}
            <nav class="mt-10">
                {{-- 1. Dashboard (Bisa dilihat semua role admin) --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                   {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}"
                   :class="isSidebarMinimized ? 'justify-center' : ''">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="ml-3" x-show="!isSidebarMinimized">Dashboard</span>
                </a>
                
                {{-- 2. Gate 'kelola-berkas' (Hanya Super Admin & Petugas Layanan) --}}
                @can('kelola-berkas')
                    <a href="{{ route('admin.booking.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.booking.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Manajemen Booking</span>
                    </a>

                    <a href="{{ route('admin.pengajuan.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.pengajuan.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Pengajuan Berkas</span>
                    </a>

                    <a href="{{ route('admin.warga.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.warga.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.37M16 13A4 4 0 118 5a4 4 0 018 0zM4 20v-2a3 3 0 015.356-2.37m-5.356 2.37H2v-2a3 3 0 013-3h12a3 3 0 013 3v2z" />
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Data Warga</span>
                    </a>
                @endcan
                
                {{-- 3. Gate 'kelola-konten' (Hanya Super Admin & Petugas Layanan) --}}
                @can('kelola-konten')
                    <a href="{{ route('admin.pengumuman.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.pengumuman.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Manajemen Pengumuman</span>
                    </a>
                @endcan

                {{-- 4. Gate 'kelola-sistem' (HANYA Super Admin) --}}
                @can('kelola-sistem')
                    <a href="{{ route('admin.layanan.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.layanan.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v2a2 2 0 01-2 2h-5m-9 0a2 2 0 01-2-2v-2a2 2 0 012-2h5m-9 0a2 2 0 00-2 2v2a2 2 0 002 2h5m-5 0h5"/>
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Kelola Layanan</span>
                    </a>

                    <a href="{{ route('admin.petugas.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.petugas.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Kelola Petugas</span>
                    </a>

                @endcan

                {{-- 5. Gate 'lihat-laporan' (Hanya Super Admin & Pimpinan) --}}
                @can('lihat-laporan')
                    <a href="{{ route('admin.laporan.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.laporan.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z"/>
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Laporan</span>
                    </a>
                @endcan

                {{-- 6. Manajemen Pesan Kontak (Bisa dilihat semua role admin) --}}
                @can('kelola-konten')
                    {{-- LINK BARU: PESAN MASUK --}}
                    <a href="{{ route('admin.pesan.index') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.pesan.*') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Kotak Masuk</span>
                    </a>
                @endcan
            </nav>
        </div>

        {{-- ================== KONTEN UTAMA ================== --}}
        {{-- 
            PERUBAHAN 4: 
            - Div ini sekarang memiliki padding-left (lg:pl-xx) yang dinamis
              tergantung state 'isSidebarMinimized'
        --}}
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300"
             :class="{
                'lg:pl-64': !isSidebarMinimized, // Padding untuk sidebar normal
                'lg:pl-20': isSidebarMinimized     // Padding untuk sidebar minimize
             }">
            
            {{-- Header (Top Bar) --}}
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-blue-600">
                <div class="flex items-center">
                    <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 6H20M4 12H20M4 18H20"></path>
                        </svg>
                    </button>
                    
                    {{-- Judul Halaman (Slot) --}}
                    <h1 class="text-xl font-semibold text-gray-800 ml-4 lg:ml-0">
                        {{ $header ?? 'Admin Dashboard' }}
                    </h1>
                </div>

                {{-- User Dropdown --}}
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = ! dropdownOpen"
                            class="relative flex items-center h-8 overflow-hidden focus:outline-none">
                        <span class="mr-3 text-sm text-gray-700 hidden sm:inline">{{ Auth::user()->nama_lengkap }}</span>
                        <img class="h-8 w-8 rounded-full object-cover"
                             src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&color=7F9CF5&background=EBF4FF"
                             alt="{{ Auth::user()->nama_lengkap }}">
                    </button>

                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full" style="display: none;"></div>

                    <div x-show="dropdownOpen"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-20"
                         style="display: none;">
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            </header>

            {{-- Slot Konten Utama --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>