@props([
    'size' => 'default',
    'width' => [
        'xxl' => '7xl',
        'default' => '6xl',
        'xl' => '4xl',
        'large' => '3xl',
        'medium' => '2xl',
        'small' => 'lg',
        'tiny' => 'md'
    ]
])
<div class="max-w-7xl max-w-6xl max-w-2xl max-w-lg max-w-md"></div>
<div class="max-w-{{$width[$size]}} mx-auto">
    {{ $slot }}
</div>