@props([
    'name' => 'name',
    'label' => ucwords(str_replace('_', ' ',$name)),
    'selectedValue' => '',
    'required' => 'false',
    'addClearing' => 'true',
    'placeholder' => '',
    'rows' => 3
])
@php
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
@endphp
<div class="relative w-full @if($addClearing == 'true') mb-1 @endif">
    <textarea {{ $attributes->merge(['class' => "$name required w-full peer"]) }}
        id="{{ $name }}"
        rows="{{ $rows }}"
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}">{{ $selectedValue }}</textarea>
    <label for="{{ $name }}" class="form-label">{{ $label }} 
        @if($required == 'true') <span class="text-red-300">*</span>@endif
    </label>
</div>