{{-- format-ignore-start --}}
@props([
    // to create a radio button group, specify the same name
    // for all the radio buttons in the group
    'name' => 'radio',
    'value' => '',
    'label' => '',
    'labelCss' => 'mr-6',
    'color' => 'primary',
    'checked' => false,
    'addClearing' => config('bladewind.radio_button.add_clearing', true),
    'disabled' => false,
    'class' => '',
])
@php
    $checked = parseBladewindVariable($checked);
    $disabled = parseBladewindVariable($disabled);
    $addClearing = parseBladewindVariable($addClearing);
    $name = parseBladewindName($name);
@endphp
{{-- format-ignore-end --}}

<x-bladewind::checkbox
        name="{{$name}}"
        label="{{$label}}"
        value="{{$value}}"
        color="{{$color}}"
        class="rounded-full {{$class}}"
        label_css="{{$labelCss}}"
        disabled="{{$disabled}}"
        checked="{{$checked}}"
        add_clearing="{{$addClearing}}"
        type="radio"/>