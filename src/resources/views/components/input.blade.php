@props([
    // name of the input field for use in forms
    'name' => 'name',
    'type' => 'text', // text, password, email, tel, search
    'label' => '',
    'numeric' => 'false',
    'required' => 'false',
    'add_clearing' => 'true', // adds margin after the input field
    'placeholder' => '', // placeholder text
    'selected_value' => '', // selected value
    'has_label' => 'false', // display label for the inpur
    'css' => '',
])
@php
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
    $label = ucwords(str_replace('_', ' ',$name));
    $required_symbol = ($has_label == 'false' && $required == 'true') ? ' *' : '';
@endphp
<div class="relative w-full @if($add_clearing == 'true') mb-2 @endif">
    <input 
        class="bw-input w-full @if($has_label == 'true') peer @endif @if($required == 'true') required @endif {{$name}} {{$css}}"
        type="{{ $type }}" 
        id="{{ $name }}"
        name="{{ $name }}" 
        value="{{ $selected_value }}" 
        autocomplete="off"
        placeholder="{{ $placeholder }}{{$required_symbol}}" 
        @if($numeric == 'true') onkeypress="return isNumberKey(event)" @endif />
    @if($has_label == 'true')
        <label for="{{ $name }}" class="form-label">{{ $label }} 
            @if($required == 'true') <span class="text-red-300">*</span>@endif
        </label>
    @endif
</div>