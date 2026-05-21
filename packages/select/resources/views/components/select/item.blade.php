{{-- format-ignore-start --}}
@props([
    'value' => '',
    'label' => '',
    'selected' => 'false',
    'flag' => '',
    'image' => '',
    'filterBy' => '',
    'selectable' => 'true',
    'emptyStateFrom' => null,
    'isEmpty' => false,
])
@aware([
    'onselect' => '',
])

@php
    $selected = parseBladewindVariable($selected);
    $selectable = parseBladewindVariable($selectable);
    $isEmpty = parseBladewindVariable($isEmpty);
    $label = html_entity_decode($label);
@endphp
{{-- format-ignore-end --}}

<div
        @class([
        "py-2 pl-4 pr-3 flex items-center text-base cursor-pointer bw-select-item",
        "hover:bg-primary-600 hover:text-primary-50" => $selectable,
        "text-blue-900/40" => !$selectable,
        "hidden empty-state" => $isEmpty
        ])
        data-label="{!! $label !!}" data-value="{{ $value }}"
        @if(!$selectable) data-unselectable @endif
        @if(!empty($filterBy)) data-filter-value="{{$filterBy}}" @endif
        @if($selected) data-selected="true" @endif
        @if($onselect !== '') data-user-function="{{ $onselect }}" @endif>
    @if($isEmpty)
        @if($emptyStateFrom)
            <div class="text-center grow empty-state-copy"></div>
        @else
            <span class="grow text-left text-gray-500">{!! $label !!}</span>
        @endif
    @else
        @if ($flag !== '' && $image == '')
            <i class="{{ $flag }} flag"></i>
        @endif
        @if ($image !== '')
            <x-bladewind::avatar size="tiny" class="!mt-0 !mr-2.5" image="{{ $image }}"/>
        @endif
        <span class="grow text-left">{!! $label !!}</span>
        <x-bladewind::icon name="check-circle" class="text-slate-400 size-5 hidden svg-{{$value }}"/>
    @endif
</div>
