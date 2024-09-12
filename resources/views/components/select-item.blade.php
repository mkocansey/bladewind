@props([
    'value' => 'value',
    'label' => 'label',
    'selected' => 'false',
    'flag' => '',
    'image' => '',
    'filter_by' => '',
    'selectable' => 'true',
])
@aware([ 'onselect' => '', ])

@php
    $selected = filter_var($selected, FILTER_VALIDATE_BOOLEAN);
    $selectable = filter_var($selectable, FILTER_VALIDATE_BOOLEAN);
    $label = html_entity_decode($label);
@endphp
<div
        class="py-3 pl-4 pr-3 flex items-center text-base cursor-pointer bw-select-item @if($selectable) hover:bg-slate-100/90 dark:hover:bg-dark-800/50 dark:hover:text-dark-200 @else text-blue-900/40 @endif"
        data-label="{!! $label !!}" data-value="{{ $value }}"
        @if(!$selectable) data-unselectable @endif
        @if(!empty($filter_by)) data-filter-value="{{$filter_by}}" @endif
        @if($selected) data-selected="true" @endif
        @if($onselect !== '') data-user-function="{{ $onselect }}"@endif>
    @if ($flag !== '' && $image == '')
        <i class="{{ $flag }} flag"></i>
    @endif
    @if ($image !== '')
        <x-bladewind::avatar size="small" class="!mt-0 !mr-4" image="{{ $image }}"/>
    @endif
    <span class="grow text-left">{!! $label !!}</span>
    <x-bladewind::icon name="check-circle" class="text-slate-400 size-5 hidden svg-{{$value }}"/>
</div>
