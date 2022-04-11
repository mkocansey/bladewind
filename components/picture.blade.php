@props([ 
    'url' => '',
    'alt' => 'image',
    'size' => '12',
    'name' => '',
    'css' => 'mr-2 mt-2',
])
@php 
    $avatar = ($url === '') ? 
        App\Constants\GlobalConstant::DEFAULT_AVATAR : $url;
@endphp
<span class="w-6 h-6 w-8 h-8 w-10 h-10 w-12 h-12 w-14 w-16 h-14 h-16"></span>
<div class="w-{{ $size }} h-{{ $size }} rounded-full ring-2 ring-gray-200 ring-offset-2 overflow-hidden bg-gray-50 {{$css}} {{ $name }}">
    <img src="{{ $avatar }}" alt="{{ $alt }}" class="object-cover object-top" />
</div>