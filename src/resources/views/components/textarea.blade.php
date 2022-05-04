@props([
    'name' => 'name',
    'label' => '',
    'required' => 'false',
    'add_clearing' => 'true',
    'placeholder' => '',
    'rows' => 3,
    'selected_value' => '', // selected value
    'has_label' => 'false', // display label for the inpur
    'css' => '',
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $label = ucwords(str_replace('_', ' ',$name));
    $required_symbol = ($has_label == 'false' && $required == 'true') ? '*' : '';
@endphp
<div class="relative w-full @if($add_clearing == 'true') mb-2 @endif">
    <textarea 
        class="bw-textarea w-full @if($has_label == 'true') peer @endif @if($required == 'true') required @endif {{$name}} {{$css}}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}{{$required_symbol}}">{{ $selected_value }}</textarea>

    @if($has_label == 'true')
        <label for="{{ $name }}" class="form-label">{{ $label }} 
            @if($required == 'true') <span class="text-red-300">*</span>@endif
        </label>
    @endif
</div>