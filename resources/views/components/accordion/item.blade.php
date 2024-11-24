@props([
   'color' => '',
   'open' => false,
   'title' => '',
])
@aware([
    'color' => $color,
    'grouped' => true,
])
@php
    $name = defaultBladewindName();
    $grouped = parseBladewindVariable($grouped);
    $open = parseBladewindVariable($open);
@endphp

<div @class([
        'w-full bw-accordion '.$name,
        'pt-4 first:pt-0 ' => $grouped,
        'border py-3.5 px-5 rounded-md hover:shadow-md shadow-sm' => !$grouped,
        'bg-'.$color.'-100/70 border-'.$color.'-200' => (!$grouped && !empty($color)),
        "border-gray-200/70" => (!$grouped && empty($color))
])
     data-open="{{$open ? '1' : '0' }}"
     data-name="{{$name}}"
     onclick="toggleVisibility('{{$name}}')">
    <div class="flex group justify-between cursor-pointer">
        <div class="flex-1 text-lg accordion-title font-semibold hover:text-gray-700">{!! $title !!}</div>
        <div class=" transition duration-500 accordion-arrow">
            <x-bladewind::icon
                    name="chevron-down"
                    @class([
        '!size-7 rounded-full p-1',
        'bg-'.$color.'-300 text-white group-hover:bg-'.$color.'-500 group-hover:text-white' => (!$grouped && !empty($color)),
        'group-hover:text-gray-700 bg-gray-100' => (!$grouped && empty($color))
])/>
        </div>
    </div>
    <div class="accordion-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
        <div class="pt-2.5">{!! $slot !!}</div>
    </div>
</div>