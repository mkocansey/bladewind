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
<div class="max-w-7xl max-w-6xl max-w-2xl max-w-lg max-w-md"></div>
<div class="max-w-{{$width[$size]}} mx-auto">
    {{ $slot }}
</div>