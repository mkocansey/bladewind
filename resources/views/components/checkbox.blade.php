@props([
    'name' => 'checkbox',
    'value' => null,
    'label' => null,
    'checked' => false,
    'disabled' => false,
    'type' => 'checkbox',
    'class' => 'rounded-md',
    'label_css' => 'mr-6',
    'labelCss' => '',
    'color' => 'primary',
    'add_clearing' => true,
    'addClearing' => true,
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $label_css = (!empty($labelCss)) ? $labelCss : $label_css;
    $text_color = ($color == 'black') ? 'text-black' : "text-{$color}-500";
    $ring_color = ($color == 'black') ? 'ring-black' : "ring-{$color}-500";
    $border_color = ($color == 'black') ? 'border-slate-500' : "border-{$color}-300";
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    if (!$addClearing) $add_clearing = $addClearing;
@endphp

<div class="hidden border-red-300 border-yellow-300 border-pink-300 border-purple-300 border-cyan-300 border-orange-300 border-green-300 border-black border-blue-300"></div>
<label class="inline-flex items-center cursor-pointer text-sm @if($disabled) opacity-60 @endif @if($add_clearing) mb-3 @endif {{ $label_css }}">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        class="{{$text_color}} w-6 h-6 mr-2 disabled:opacity-50 focus:{{$ring_color}} border-2 {{$border_color}} focus:ring-opacity-25 dark:bg-dark-700 bw-checkbox {{$class}}"
        @if($disabled) disabled @endif
        @if($checked) checked @endif
        value="{{ $value }}"
    />
    {!! $label !!}
</label>
