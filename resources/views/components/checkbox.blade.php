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
    'color' => config('bladewind.checkbox.color', 'primary'),
    'add_clearing' => config('bladewind.checkbox.add_clearing', true),
    'addClearing' => config('bladewind.checkbox.add_clearing', true),
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $label_css = (!empty($labelCss)) ? $labelCss : $label_css;
    if(! in_array($color, ['primary','blue','red','yellow','green','orange','purple','cyan','pink', 'black', 'violet', 'indigo', 'fuchsia'])) {
        $color = 'primary';
    }
    $text_colour = ($color == 'black') ? 'text-black' : "text-$color-600 dark:bg-dark-800";
    $ring_colour = ($color == 'black') ? 'ring-black' : "ring-$color-500";
    $border_colour = ($color == 'black') ? 'border-slate-500/50' : "border-$color-500/50";
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    if (!$addClearing) $add_clearing = $addClearing;
@endphp

<label class="inline-flex items-center cursor-pointer text-sm @if($disabled) opacity-60 @endif @if($add_clearing) mb-3 @endif {{ $label_css }}">
    <input
            type="{{ $type }}"
            name="{{ $name }}"
            class="{{$text_colour}} size-6 mr-2 rtl:ml-2 disabled:opacity-50 focus:{{$ring_colour}} border-2 {{$border_colour}} focus:ring-opacity-25 bw-checkbox {{$class}}"
            @if($disabled) disabled @endif
            @if($checked) checked @endif
            value="{{ $value }}"
    />
    {!! $label !!}
</label>
