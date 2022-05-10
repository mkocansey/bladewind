@props([
    'transparent' => 'false',
    'css' => ''
])
<ul role="list" class="@if($transparent=='false')bg-white @endif py-4 divide-y divide-gray-200/70 {{$css}}">
    {{ $slot }}
</ul>