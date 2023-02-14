@props([
    'transparent' => false,
    'compact' => false,
    'class' => '',
])
@php
    $transparent = filter_var($transparent, FILTER_VALIDATE_BOOLEAN);
    $compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
@endphp
<ul role="list" class="@if(!$transparent)bg-white @endif divide-y divide-slate-100 {{$class}}">
    {{ $slot }}
</ul>