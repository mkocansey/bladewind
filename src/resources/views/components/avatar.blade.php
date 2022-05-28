@props([ 
    'image' => '',
    'alt' => 'image',
    'size' => 'regular',
    'class' => 'mr-2 mt-2',
    'stacked' => 'false',
    'sizing' => [
        'tiny' => '6',
        'small' => '8',
        'medium' => '10',
        'regular' => '12',
        'big' => '16',
        'huge' => '20',
        'omg' => '28'
    ]
])
@php  $avatar = ($image === '') ? asset('bladewind/images/avatar.png') : $image; @endphp

<span class="w-6 w-8 w-10 w-12 w-16 w-20 w-28 h-6 h-8 h-10 h-12 h-16 h-20 h-28 hidden"></span>
<div class="w-{{ $sizing[$size] }} h-{{ $sizing[$size] }} inline-block rounded-full ring-2 ring-gray-200 dark:ring-slate-600 ring-offset-2 overflow-hidden  {{$class}} @if($stacked=='true') -ml-5 @endif">
    <img src="{{ $avatar }}" alt="{{ $alt }}" class="object-cover object-top" />
</div>