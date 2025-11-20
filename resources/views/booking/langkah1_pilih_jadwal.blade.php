<x-public-layout>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Beranda</a></li>
                <li><span class="text-gray-400 text-sm">/</span></li>
                <li><a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-primary-600 text-sm transition-colors">Layanan</a></li>
                <li><span class="text-gray-400 text-sm">/</span></li>
                <li><span class="text-primary-700 font-medium text-sm">Buat Janji Temu</span></li>
            </ol>
        </nav>

        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate sm:text-4xl sm:tracking-tight">
                    Buat Janji Temu Pelayanan
                </h2>
                <p class="mt-2 text-lg text-gray-600">Silakan pilih jadwal kunjungan yang sesuai dengan waktu Anda.</p>
            </div>
        </div>

        {{-- STEPPER INDICATOR --}}
        <div class="mt-10">
            <div class="flex items-center justify-center w-full">
                <div class="flex items-center w-full max-w-3xl">
                    {{-- Step 1: Aktif --}}
                    <div class="relative flex flex-col items-center text-primary-600">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-primary-600 bg-primary-600 text-white flex items-center justify-center font-bold">
                            1
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-bold uppercase text-primary-700">Pilih Jadwal</div>
                    </div>
                    
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>

                    {{-- Step 2: Pending --}}
                    <div class="relative flex flex-col items-center text-gray-400">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-300 flex items-center justify-center font-bold bg-white">
                            2
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Isi Data Diri</div>
                    </div>
                    
                    <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-300"></div>

                    {{-- Step 3: Pending --}}
                    <div class="relative flex flex-col items-center text-gray-400">
                        <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-gray-300 flex items-center justify-center font-bold bg-white">
                            3
                        </div>
                        <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-gray-400">Konfirmasi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16">
            {{-- x-data: State management --}}
            <form action="{{ route('booking.storeStep1', $layanan) }}" method="POST" 
                  x-data="{ 
                      selectedDate: null, 
                      selectedTime: null,
                      serverDate: '{{ $currentDate }}', 
                      serverTime: '{{ $currentTime }}',
                      
                      // Fungsi untuk cek apakah SESI sudah lewat (Sederhana)
                      // Kita anggap Sesi Pagi tutup jam 12:00, Siang tutup 15:00
                      isSessionPassed(sessionName) {
                          if (this.selectedDate !== this.serverDate) {
                              return false; // Kalau bukan hari ini, pasti belum lewat
                          }
                          
                          // Batas waktu sesi (Hardcoded sesuai logika controller)
                          let limitTime = '00:00';
                          if(sessionName === 'Sesi Pagi') limitTime = '12:00';
                          if(sessionName === 'Sesi Siang') limitTime = '15:00';

                          return this.serverTime > limitTime;
                      }
                  }">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                
                {{-- Info Layanan --}}
                <div class="bg-primary-50 border-l-4 border-primary-500 p-4 rounded-r-md mb-10 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-primary-800">
                                Layanan: <span class="font-bold">{{ $layanan->nama_layanan }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- =============================================== --}}
                {{-- 1. PILIH TANGGAL (Langsung Muncul) --}}
                {{-- =============================================== --}}
                <div class="mb-12">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4 flex items-center">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-sm font-bold mr-3">1</span>
                        Pilih Tanggal Kunjungan
                    </h3>
                    
                    <div class="mt-2 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <div class="text-center mb-6">
                            <span class="font-bold text-lg text-gray-800">
                                {{ \Carbon\Carbon::parse($dates[0]['val'])->translatedFormat('F Y') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-5 md:grid-cols-7 gap-3">
                            @foreach($dates as $date)
                                <label 
                                    :class="{
                                        'bg-primary-600 text-white ring-2 ring-primary-600 shadow-md transform scale-105': selectedDate === '{{ $date['val'] }}',
                                        'bg-white hover:bg-gray-50 hover:border-primary-300 text-gray-900 border border-gray-200 cursor-pointer': selectedDate !== '{{ $date['val'] }}' && '{{ $date['status'] }}' === 'available',
                                        'bg-gray-50 text-gray-400 cursor-not-allowed border border-transparent': '{{ $date['status'] }}' === 'libur'
                                    }"
                                    class="flex flex-col items-center justify-center py-4 px-2 rounded-lg border transition-all duration-200 relative overflow-hidden">
                                    
                                    <input type="radio" name="tanggal_kunjungan" value="{{ $date['val'] }}" class="sr-only" x-model="selectedDate" 
                                           @change="selectedTime = null"
                                           @if($date['status'] === 'libur') disabled @endif>
                                    
                                    <span class="text-xs uppercase font-medium mb-1" :class="selectedDate === '{{ $date['val'] }}' ? 'text-primary-100' : 'text-gray-500'">{{ $date['day_name'] }}</span>
                                    <span class="text-xl font-bold">{{ $date['day_num'] }}</span>
                                    
                                    @if($date['status'] === 'libur')
                                        <span class="text-[10px] text-red-500 font-medium mt-1 bg-red-50 px-2 py-0.5 rounded-full">Libur</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                {{-- =============================================== --}}
                {{-- 2. PILIH SESI (PAGI / SIANG) --}}
                {{-- =============================================== --}}
                <div x-show="selectedDate !== null" 
                     x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" 
                     class="mb-12" style="display: none;">
                    
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4 flex items-center">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-primary-100 text-primary-700 text-sm font-bold mr-3">2</span>
                        Pilih Sesi Kedatangan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($sessions as $session)
                            <label :class="{
                                'ring-2 ring-primary-600 bg-primary-50 shadow-md': selectedTime === '{{ $session['id'] }}',
                                'bg-white border border-gray-200 hover:border-primary-300 hover:shadow-md cursor-pointer': selectedTime !== '{{ $session['id'] }}' && !isSessionPassed('{{ $session['id'] }}'),
                                'bg-gray-50 border border-gray-200 cursor-not-allowed opacity-60': isSessionPassed('{{ $session['id'] }}')
                            }"
                            class="relative flex items-start p-6 rounded-xl transition-all duration-200">
                                
                                <div class="flex items-center h-6">
                                    <input type="radio" name="waktu_kunjungan" value="{{ $session['id'] }}" 
                                           x-model="selectedTime" 
                                           class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-600"
                                           :disabled="isSessionPassed('{{ $session['id'] }}')">
                                </div>
                                <div class="ml-4 flex-1">
                                    <span class="block text-lg font-bold text-gray-900">
                                        {{ $session['label'] }}
                                        <span x-show="isSessionPassed('{{ $session['id'] }}')" class="ml-2 text-xs font-medium text-red-600 bg-red-100 px-2 py-0.5 rounded">Tutup</span>
                                    </span>
                                    <span class="block text-sm font-medium text-primary-700 mt-1">{{ $session['jam'] }}</span>
                                    <span class="block text-xs text-gray-500 mt-2">{{ $session['desc'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                {{-- Tombol Lanjut --}}
                <div class="mt-10 flex justify-end border-t border-gray-200 pt-8">
                    <button type="submit"
                            :disabled="selectedTime === null"
                            :class="{'opacity-50 cursor-not-allowed bg-gray-400': selectedTime === null, 'bg-accent-500 hover:bg-accent-600 hover:shadow-lg transform hover:-translate-y-0.5': selectedTime !== null}"
                            class="inline-flex items-center rounded-lg px-8 py-4 text-base font-bold text-white shadow-md transition-all duration-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent-500">
                        Lanjut ke Data Diri
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-public-layout>