@props([ 
    // to create a radio button group, specify the same name
    // for all the radio buttons in the group
    'name' => 'radio',
    'value' => '',
    'label' => '',
    'checked' => false,
    'disabled' => false,
])
@php
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp
<x-bladewind::checkbox 
    name="{{$name}}" 
    label="{{$label}}" 
    value="{{$value}}"
    disabled="{{$disabled}}"
    checked="{{$checked}}"
    type="radio" />