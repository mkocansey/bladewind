@props([
    'size'          => 'small',
    'show_dot'      => true,
    'showDot'       => true,
    'animate_dot'   => false,
    'animateDot'    => false,
    'invert'        => false,
    'color'         => 'primary',
    'sizing' => [
        'small' => [
            'bell' => 'w-6 h-6',
            'dot' => 'w-[9px] h-[9px]'
        ],
        'big' => [
            'bell' => 'w-10 h-10',
            'dot' => 'w-4 h-4'
        ],
    ],
    'coloring' => [
        'bg' => [
            'primary'   => 'bg-primary-500',
            'red'       => 'bg-red-500',
            'yellow'    => 'bg-yellow-500',
            'green'     => 'bg-green-500',
            'blue'      => 'bg-blue-500',
            'orange'    => 'bg-orange-500',
            'purple'    => 'bg-purple-500',
            'cyan'      => 'bg-cyan-500',
            'pink'      => 'bg-pink-500',
            'black'     => 'bg-black',
        ],
        'ring' => [
            'primary'   => 'ring-primary-500',
            'red'       => 'ring-red-500',
            'yellow'    => 'ring-yellow-500',
            'green'     => 'ring-green-500',
            'blue'      => 'ring-blue-500',
            'orange'    => 'ring-orange-500',
            'purple'    => 'ring-purple-500',
            'cyan'      => 'ring-cyan-500',
            'pink'      => 'ring-pink-500',
            'black'     => 'ring-black',
        ]
    ]
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
    if(! in_array($color, ['primary','blue','red','yellow','green','blue','orange','purple','cyan','pink', 'black'])) {
        $color = 'primary';
    }
@endphp

<div {{ $attributes->merge(['class' => "bw-bell relative inline-block"]) }}>
    <x-bladewind::icon name="bell" class="{{ $sizing[$size]['bell'] }} cursor-pointer {{$invert_css}}" />
@if($show_dot)
    <div class="{{ $sizing[$size]['dot'] }} rounded-full {{ $coloring['bg'][$color] }} absolute top-0 right-[2.5px] @if($animate_dot) animate-ping @endif"></div>
    @endif
</div>