@props([ 
    // to create a radio button group, specify the same name
    // for all the radio buttons in the group
    'name' => 'radio',
    'value' => '',
    'label' => '',
    'label_css' => 'mr-6',
    'labelCss' => 'mr-6',
    'color' => 'blue',
    'checked' => false,
    'add_clearing' => config('bladewind.radio_button.add_clearing', true),
    'class' => '',
    'disabled' => false,
])
@php
    $checked = parseBladewindVariable($checked);
    $disabled = parseBladewindVariable($disabled);
    $label_css = (!empty($labelCss)) ? $labelCss : $label_css;
@endphp
<x-bladewind::checkbox
        name="{{$name}}"
        label="{{$label}}"
        value="{{$value}}"
        color="{{$color}}"
        class="rounded-full {{$class}}"
        label_css="{{$label_css}}"
        disabled="{{$disabled}}"
        checked="{{$checked}}"
        type="radio"/>