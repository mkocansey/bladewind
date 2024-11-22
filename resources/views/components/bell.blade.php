@props([
    'size'          => config('bladewind.bell.size', 'small'),
    'show_dot'      => config('bladewind.bell.show_dot', true),
    'showDot'       => config('bladewind.bell.show_dot', true),
    'animate_dot'   => config('bladewind.bell.animate_dot', false),
    'animateDot'    => config('bladewind.bell.animate_dot', false),
    'invert'        => false,
    'color'         => config('bladewind.bell.color', 'primary'),
])
@php
    // reset variables for Laravel 8 support
    $show_dot = parseBladewindVariable($show_dot);
    $showDot = parseBladewindVariable($showDot);
    $animate_dot = parseBladewindVariable($animate_dot);
    $animateDot = parseBladewindVariable($animateDot);
    $invert = parseBladewindVariable($invert);
    $invert_css = ($invert) ? '!text-white' : '';
    if( !$showDot ) $show_dot = $showDot;
    if( $animateDot ) $animate_dot = $animateDot;

    $sizing = [
        'small' => [
            'bell' => 'size-6',
            'dot' => 'size-[9px]'
        ],
        'big' => [
            'bell' => '!size-10',
            'dot' => '!size-4'
        ],
    ];

    $size = (! in_array($size, ['small','big'])) ? 'small' : $size;
    $colour = defaultBladewindColour($color);
@endphp

<div {{ $attributes->merge(['class' => "bw-bell relative inline-block"]) }}>
    <x-bladewind::icon name="bell" class="{{ $sizing[$size]['bell'] }} cursor-pointer {{$invert_css}}"/>
    @if($show_dot)
        <div class="{{ $sizing[$size]['dot'] }} rounded-full bg-{{ $colour}}-500 absolute top-0 ltr:right-[2.5px] rtl:left-[2.5px] @if($animate_dot) animate-ping @endif"></div>
    @endif
</div>