@props([
    'name' => defaultBladewindName(),
    'icon' => null,
    'avatar' => null,
    'avatar_size' => 'medium',
    'compact' => config('bladewind.selectable_card.compact', false),
    'class' => null,
    'color' => config('bladewind.checkcards.color', 'primary'),
    'radius' => config('bladewind.checkcards.rounded', 'medium'),
    'border_width' => 2,
    'border_color' => 'gray',
    'align_items' => 'top',
    'max' => 1,
    'required' => false,
    'show_error' => config('bladewind.checkcards.show_error', false),
    'auto_select_new' => config('bladewind.checkcards.auto_select_new', true),
    'error_heading' => config('bladewind.checkcards.error_heading', ''),
    'error_message' => config('bladewind.checkcards.error_message', ''),
    'selected_value' => '',
])
@php
    $name = parseBladewindName($name);
    $required = parseBladewindVariable($required);
    $show_error = parseBladewindVariable($show_error);
    $auto_select_new = parseBladewindVariable($auto_select_new);
    $max_selection = (!empty($max) && is_numeric($max) && $max > 0) ? $max : 1;
    if($show_error) $auto_select_new = false;
@endphp

<div class="bw-checkcards-{{$name}} {{$class}}">
    <x-bladewind::input
            :name="$name"
            :error_message="$error_message"
            :error_heading="$error_heading"
            data-max-selection="{{$max_selection}}"
            data-show-error="{{$show_error}}"
            data-auto-select="{{$auto_select_new}}"
            type="hidden"
            class="{{ ($required) ? 'required':''}}"/>
    {{ $slot }}
</div>