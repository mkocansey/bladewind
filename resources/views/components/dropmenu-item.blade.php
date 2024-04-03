@props([
    'class' => '',
    'icon' => '',
    'dir' => '',
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
    $icon_css .= ($icon_right) ? ' !ml-2 !-mr-1' : ' !mr-2 -ml-0.5 ';
@endphp
<div {{$attributes->merge(['data-item' => "true"])}}
     class="flex align-middle text-gray-600 cursor-pointer dark:text-slate-300 w-full text-sm !text-left bw-item {{$class}}
    @if($divided && $header) !border-0 @endif
    @if($divider && !$header)
        @if(!$divided)
            border-y border-t-slate-200/75 border-b-white dark:!border-t-gray-800/40 dark:border-b-gray-100/10 my-1
        @else hidden @endif
    @else py-2 px-2.5  @endif
    @if($icon_right && !empty($icon)) !flex-row-reverse !justify-between @endif
    @if(!$header )
        @if($hover) hover:rounded-md hover:dark:text-dark-100 hover:bg-slate-200/75 hover:dark:!bg-dark-800 @endif
    @else !cursor-default border-b border-b-slate-200/75  dark:!border-b-gray-100/10 mb-1 @endif ">
    @if(!empty($icon) && !$header)
        <x-bladewind::icon name="{!! $icon !!}" :dir="$dir" class="!h-4 !w-4 !mt-0.5 !text-gray-400  {{$icon_css}}"/>
    @endif
    {!! $slot !!}
</div>