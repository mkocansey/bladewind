@props([
    'class' => '',
    'icon' => '',
    'icon_css' => '',
    'divider' => false,
    'header' => false,
    'hover' => true,
])
@aware([
    'divided' => false,
    'icon_right' => false,
])
@php
    $divider = filter_var($divider, FILTER_VALIDATE_BOOLEAN);
    $header = filter_var($header, FILTER_VALIDATE_BOOLEAN);
    $hover = filter_var($hover, FILTER_VALIDATE_BOOLEAN);
    $icon_right = filter_var($icon_right, FILTER_VALIDATE_BOOLEAN);
    $icon_css .= ($icon_right) ? ' ml-2' : '  mr-2';
@endphp
<div
        class="@if($divider && !$header) @if(!$divided) border-y !border-t-slate-200/75 !border-b-white my-1 @else hidden @endif @else px-4 py-2 @endif flex align-middle text-gray-600 cursor-pointer @if($icon_right && !empty($icon)) !flex-row-reverse !justify-between @endif
        dark:text-slate-300 @if(!$header ) @if($hover) hover:dark:text-dark-100 hover:bg-slate-200/75 dark:hover:bg-dark-900/75 @endif @else !cursor-default border-b border-b-slate-200/75 mb-1 @endif w-full text-sm !text-left whitespace-nowrap bw-item {{$class}}">
    @if(!empty($icon) && !$header)
        <x-bladewind::icon name="{{ $icon }}"
                           class="!h-[17px] !w-[17px] !-ml-1 !mt-0.5 !text-gray-400  {{$icon_css}}"/>
    @endif
    {{ $slot }}
</div>