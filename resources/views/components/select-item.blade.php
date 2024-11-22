@props([
    'value' => 'value',
    'label' => 'label',
    'selected' => 'false',
    'flag' => '',
    'image' => '',
    'filter_by' => '',
    'selectable' => 'true',
    'empty_state' => 'false',
    'empty_state_message' => config('bladewind.select.empty_placeholder', 'No options available'),
    'empty_state_button_label' => 'Add',
    'empty_state_onclick' => '',
    'empty_state_image' => config('bladewind.empty_state.image', '/vendor/bladewind/images/empty-state.svg'),
    'empty_state_show_image' => 'true',
])
@aware([
    'onselect' => '',
])

@php
    $selected = parseBladewindVariable($selected);
    $selectable = parseBladewindVariable($selectable);
    $empty_state = parseBladewindVariable($empty_state);
    $label = html_entity_decode($label);
@endphp
<div
        class="py-3 pl-4 pr-3 flex items-center text-base cursor-pointer bw-select-item @if($selectable) hover:bg-slate-100/90 dark:hover:bg-dark-800/50 dark:hover:text-dark-200 @else text-blue-900/40 @endif"
        data-label="{!! $label !!}" data-value="{{ $value }}"
        @if(!$selectable) data-unselectable @endif
        @if(!empty($filter_by)) data-filter-value="{{$filter_by}}" @endif
        @if($selected) data-selected="true" @endif
        @if($onselect !== '') data-user-function="{{ $onselect }}"@endif>
    @if($empty_state)
        <div class="text-center flex-grow">
            <x-bladewind::empty-state
                    class="!px-0 !pb-0"
                    image_css="!h-24"
                    :message="$empty_state_message"
                    :button_label="$empty_state_button_label"
                    :image="$empty_state_image"
                    :show_image="$empty_state_show_image"
                    onclick="{!! $empty_state_onclick !!}">
            </x-bladewind::empty-state>
        </div>
    @else
        @if ($flag !== '' && $image == '')
            <i class="{{ $flag }} flag"></i>
        @endif
        @if ($image !== '')
            <x-bladewind::avatar size="small" class="!mt-0 !mr-4" image="{{ $image }}"/>
        @endif
        <span class="grow text-left">{!! $label !!}</span>
        <x-bladewind::icon name="check-circle" class="text-slate-400 size-5 hidden svg-{{$value }}"/>
    @endif
</div>
