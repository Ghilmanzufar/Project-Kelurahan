<x-public-layout>
    {{-- Header Section --}}
    <div class="bg-primary-900 py-16 sm:py-24 relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
             <svg class="absolute left-[max(50%,25rem)] top-0 h-[64rem] w-[128rem] -translate-x-1/2 stroke-primary-700/50 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>
        <div class="mx-auto max-w-7xl px-6 lg:px-8 relative text-center">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Pusat Bantuan</h1>
            <p class="mt-6 text-lg leading-8 text-primary-100">
                Temukan jawaban atas pertanyaan yang sering diajukan seputar layanan pertanahan.
            </p>
        </div>
    </div>

    <div class="bg-gray-50 py-16 sm:py-24">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Frequently Asked Questions (FAQ)</h2>
            </div>

            <div class="space-y-4">
                @foreach ($faqData as $index => $item)
                    {{-- Accordion Item dengan Alpine.js --}}
                    <div x-data="{ expanded: false }" class="rounded-lg bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden transition-all duration-300 hover:shadow-md">
                        <button @click="expanded = !expanded" class="flex w-full items-center justify-between px-6 py-4 text-left text-gray-900 focus:outline-none">
                            <span class="text-base font-semibold leading-7">
                                {{-- Menggunakan keyword pertama sebagai 'Judul' pertanyaan --}}
                                {{ ucfirst($item['keywords'][0]) }}? 
                                <span class="text-xs font-normal text-gray-500 ml-2">
                                    (Topik: {{ implode(', ', array_slice($item['keywords'], 1, 3)) }})
                                </span>
                            </span>
                            <span class="ml-6 flex h-7 items-center">
                                {{-- Ikon Panah Bawah --}}
                                <svg x-show="!expanded" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                                {{-- Ikon Minus --}}
                                <svg x-show="expanded" class="h-6 w-6 text-accent-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                            </span>
                        </button>
                        
                        <div x-show="expanded" x-collapse class="px-6 pb-4 pt-0 text-base leading-7 text-gray-600 border-t border-gray-100 bg-primary-50/30">
                            <div class="mt-4 prose prose-sm text-gray-600">
                                {!! nl2br(e($item['answer'])) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-public-layout>