@props([
    'size' => 'small',
    'class' => '',
    'sizing' => [
        'small' => 6,
        'medium' => 10,
        'big' => 14,
        'xl' => 24,
        'omg' => 36
    ],
])
<svg class="animate-spin inline-block bw-spinner h-{{ $sizing[$size] }} w-{{ $sizing[$size] }} {{$class}}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
<span class="hidden w-6 w-10 w-14 w-24 w-36 h-6 h-10 h-14 h-24 h-36"></span>