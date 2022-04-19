@props([
    // name of the input field for use in forms
    'name' => 'name',
    'type' => 'text', // text, password, email, tel, search
    'label' => ucwords(str_replace('_', ' ',$name)),
    'numeric' => 'false',
    'required' => 'false',
    'add_clearing' => 'true',
    'placeholder' => '',
    'selected_value' => '',
    'class' => '',
    'has_label' => 'false',
])
@php
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
@endphp
<div class="relative w-full @if($add_clearing == 'true') mb-1 @endif">
    <input 
        class="{{$name}} required w-full @if($has_label == 'true') peer @endif {{$class}}"
        type="{{ $type }}" 
        id="{{ $name }}"
        name="{{ $name }}" 
        value="{{ $selected_value }}" 
        autocomplete="off"
        placeholder="{{ $placeholder }}" 
        @if($numeric == 'true') onkeypress="return isNumberKey(event)" @endif />
    @if($has_label == 'true')
        <label for="{{ $name }}" class="form-label">{{ $label }} 
            @if($required == 'true') <span class="text-red-300">*</span>@endif
        </label>
    @endif
</div>