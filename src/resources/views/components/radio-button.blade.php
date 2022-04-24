@props([ 
    // to create a radio button group, specify the same name
    // for all the radio buttons in the group
    'name' => 'radio',
    'value' => '',
    'label' => '',
    'checked' => 'false',
    'disabled' => 'false',
])
<x-bladewind::checkbox 
    name="{{$name}}" 
    label="{{$label}}" 
    value="{{$value}}"
    disabled="{{$disabled}}"
    checked="{{$checked}}"
    type="radio" />