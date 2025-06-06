{{-- format-ignore-start --}}
@props([
    'percentage' => 0,
    'circleWidth' => 0,
    'shade' => config('bladewind.progress_circle.shade', 'faint'),
    'color' => 'blue',
    'showLabel' => config('bladewind.progress_circle.show_label', false),
    'showPercent' => config('bladewind.progress_circle.show_percent', false),
    'size' => config('bladewind.progress_circle.size', 'medium'),
    'animate' => config('bladewind.progress_circle.animate', true),
    'textSize' => null,
    'align' => null,
    'valign' => null,
])
@php
    $shape = 'round';
    $dark = [
        'blue'      => '#3b82f6',
        'red'       => '#e11d48',
        'yellow'    => '#fbbf24',
        'green'     => '#16a34a',
        'pink'      => '#ec4899',
        'cyan'      => '#06b6d4',
        'orange'    => '#f97316',
        'gray'      => '#64748b',
        'purple'    => '#a855f7',
        'violet'    => '#7c3aed',
        'indigo'   => '#4f46e5',
        'fuchsia'  => '#c026d3',
    ];
    $faint = [
        'blue'      => '#60a5fa',
        'red'       => '#fb7185',
        'yellow'    => '#fcd34d',
        'green'     => '#4ade80',
        'pink'      => '#f472b6',
        'cyan'      => '#22d3ee',
        'orange'    => '#fb923c',
        'gray'      => '#9ca3af',
        'purple'    => '#c084fc',
        'violet'    => '#a78bfa',
        'indigo'    => '#818cf8',
        'fuchsia'   => '#e879f9',
    ];

    $tiny = [
        'width'         => 50,
        'circle_width'  => 5,
        'text'          => [
            'weight'        => 'normal',
            'translate'     => -70,
            'with_percent'  => [
                'size'      => 11,
                'width'     => 15,
                'height'    => 0
            ],
            'without_percent' => [
                'size'      => 11,
                'width'     => 15,
                'height'    => 0
            ],
        ]
    ];

    $small = [
        'width' => 80,
        'circle_width' => 8,
        'text' => [
            'weight' => 'normal', '
            translate' => -70,
            'with_percent'  => [
                'size' => 16,
                'width' => 20,
                'height' => 0
            ],
            'without_percent' => [
                'size' => 16,
                'width' => 20,
                'height' => 0
            ],
        ]
    ];

    $medium = [
        'width' => 120,
        'circle_width'  => 12,
        'text' => [
            'weight' => 'normal',
            'translate' => -70,
            'with_percent' => [
                'size' => 18,
                'width' => 36,
                'height' => 0
            ],
            'without_percent' => [
                'size' => 24,
                'width' => 30,
                'height' => 0 ]
            ,
        ]
    ];

    $big = [
        'width' => 200,
        'circle_width'  => 25,
        'text' => [
            'weight' => 'normal',
            'translate' => -70,
            'with_percent' => [
                'size' => 14,
                'width' => 20,
                'height' => 40
            ],
            'without_percent' => [
                'size' => 32,
                'width' => 40,
                'height' => 0]
            ,
        ]
    ];

    $large = [
        'width' => 300,
        'circle_width'  => 30,
        'text' => [
            'weight' => 'normal',
            'translate' => -70,
            'with_percent' => [
                'size' => 14,
                'width' => 20,
                'height' => 40
            ],
            'without_percent' => [
                'size' => 40,
                'width' => 50,
                'height' => 0]
            ,
        ]
    ];

    $animate = parseBladewindVariable($animate);
    if(!in_array($size, [ 'tiny', 'small', 'medium', 'big', 'large' ]) && ! is_numeric($size)) $size = 'medium';
    $custom_size_text = [ 
      'size' => is_numeric($textSize) ? $textSize : 30,
      'width' => is_numeric($align) ? $align : 40, 
      'height' => is_numeric($valign) ? $valign : 0 
    ];
    $this_shade = ${$shade};
    $this_size = is_numeric($size) ? $size : ${$size};
    $width = (is_numeric($this_size)) ? $size : $this_size['width'];
    $percentage = (is_numeric($percentage)) ? $percentage : 0;
    $circleWidth = ($circleWidth !== 0) ? $circleWidth : ((is_array($this_size)) ? $this_size['circle_width'] : 10);
    $this_text = is_numeric($this_size) ? $custom_size_text : $this_size['text'][$showPercent?'with_percent':'without_percent'];
    $radius = ($width/2) - 10;
    $dasharray = 3.14 * $radius * 2;
    $dashoffset = round($dasharray*((100-$percentage)/100)) . "px";
@endphp

        <!-- https://nikitahl.github.io/svg-circle-progress-generator/ -->
<svg width="{{$width}}" height="{{$width}}"
     viewBox="-{{$width*0.125}} -{{$width*0.125}} {{$width*1.25}} {{$width*1.25}}"
     version="1.1" xmlns="http://www.w3.org/2000/svg" style="transform:rotate(-90deg)"
     class="inline-block @if($animate) animate__animated animate__heartBeat @endif">
    <circle stroke-dashoffset="0" fill="transparent" stroke="transparent"
            r="{{($width/2 - 10)}}"
            cx="{{$width/2}}"
            cy="{{$width/2}}"
            stroke-width="{{$circleWidth}}"
            stroke-dasharray="{{$dasharray}}"></circle>
    <circle
            fill="transparent"
            r="{{($width/2 - 10)}}"
            cx="{{$width/2}}"
            cy="{{$width/2}}"
            stroke="{{$this_shade[$color]}}"
            stroke-width="{{$circleWidth}}"
            stroke-linecap="{{$shape}}"
            stroke-dashoffset="{{$dashoffset}}"
            stroke-dasharray="{{$dasharray}}"></circle>
    @if($showLabel)
        <text
                x="{{ round(($width/2)- $this_text['width']/1.75)}}px"
                y="{{ round(($width/2)+ ($this_text['height']/3.25)) }}px"
                fill="{{$this_shade[$color]}}"
                font-size="{{$this_text['size']}}px"
                font-weight="bold"
                style="transform:rotate(90deg) translate(0px, -{{$width-4}}px)">{{$percentage}}@if($showPercent)
                %
            @endif</text>
    @endif
</svg>