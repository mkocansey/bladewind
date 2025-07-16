{{-- format-ignore-start --}}
@props([
    'circle' => false,
    'duration' => '1.5s',
    'animation' => 'normal',
    'class' => '',
    'width' => 'w-full',
    'height' => 'h-2.5',
    'align' => 'left',
])
@php
    $circle = parseBladewindVariable($circle);
    if($circle && (str_replace('w-','', $width) != str_replace('w-','', $height))) {
        $width = 'size-24';
        $height = '';
    }
@endphp
{{-- format-ignore-end --}}
<div @class([
        "bw-shimmer !relative !overflow-hidden bg-gray-200 dark:bg-dark-800/50 mb-2",
        $class => !empty($class),
        $width => !empty($width),
        $height => !empty($height),
        "rounded-md" => !$circle,
        "rounded-full" => $circle,
        "mx-auto" => ($align== 'center'),
        "inline-flex items-right" => ($align== 'right'),
     ])
     style="--shimmer-duration:{{ $duration }}; --shimmer-mode:{{ $animation }};"></div>