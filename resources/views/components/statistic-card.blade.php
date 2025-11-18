@props(['title', 'value', 'icon', 'color' => 'bg-gray-500'])

<div {{ $attributes->merge(['class' => "{$color} relative rounded-lg shadow p-5"]) }}>
    <div class="absolute top-3 right-3 text-white opacity-20">
        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
        </svg>
    </div>
    <div class="text-sm font-medium text-white uppercase">{{ $title }}</div>
    <div class="mt-1 text-3xl font-bold text-white">{{ $value }}</div>
</div>