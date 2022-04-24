@props([
    'title' => '',
    'css' => '',
    'has_shadow' => 'true',
    'reduce_padding' => 'false',
])

<div class="bw-card bg-white @if($reduce_padding=='false')p-8 @else px-4 pb-4 pt-2 @endif rounded-lg @if($has_shadow=='true')shadow-2xl shadow-gray-200/40 @endif {{$css}}">
    @if($title !== '')<div class="uppercase tracking-wide text-xs text-gray-400/90 mb-2">{{ $title}}</div>@endif
    <div @if($title !== '')class="mt-6"@endif>
        {{ $slot }}
    </div>
</div>