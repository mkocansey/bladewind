@props([
    // title of the card
    'title' => '',
    // should the card be displayed with a shadow
    'has_shadow' => 'true',
    // for backward compatibility with Laravel 8
    'hasShadow' => 'true',
    // reduce padding within the card
    'reduce_padding' => 'false',
    // for backward compatibility with Laravel 8
    'reducePadding' => 'false',
    // content to display as card header
    'header' => '',
    // content to display as card footer
    'footer' => '',
    // additional css
    'class' => '',
])
@php 
    // reset variables for Laravel 8 support
    $has_shadow = $hasShadow;
    $reduce_padding = $reducePadding;
@endphp
<div class="bw-card bg-white @if($header == '') @if($reduce_padding=='false')p-8 @else px-4 pb-4 pt-2 @endif @endif rounded-lg @if($has_shadow=='true')shadow-2xl shadow-gray-200/40 @endif {{$class}}">
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