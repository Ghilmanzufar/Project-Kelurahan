<x-public-layout>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

        {{-- Breadcrumbs --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-2">
                <li><a href="/" class="text-gray-500 hover:text-gray-700 text-sm">Beranda</a></li>
                <li>
                    <span class="text-gray-500 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><a href="{{ route('layanan.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Detail Layanan</a></li>
                <li>
                    <span class="text-gray-500 text-sm">
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </li>
                <li><span class="text-gray-900 text-sm">Buat Janji Temu</span></li>
            </ol>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Buat Janji Temu Pelayanan</h1>

        {{-- Step Indicator --}}
        <div class="mt-8 flex items-center space-x-4">
            <div class="flex items-center">
                <div class="h-8 w-8 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-sm mr-2">1</div>
                <span class="font-semibold text-blue-600">PILIH JADWAL</span>
            </div>
            <div class="flex-grow border-t border-gray-300"></div>
            <div class="flex items-center text-gray-500">
                <div class="h-8 w-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-500 font-bold text-sm mr-2">2</div>
                <span>ISI DATA DIRI</span>
            </div>
            <div class="flex-grow border-t border-gray-300"></div>
            <div class="flex items-center text-gray-500">
                <div class="h-8 w-8 flex items-center justify-center rounded-full border border-gray-300 text-gray-500 font-bold text-sm mr-2">3</div>
                <span>KONFIRMASI</span>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900">LANGKAH 1: PILIH PETUGAS & JADWAL</h2>

            <form action="{{ route('booking.storeStep1') }}" method="POST" x-data="{ selectedPetugas: null, selectedDate: null, selectedTime: null }">
                @csrf
                <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">
                
                <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-sm">
                    <p class="font-medium text-gray-700">Layanan yang Dipilih:</p>
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-3 py-1 text-base font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 mt-2">
                        {{ $layanan->nama_layanan }}
                    </span>
                </div>

                <div class="mt-10">
                    <h3 class="text-xl font-semibold text-gray-900">Pilih Petugas yang Tersedia:</h3>
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($petugasTersedia as $petugas)
                            <label :class="{'ring-2 ring-blue-600': selectedPetugas == {{ $petugas->id }} }" 
                                class="relative block cursor-pointer rounded-lg border border-gray-300 bg-white shadow-sm p-6 focus:outline-none transition-all duration-200 ease-in-out">
                                <input type="radio" name="petugas_id" value="{{ $petugas->id }}" class="sr-only" x-model="selectedPetugas" @change="selectedDate = null; selectedTime = null">
                                <span class="flex items-center space-x-4">
                                    {{-- Placeholder Gambar Petugas --}}
                                    <div class="flex-shrink-0 h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                                        </svg>
                                    </div>
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">{{ $petugas->nama_lengkap }}</span>
                                        <span class="block text-sm text-gray-500">{{ $petugas->jabatan }}</span>
                                    </span>
                                </span>
                                <span :class="{'border-blue-600': selectedPetugas == {{ $petugas->id }}, 'border-transparent': selectedPetugas != {{ $petugas->id }} }"
                                    aria-hidden="true" class="pointer-events-none absolute -inset-px rounded-lg border-2"></span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Bagian ini baru muncul setelah petugas dipilih --}}
                <div x-show="selectedPetugas !== null" x-transition class="mt-12 bg-gray-50 p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900">Pilih Tanggal Kunjungan:</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        (Untuk Petugas: <span class="font-medium" x-text="$el.closest('form').querySelector('input[name=petugas_id]:checked + span .font-medium').textContent"></span>)
                    </p>

                    {{-- Calendar Interactive Placeholder (Ini akan menjadi komponen kalender nanti) --}}
                    <div class="mt-6 p-4 border border-gray-200 rounded-lg bg-white">
                        <div class="flex justify-between items-center mb-4">
                            <button type="button" class="text-gray-600 hover:text-gray-900">&larr; Okt 2025</button>
                            <span class="font-semibold text-lg">Oktober 2025</span>
                            <button type="button" class="text-gray-600 hover:text-gray-900">Nov 2025 &rarr;</button>
                        </div>
                        <div class="grid grid-cols-7 gap-2 text-center text-sm">
                            <div class="font-medium text-gray-500">Min</div>
                            <div class="font-medium text-gray-500">Sen</div>
                            <div class="font-medium text-gray-500">Sel</div>
                            <div class="font-medium text-gray-500">Rab</div>
                            <div class="font-medium text-gray-500">Kam</div>
                            <div class="font-medium text-gray-500">Jum</div>
                            <div class="font-medium text-gray-500">Sab</div>

                            {{-- Dummy days --}}
                            @php
                                $dummyDates = [
                                    ['day' => '28', 'available' => true],
                                    ['day' => '29', 'available' => true],
                                    ['day' => '30', 'available' => true],
                                    ['day' => '31', 'available' => false], // Disabled/Penuh
                                ];
                            @endphp

                            @foreach($dummyDates as $date)
                                <label 
                                    :class="{
                                        'bg-blue-600 text-white': selectedDate === '2025-10-{{ $date['day'] }}',
                                        'bg-gray-200 text-gray-500 cursor-not-allowed': !{{ json_encode($date['available']) }},
                                        'bg-white text-gray-900 hover:bg-gray-100': selectedDate !== '2025-10-{{ $date['day'] }}' && {{ json_encode($date['available']) }}
                                    }"
                                    class="h-10 w-10 flex items-center justify-center rounded-md font-medium cursor-pointer transition-all duration-200 ease-in-out">
                                    <input type="radio" name="tanggal_kunjungan" value="2025-10-{{ $date['day'] }}" class="sr-only" x-model="selectedDate" 
                                           @change="selectedTime = null"
                                           @if(!$date['available']) disabled @endif>
                                    {{ $date['day'] }}
                                </label>
                            @endforeach
                            {{-- ... more dummy days for visual --}}
                            @for ($i = 1; $i <= 26; $i++)
                                <div class="h-10 w-10 flex items-center justify-center rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">
                        *Tanggal yang ada slot (misal: 28, 29, 30) akan bisa diklik*
                    </p>
                    <p class="mt-2 text-sm text-gray-500">
                        *Tanggal yang penuh/libur (misal: 31) akan berwarna abu-abu/disabled*
                    </p>
                </div>
                
                {{-- Bagian ini baru muncul setelah tanggal dipilih --}}
                <div x-show="selectedDate !== null" x-transition class="mt-12 bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold text-gray-900">Pilih Slot Waktu Tersedia:</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        (Pada: <span class="font-medium" x-text="new Date(selectedDate).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></span>)
                    </p>

                    @php
                        $dummyTimeSlots = [
                            'Pagi' => [
                                ['time' => '09:00', 'available' => true],
                                ['time' => '09:30', 'available' => true],
                                ['time' => '10:00', 'available' => false], // Penuh
                                ['time' => '10:30', 'available' => true],
                            ],
                            'Siang' => [
                                ['time' => '13:00', 'available' => true],
                                ['time' => '13:30', 'available' => true],
                                ['time' => '14:00', 'available' => false], // Penuh
                                ['time' => '14:30', 'available' => false], // Penuh
                            ],
                        ];
                    @endphp

                    @foreach($dummyTimeSlots as $sessionName => $slots)
                        <div class="mt-6">
                            <p class="font-medium text-gray-700">Sesi {{ $sessionName }}:</p>
                            <div class="mt-2 flex flex-wrap gap-3">
                                @foreach($slots as $slot)
                                    <label
                                        :class="{
                                            'bg-blue-600 text-white': selectedTime === '{{ $slot['time'] }}',
                                            'bg-gray-300 text-gray-500 cursor-not-allowed': !{{ json_encode($slot['available']) }},
                                            'bg-gray-800 text-white hover:bg-gray-700': selectedTime !== '{{ $slot['time'] }}' && {{ json_encode($slot['available']) }}
                                        }"
                                        class="inline-flex items-center justify-center px-4 py-2 rounded-md font-medium text-sm transition-all duration-200 ease-in-out"
                                        style="min-width: 90px;">
                                        <input type="radio" name="waktu_kunjungan" value="{{ $slot['time'] }}" class="sr-only" x-model="selectedTime"
                                               @if(!$slot['available']) disabled @endif>
                                        {{ $slot['time'] }} {{ !$slot['available'] ? ' - PENUH' : '' }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="mt-10 text-right">
                        <button type="submit"
                                :disabled="selectedTime === null"
                                :class="{'opacity-50 cursor-not-allowed': selectedTime === null}"
                                class="rounded-md bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-sm transition-all hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Lanjut ke Data Diri &rarr;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>