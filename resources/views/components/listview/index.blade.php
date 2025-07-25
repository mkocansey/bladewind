{{-- format-ignore-start --}}
@props([
    'transparent' => false,
    'compact' => config('bladewind.list_view.compact', false),
    'class' => '',
])
@php
    $transparent = parseBladewindVariable($transparent);
    $compact = parseBladewindVariable($compact);
@endphp
{{-- format-ignore-end --}}

<ul role="list"
    class="@if(!$transparent)bg-white dark:bg-transparent @endif divide-y divide-slate-200/90 dark:divide-dark-600/80 {{$class}}">
    {{ $slot }}
</ul>