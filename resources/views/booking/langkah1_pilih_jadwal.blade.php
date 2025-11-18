<x-public-layout>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Beranda</a></li>
                <li>
                    <span class="text-gray-400 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Layanan</a></li>
                <li>
                    <span class="text-gray-400 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><span class="text-primary-700 font-medium text-sm">Buat Janji Temu</span></li>
            </ol>
        </nav>

        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-4xl sm:tracking-tight">
                    Buat Janji Temu Pelayanan
                </h2>
                <p class="mt-2 text-lg text-gray-600">Silakan pilih petugas dan jadwal yang sesuai dengan waktu Anda.</p>
            </div>
        </div>

        {{-- Stepper Indicator (Hijau) --}}
        <div class="mt-10">
            <div class="flex items-center justify-center w-full">
                <div class="flex items-center w-full max-w-3xl">
                    {{-- Step 1: Aktif (Hijau Penuh) --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-primary-600 bg-primary-600 text-white flex items-center justify-center font-bold">
                            1
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-primary-600">Pilih Jadwal</div>
                    </div>
                    
                    {{-- Garis Penghubung (Abu-abu) --}}
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>

                    {{-- Step 2: Pending (Abu-abu) --}}
                    <div class="relative flex flex-col items-center text-gray-400">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-300 flex items-center justify-center font-bold">
                            2
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Isi Data Diri</div>
                    </div>
                    
                    {{-- Garis Penghubung (Abu-abu) --}}
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>

                    {{-- Step 3: Pending (Abu-abu) --}}
                    <div class="relative flex flex-col items-center text-gray-400">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-300 flex items-center justify-center font-bold">
                            3
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Konfirmasi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16">
            <form action="{{ route('booking.storeStep1', $layanan) }}" method="POST" 
                x-data="{ 
                    selectedPetugas: null, 
                    selectedDate: null, 
                    selectedTime: null,
                    serverDate: '{{ $currentDate }}', 
                    serverTime: '{{ $currentTime }}',
                    
                    // Fungsi helper untuk cek apakah waktu sudah lewat
                    isTimePassed(slotTime) {
                        // Jika tanggal yang dipilih BUKAN hari ini, slot tidak expired
                        if (this.selectedDate !== this.serverDate) {
                            return false;
                        }
                        // Jika hari ini, bandingkan jam slot dengan jam server
                        // (String comparison '09:00' < '12:00' bekerja dengan baik)
                        return slotTime < this.serverTime;
                    }
                }">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                
                {{-- Info Layanan Terpilih --}}
                <div class="bg-primary-50 border-l-4 border-primary-500 p-4 rounded-r-md mb-10">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-primary-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary-700">
                                Anda sedang mengajukan layanan: <span class="font-bold">{{ $layanan->nama_layanan }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 1. Pilih Petugas --}}
                <div class="mb-12">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4">1. Pilih Petugas Pelayanan</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($petugasTersedia as $petugas)
                            <label :class="{'ring-2 ring-primary-600 bg-primary-50': selectedPetugas == {{ $petugas->id }}, 'bg-white hover:bg-gray-50': selectedPetugas != {{ $petugas->id }} }" 
                                class="relative flex cursor-pointer rounded-lg border border-gray-300 p-4 shadow-sm focus:outline-none transition-all duration-200">
                                <input type="radio" name="petugas_id" value="{{ $petugas->id }}" class="sr-only" x-model="selectedPetugas" @change="selectedDate = null; selectedTime = null">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        {{-- Avatar Petugas --}}
                                        <span class="block text-sm font-medium text-gray-900 mb-1">
                                            <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mx-auto mb-2">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="block text-center font-bold">{{ $petugas->nama_lengkap }}</span>
                                        </span>
                                        <span class="block text-xs text-gray-500 text-center">{{ $petugas->jabatan }}</span>
                                    </span>
                                </span>
                                {{-- Checkmark Icon (Hanya muncul saat dipilih) --}}
                                <svg x-show="selectedPetugas == {{ $petugas->id }}" class="h-5 w-5 text-primary-600 absolute top-2 right-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display: none;">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- 2. Pilih Tanggal (Muncul setelah petugas dipilih) --}}
                <div x-show="selectedPetugas !== null" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="mb-12">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4">
                        2. Pilih Tanggal Kunjungan
                    </h3>
                    
                    {{-- Calendar (Dinamis dari Controller) --}}
                    <div class="mt-6 p-4 border border-gray-200 rounded-lg bg-white">
                        <div class="text-center mb-4">
                            {{-- Menampilkan Bulan dari tanggal pertama di list --}}
                            <span class="font-bold text-lg text-gray-800">
                                {{ \Carbon\Carbon::parse($dates[0]['val'])->translatedFormat('F Y') }}
                            </span>
                        </div>

                        {{-- Header Hari --}}
                        <div class="grid grid-cols-7 gap-2 text-center mb-2 text-xs font-medium text-gray-500">
                            {{-- Urutan hari ini statis, tapi tanggal di bawahnya akan menyesuaikan --}}
                            {{-- Catatan: Logic kalender sederhana ini mengasumsikan list berurutan --}}
                            {{-- Untuk kalender bulanan penuh yang akurat (posisi hari), butuh logic JS tambahan --}}
                            {{-- Tapi untuk booking list 14 hari, kita pakai scroll horizontal/grid sederhana --}}
                        </div>
                        
                        {{-- Grid Tanggal (Scrollable di Mobile) --}}
                        <div class="flex overflow-x-auto pb-4 sm:grid sm:grid-cols-7 sm:gap-2 sm:pb-0 space-x-2 sm:space-x-0">
                            @foreach($dates as $date)
                                <label 
                                    :class="{
                                        'bg-primary-600 text-white ring-2 ring-primary-600': selectedDate === '{{ $date['val'] }}',
                                        'bg-white hover:bg-gray-50 text-gray-900 border border-gray-200 cursor-pointer': selectedDate !== '{{ $date['val'] }}' && '{{ $date['status'] }}' === 'available',
                                        'bg-gray-100 text-gray-400 cursor-not-allowed': '{{ $date['status'] }}' === 'libur'
                                    }"
                                    class="flex-shrink-0 w-14 h-16 sm:w-auto sm:h-auto sm:py-3 rounded-md flex flex-col items-center justify-center border transition-all duration-200">
                                    
                                    <input type="radio" name="tanggal_kunjungan" value="{{ $date['val'] }}" class="sr-only" x-model="selectedDate" 
                                           @change="selectedTime = null"
                                           @if($date['status'] === 'libur') disabled @endif>
                                    
                                    <span class="text-xs uppercase">{{ $date['day_name'] }}</span>
                                    <span class="text-lg font-bold">{{ $date['day_num'] }}</span>
                                    
                                    @if($date['status'] === 'libur')
                                        <span class="text-[0.6rem] text-red-400">Libur</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                {{-- 3. Pilih Waktu (Muncul setelah tanggal dipilih) --}}
                <div x-show="selectedDate !== null" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="mb-12">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4">3. Pilih Jam Kedatangan</h3>
                    @foreach($timeSlots as $sessionName => $slots)
                        <div class="mt-6">
                            <p class="font-medium text-gray-700 mb-2">Sesi {{ $sessionName }}:</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach($slots as $time)
                                 <label :class="{
                                     'bg-primary-600 text-white ring-2 ring-primary-600': selectedTime === '{{ $time }}',
                                     
                                     // Pastikan ada kondisi !isTimePassed() untuk gaya default
                                     'bg-white hover:border-primary-500 text-gray-900 border border-gray-300 cursor-pointer': selectedTime !== '{{ $time }}' && !isTimePassed('{{ $time }}'),
                                     
                                     // Pastikan kondisi isTimePassed() untuk gaya disabled
                                     'bg-gray-100 text-gray-400 cursor-not-allowed': isTimePassed('{{ $time }}')
                                 }"
                                 class="py-2 px-4 rounded-md text-sm font-medium text-center transition-all duration-200 shadow-sm relative">
                                     
                                     <input type="radio" name="waktu_kunjungan" value="{{ $time }}" class="sr-only" 
                                            x-model="selectedTime"
                                            {{-- PASTIKAN ATRIBUT DISABLED INI ADA --}}
                                            :disabled="isTimePassed('{{ $time }}')">
                                     
                                     {{ $time }}

                                     {{-- Tampilkan teks 'Lewat' kecil jika expired --}}
                                     <span x-show="isTimePassed('{{ $time }}')" class="block text-[10px] text-red-400">Lewat</span>
                                 </label>
                             @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Tombol Lanjut --}}
                <div class="mt-10 flex justify-end">
                    <button type="submit"
                            :disabled="selectedTime === null"
                            :class="{'opacity-50 cursor-not-allowed': selectedTime === null, 'hover:bg-accent-600': selectedTime !== null}"
                            class="rounded-md bg-accent-500 px-10 py-3 text-base font-bold text-white shadow-sm transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500">
                        Lanjut ke Data Diri &rarr;
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-public-layout>