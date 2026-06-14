{{-- format-ignore-start --}}
@props([
    // text to display inside the tooltip bubble
    'text' => '',
    // where the bubble appears relative to the wrapped content: top | bottom | left | right
    'position' => config('bladewind.tooltip.position', 'top'),
    // dark or light bubble
    'color' => config('bladewind.tooltip.color', 'dark'),
    // tiny | small | regular
    'size' => config('bladewind.tooltip.size', 'small'),
    // additional css classes to add to the wrapper
    'class' => '',
])
@php
    $position = (! in_array($position, ['top', 'bottom', 'left', 'right'])) ? 'top' : $position;
    $color = (! in_array($color, ['dark', 'light'])) ? 'dark' : $color;
    $size = (! in_array($size, ['tiny', 'small', 'regular'])) ? 'small' : $size;
@endphp
{{-- format-ignore-end --}}

<span {{ $attributes->merge(['class' => "bw-tooltip {$class}"]) }}>
    {{ $slot }}
    @if(! empty($text))
        <span class="bw-tooltip-bubble {{ $position }} {{ $size }} {{ $color }}">
            {{ $text }}
            <span class="bw-tooltip-arrow"></span>
        </span>
    @endif
</span>
