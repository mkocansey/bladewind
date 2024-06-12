@props([ 
    'color' => config('bladewind.tag.color', 'primary'),
    'shade' => config('bladewind.tag.shade', 'faint'),
    'rounded' => config('bladewind.tag.rounded', false),
    'max' => null,
    'name' => null,
    'required' => false,
    'tiny' => config('bladewind.tag.tiny', false),
    'outline' => config('bladewind.tag.outline', false),
    'uppercasing' => config('bladewind.tag.uppercasing', true),
    'selected_value' => '',
    'error_message' => '',
    'error_heading' => '',
    'class' => 'space-x-2 space-y-2',
])
@php
    $rounded = filter_var($rounded, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $tiny = filter_var($tiny, FILTER_VALIDATE_BOOLEAN);
    $max_selection = (!empty($max) && is_numeric($max)) ? $max : 9999999;
@endphp

<div class="bw-tags-{{$name}} {{$class}}">
    <x-bladewind::input
            :name="$name"
            :error_message="$error_message"
            :error_heading="$error_heading"
            data-max-selection="{{$max_selection}}"
            type="hidden"
            class="{{ ($required) ? 'required':''}}"/>
    {{ $slot }}
</div>

@if($selected_value !== '')
    <script>highlightSelectedTags('{{$selected_value}}', '{{$name}}'); </script>
@endif
