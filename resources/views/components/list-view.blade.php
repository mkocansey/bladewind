@props([
    'transparent' => false,
    'compact' => config('bladewind.list_view.compact', false),
    'class' => '',
])
@php
    $transparent = filter_var($transparent, FILTER_VALIDATE_BOOLEAN);
    $compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
@endphp
<ul role="list"
    class="@if(!$transparent)bg-white dark:bg-transparent @endif divide-y divide-slate-200/90 dark:divide-dark-600/50 rounded-tl-lg rounded-tr-lg rounded-br-lg rounded-bl-lg {{$class}}">
    {{ $slot }}
</ul>