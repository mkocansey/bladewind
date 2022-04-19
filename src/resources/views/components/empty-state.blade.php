@props([
    'image' => '/assets/images/ss-chart.svg', 
])

<div {{ $attributes->merge(['class' => " !text-center !px-4 pb-10"]) }}>
    <img src="{{ $image }}" class="h-52 mx-auto" />
    <span class="text-gray-500/80 text-sm">{{ $slot }}</span>
</div>