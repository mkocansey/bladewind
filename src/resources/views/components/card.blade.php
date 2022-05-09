@props([
    'title' => '',
    'css' => '',
    'has_shadow' => 'true',
    'reduce_padding' => 'false',
    'header' => '',
    'footer' => '',
])

<div class="bw-card bg-white @if($header == '') @if($reduce_padding=='false')p-8 @else px-4 pb-4 pt-2 @endif @endif rounded-lg @if($has_shadow=='true')shadow-2xl shadow-gray-200/40 @endif {{$css}}">
    @if($header != '')
        <div class="border-b border-gray-100/30">
            {{$header}}
        </div>
    @endif
    @if($title !== '' && $header == '')<div class="uppercase tracking-wide text-xs text-gray-400/90 mb-2">{{ $title}}</div>@endif
    <div @if($title !== '' && $header == '')class="mt-6"@endif>
        {{ $slot }}
    </div>
    @if($footer != '')
        <div class="border-t border-gray-100/30">
            {{$footer}}
        </div>
    @endif
</div>