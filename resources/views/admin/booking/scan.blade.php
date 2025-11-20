<x-admin-layout>
    <x-slot name="header">
        {{ __('Scan QR Code Kehadiran') }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Kolom Kiri: Kamera --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">Arahkan QR Code ke Kamera</h3>
                        
                        {{-- Area Kamera --}}
                        <div id="reader" class="w-full border-2 border-dashed border-gray-300 rounded-lg overflow-hidden"></div>
                        
                        <p class="text-xs text-gray-500 mt-2 text-center">*Pastikan izin kamera diaktifkan di browser.</p>
                    </div>

                    {{-- Kolom Kanan: Hasil Scan --}}
                    <div class="flex flex-col justify-center">
                        <div id="scan-result" class="hidden text-center space-y-4">
                            {{-- Ikon Status (Akan berubah via JS) --}}
                            <div id="status-icon" class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100">
                                <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div>
                                <h4 class="text-xl font-bold text-gray-900" id="result-title">Check-in Berhasil!</h4>
                                <p class="text-sm text-gray-500 mt-1" id="result-message">Data booking ditemukan.</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-left text-sm space-y-2">
                                <p><strong>Nama:</strong> <span id="data-nama">-</span></p>
                                <p><strong>Layanan:</strong> <span id="data-layanan">-</span></p>
                                <p><strong>Jadwal:</strong> <span id="data-jam">-</span></p>
                            </div>
                            
                            <button onclick="resetScanner()" class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                                Scan Berikutnya
                            </button>
                        </div>

                        {{-- Placeholder awal --}}
                        <div id="scan-placeholder" class="text-center text-gray-400 py-12">
                            <svg class="mx-auto h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <p>Menunggu QR Code...</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Library QR Code --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    {{-- Script Logic --}}
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let isScanning = true;

        function onScanSuccess(decodedText, decodedResult) {
            if (!isScanning) return; // Mencegah scan ganda cepat
            
            isScanning = false;
            
            // Kirim data ke server
            fetch("{{ route('admin.booking.verify-qr') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({ no_booking: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                showResult(data);
            })
            .catch(error => {
                console.error('Error:', error);
                showResult({ status: 'error', message: 'Terjadi kesalahan sistem.' });
            });
        }

        function onScanFailure(error) {
            // Biarkan kosong agar tidak spam console log saat mencari QR
        }

        // Inisialisasi Scanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        // Fungsi Menampilkan Hasil
        function showResult(data) {
            document.getElementById('scan-placeholder').classList.add('hidden');
            const resultDiv = document.getElementById('scan-result');
            resultDiv.classList.remove('hidden');

            const title = document.getElementById('result-title');
            const message = document.getElementById('result-message');
            const iconDiv = document.getElementById('status-icon');
            
            // Reset Data
            document.getElementById('data-nama').textContent = '-';
            document.getElementById('data-layanan').textContent = '-';
            document.getElementById('data-jam').textContent = '-';

            if (data.status === 'success') {
                title.textContent = 'Check-in Berhasil!';
                title.className = 'text-xl font-bold text-green-600';
                iconDiv.className = 'mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100';
                iconDiv.innerHTML = `<svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>`;
                
                // Isi Data
                if(data.data) {
                    document.getElementById('data-nama').textContent = data.data.nama;
                    document.getElementById('data-layanan').textContent = data.data.layanan;
                    document.getElementById('data-jam').textContent = data.data.jam;
                }

            } else if (data.status === 'error') {
                title.textContent = 'Gagal!';
                title.className = 'text-xl font-bold text-red-600';
                iconDiv.className = 'mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100';
                iconDiv.innerHTML = `<svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;
            
            } else { // Warning (Misal: sudah check-in)
                title.textContent = 'Perhatian';
                title.className = 'text-xl font-bold text-yellow-600';
                iconDiv.className = 'mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100';
                iconDiv.innerHTML = `<svg class="h-10 w-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
            }

            message.textContent = data.message;
        }

        function resetScanner() {
            document.getElementById('scan-result').classList.add('hidden');
            document.getElementById('scan-placeholder').classList.remove('hidden');
            isScanning = true;
        }
    </script>
</x-admin-layout>