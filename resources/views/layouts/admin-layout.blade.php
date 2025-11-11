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
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">

        <div x-show="sidebarOpen" class="fixed inset-0 z-30 bg-gray-900 opacity-50 lg:hidden" @click="sidebarOpen = false" x-transition:opacity></div>

        <div class="fixed z-40 inset-y-0 left-0 w-64 bg-gray-800 overflow-y-auto transform ease-in-out duration-300
                    lg:static lg:translate-x-0 lg:inset-0"
             :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">
            
            <div class="flex items-center justify-center h-16 bg-gray-900 text-white text-2xl font-semibold">
                Admin Panel
            </div>
            
            <nav class="mt-10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                    {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                
                {{-- Placeholder untuk link lain (Akan kita buat dinamis) --}}
                <a href="{{ route('admin.booking.index') }}" 
                class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                {{ request()->routeIs('admin.booking.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v2a2 2 0 01-2 2h-5m-9 0a2 2 0 01-2-2v-2a2 2 0 012-2h5m-9 0a2 2 0 00-2 2v2a2 2 0 002 2h5m-5 0h5"/>
                    </svg>
                    Manajemen Booking
                </a>

                {{-- =============================================== --}}
                {{-- <<< TAMBAHKAN LINK PENGAJUAN BERKAS INI >>> --}}
                {{-- =============================================== --}}
                <a href="{{ route('admin.pengajuan.index') }}" 
                   class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                   {{ request()->routeIs('admin.pengajuan.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Pengajuan Berkas
                </a>


                <a href="{{ route('admin.layanan.index') }}" class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                   {{ request()->routeIs('admin.layanan.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Kelola Layanan
                </a>
                
                <a href="{{ route('admin.pengumuman.index') }}" 
                   class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                   {{ request()->routeIs('admin.pengumuman.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Manajemen Pengumuman
                </a>

                <a href="{{ route('admin.petugas.index') }}" 
                   class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                   {{ request()->routeIs('admin.petugas.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Kelola Petugas
                </a>

                <a href="{{ route('admin.warga.index') }}" 
                   class="flex items-center py-2 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                   {{ request()->routeIs('admin.warga.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-2.37M16 13A4 4 0 118 5a4 4 0 018 0zM4 20v-2a3 3 0 015.356-2.37m-5.356 2.37H2v-2a3 3 0 013-3h12a3 3 0 013 3v2z" />
                    </svg>
                    Data Warga
                </a>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header (Top Bar) --}}
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-blue-600">
                <div class="flex items-center">
                    <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M4 6H20M4 12H20M4 18H20"></path>
                        </svg>
                    </button>
                    
                    {{-- Judul Halaman --}}
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
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-600 hover:text-white">Profil</a>
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