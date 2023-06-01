@props([ 
    // to create a radio button group, specify the same name
    // for all the radio buttons in the group
    'name' => 'radio',
    'value' => '',
    'label' => '',
    'label_css' => 'mr-6',
    'color' => 'blue',
    'checked' => false,
    'disabled' => false,
])
@php
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $label_css = (!empty($labelCss)) ? $labelCss : $label_css;
@endphp
<x-bladewind::checkbox 
    name="{{$name}}" 
    label="{{$label}}" 
    value="{{$value}}"
    color="{{$color}}"
    class="rounded-full"
    disabled="{{$disabled}}"
    checked="{{$checked}}"
    type="radio" />