{{-- format-ignore-start --}}
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
    'selectedValue' => '',
    'errorMessage' => '',
    'errorHeading' => '',
    'class' => 'space-x-2 space-y-2',
])
@php
    $rounded = parseBladewindVariable($rounded);
    $required = parseBladewindVariable($required);
    $tiny = parseBladewindVariable($tiny);
    $max_selection = (!empty($max) && is_numeric($max)) ? $max : 9999999;
@endphp
{{-- format-ignore-end --}}

<div class="bw-tags-{{$name}} {{$class}}">
    <x-bladewind::input
            :name="$name"
            :error_message="$errorMessage"
            :error_heading="$errorHeading"
            data-max-selection="{{$max_selection}}"
            type="hidden"
            class="{{ ($required) ? 'required':''}}"/>
    {{ $slot }}
</div>

@if($selectedValue !== '')
    <script>highlightSelectedTags('{{$selectedValue}}', '{{$name}}'); </script>
@endif
