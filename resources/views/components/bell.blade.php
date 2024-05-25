@props([
    'size'          => config('bladewind.bell.size', 'small'),
    'show_dot'      => config('bladewind.bell.show_dot', true),
    'showDot'       => config('bladewind.bell.show_dot', true),
    'animate_dot'   => config('bladewind.bell.animate_dot', false),
    'animateDot'    => config('bladewind.bell.animate_dot', false),
    'invert'        => false,
    'color'         => config('bladewind.bell.color', 'primary'),
    'sizing' => [
        'small' => [
            'bell' => 'size-6',
            'dot' => 'size-[9px]'
        ],
        'big' => [
            'bell' => '!size-10',
            'dot' => '!size-4'
        ],
    ],
])
@php
    // reset variables for Laravel 8 support
    $show_dot = filter_var($show_dot, FILTER_VALIDATE_BOOLEAN);
    $showDot = filter_var($showDot, FILTER_VALIDATE_BOOLEAN);
    $animate_dot = filter_var($animate_dot, FILTER_VALIDATE_BOOLEAN);
    $animateDot = filter_var($animateDot, FILTER_VALIDATE_BOOLEAN);
    $invert = filter_var($invert, FILTER_VALIDATE_BOOLEAN);
    $invert_css = ($invert) ? '!text-white' : '';
    if( !$showDot ) $show_dot = $showDot;
    if( $animateDot ) $animate_dot = $animateDot;
    if(! in_array($size, ['small','big'])) {
        $size = 'small';
    }
    if(! in_array($color, ['primary','blue','red','yellow','green','orange','purple','cyan','pink', 'black', 'violet', 'indigo', 'fuchsia'])) {
        $color = 'primary';
    }
@endphp

<div {{ $attributes->merge(['class' => "bw-bell relative inline-block"]) }}>
    <x-bladewind::icon name="bell" class="{{ $sizing[$size]['bell'] }} cursor-pointer {{$invert_css}}"/>
    @if($show_dot)
        <div class="{{ $sizing[$size]['dot'] }} rounded-full bg-{{ $color}}-500 absolute top-0 ltr:right-[2.5px] rtl:left-[2.5px] @if($animate_dot) animate-ping @endif"></div>
    @endif
</div>