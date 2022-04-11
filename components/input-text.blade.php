@props([
    // name of the input field for use in forms
    'name' => 'name',
    'type' => 'text',
    'label' => ucwords(str_replace('_', ' ',$name)),
    'isNumeric' => 'false',
    'required' => 'false',
    'addClearing' => 'true',
    'placeholder' => '',
    'selectedValue' => '',
])
@php
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
@endphp
<div class="relative w-full @if($addClearing == 'true') mb-1 @endif">
    <input {{ $attributes->merge(['class' => "$name required w-full peer"]) }}
        type="{{ $type }}" 
        id="{{ $name }}"
        name="{{ $name }}" 
        value="{{ $selectedValue }}" 
        autocomplete="off"
        placeholder="{{ $placeholder }}" 
        @if($isNumeric == 'true') onkeypress="return isNumberKey(event)" @endif />
    <label for="{{ $name }}" class="form-label">{{ $label }} 
        @if($required == 'true') <span class="text-red-300">*</span>@endif
    </label>
</div>