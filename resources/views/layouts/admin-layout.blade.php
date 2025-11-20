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

                    <a href="{{ route('admin.booking.scan') }}" 
                       class="flex items-center py-3 px-6 text-gray-400 hover:bg-gray-700 hover:text-white
                       {{ request()->routeIs('admin.booking.scan') ? 'bg-gray-700 text-white' : '' }}"
                       :class="isSidebarMinimized ? 'justify-center' : ''">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <span class="ml-3" x-show="!isSidebarMinimized">Scan QR Code</span>
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
    {{-- =============================================== --}}
    {{-- <<< SISTEM NOTIFIKASI REAL-TIME (POLLING) >>> --}}
    {{-- =============================================== --}}
    <div x-data="notificationSystem()" x-init="startPolling()" 
         class="fixed top-4 right-4 z-50 flex flex-col space-y-4 w-80">
        
        {{-- Template Toast Notifikasi --}}
        <template x-for="notif in notifications" :key="notif.id">
            <div x-show="true" 
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden border-l-4 border-green-500">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            {{-- Ikon Lonceng --}}
                            <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">Booking Baru!</p>
                            <p class="mt-1 text-sm text-gray-500" x-text="notif.data.nama_pemohon + ' mengajukan ' + notif.data.layanan"></p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button @click="removeNotification(notif.id)" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        function notificationSystem() {
            return {
                notifications: [],
                
                startPolling() {
                    // Cek notifikasi setiap 5 detik
                    setInterval(() => {
                        this.fetchNotifications();
                    }, 5000);
                },

                fetchNotifications() {
                    fetch('{{ route("admin.notifications.unread") }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => {
                        if(response.ok) return response.json();
                        throw new Error('Network response was not ok.');
                    })
                    .then(data => {
                        if (data.length > 0) {
                            // Tambahkan notifikasi baru ke array
                            data.forEach(notif => {
                                this.notifications.push(notif);
                                // Putar suara notifikasi (opsional)
                                // new Audio('/path/to/sound.mp3').play(); 
                                
                                // Hilangkan otomatis setelah 10 detik
                                setTimeout(() => {
                                    this.removeNotification(notif.id);
                                }, 10000);
                            });
                        }
                    })
                    .catch(error => console.log('Polling error:', error));
                },

                removeNotification(id) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }
            }
        }
    </script>
</body>
</html>