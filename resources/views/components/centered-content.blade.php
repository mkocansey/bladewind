@props([
    'size' => 'xl',
    'width' => [
        'omg' => '7xl',
        'xxl' => '6xl',
        'xl' => '4xl',
        'big' => '3xl',
        'medium' => '2xl',
        'small' => 'lg',
        'tiny' => 'md'
    ]
])
@php
    $sizes = ['omg', 'xxl', 'xl', 'big', 'medium', 'small', 'tiny'];

    if(! in_array($size, $sizes)) {
        dd('refer to centered-content/docs for approved sizes. https://bladewindui.com/component/centered-content');
    }
@endphp
<div class="max-w-md max-w-lg max-w-2xl max-w-3xl max-w-4xl max-w-6xl max-w-7xl "></div>
<div {{ $attributes->merge(['class' => "max-w-$width[$size] mx-auto"]) }}>
    {{ $slot }}
</div>
