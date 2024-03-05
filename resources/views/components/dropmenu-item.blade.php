@props([
    'class' => '',
    'icon' => '',
    'icon_css' => '',
    'divider' => false,
    'header' => false,
])
@aware([ 'divided' => true ])

<div
        class="@if($divider && !$header) @if(!$divided) border-y !border-slate-100 !border-b-white my-1 @else hidden @endif  @else cursor-pointer px-4 py-2 @endif flex align-middle text-gray-600
        dark:text-slate-300 hover:dark:text-dark-100 w-full text-sm text-left hover:bg-slate-200/50 dark:hover:bg-dark-900/50 whitespace-nowrap bw-item {{$class}}">
    @if(!empty($icon) && !$header)
        <x-bladewind::icon name="{{ $icon }}" class="h-5 w-5 text-gray-400 pr-2 {{$icon_css}}"/>
    @endif
    {{ $slot }}
</div>