@props([
    'transparent' => 'false',
    'class' => '',
    'compact' => 'false',
])
<ul role="list" class="@if($transparent=='false')bg-white @endif divide-y divide-slate-100 {{$class}}">
    {{ $slot }}
</ul>