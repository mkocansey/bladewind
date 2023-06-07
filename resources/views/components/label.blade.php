@props([
    'size' => 'small',
    'show_dot' => true,
    'showDot' => true,
    'animate_dot' => false,
    'animateDot' => false,
    'invert' => false,
    'color' => 'blue',
    'sizing' => [
        'small' => [
            'bell' => 6,
            'dot' => 2
        ],
        'big' => [
            'bell' => 10,
            'dot' => 4
        ],
    ],
    'coloring' => [
        'bg' => [
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
            'green' => 'bg-emerald-500',
            'blue' => 'bg-blue-500',
            'orange' => 'bg-orange-500',
            'purple' => 'bg-purple-500',
            'cyan' => 'bg-cyan-500',
            'pink' => 'bg-pink-500',
            'black' => 'bg-black',
        ],
        'ring' => [
            'red' => 'ring-red-500',
            'yellow' => 'ring-yellow-500',
            'green' => 'ring-emerald-500',
            'blue' => 'ring-blue-500',
            'orange' => 'ring-orange-500',
            'purple' => 'ring-purple-500',
            'cyan' => 'ring-cyan-500',
            'pink' => 'ring-pink-500',
            'black' => 'ring-black',
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
    if( !$showDot ) $show_dot = $showDot;
    if( $animateDot ) $animate_dot = $animateDot;
    if(! in_array($size, ['small','big'])) $size = 'small';
    if(! in_array($color, ['blue','red','yellow','green','blue','orange','purple','cyan','pink', 'black'])) $color = 'blue';
@endphp

<div {{ $attributes->merge(['class' => "bw-bell relative inline-block"]) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-{{ $sizing[$size]['bell'] }} h-{{ $sizing[$size]['bell'] }} cursor-pointer @if($invert) text-white @endif" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
    </svg>
    @if($show_dot)
    <div class="w-{{ $sizing[$size]['dot'] }} h-{{ $sizing[$size]['dot'] }} rounded-full {{ $coloring['bg'][$color] }} absolute top-0 right-0 ring-2 {{ $coloring['ring'][$color] }} ring-offset-1 @if($animate_dot) animate-ping @endif"></div>
    @endif
</div>