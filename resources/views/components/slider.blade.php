@props([
    'name' => 'bw_'.uniqid(),
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'selected' => 0,
    'max_selected' => '',
    'color' => 'primary',
    'show_values' => config('bladewind.slider.show_values', true),
    'range' => config('bladewind.slider.range', false),
    'class' => '',
])

@php
    $show_values = filter_var($show_values, FILTER_VALIDATE_BOOLEAN);
    $range = filter_var($range, FILTER_VALIDATE_BOOLEAN);

    $step = (is_numeric($step) && $step > 0) ? $step : 1;
    $min = (is_numeric($min) && $min >= 0) ? $min : 0;
    $max = (is_numeric($max) && $max >= 0) ? $max : 100;
    $selected = (is_numeric($selected) && $selected >= 0) ? $selected : 0;
    $selected = ($min != 0 && $selected== 0) ? $min : $selected;
    $selected = ($selected > $max) ? $max : $selected;

    $color = (!in_array($color, ['primary', 'red', 'yellow', 'green', 'blue', 'pink', 'cyan', 'gray', 'black', 'purple', 'orange', 'violet', 'fuchsia', 'indigo'])) ? 'primary' : $color;
@endphp
<div class="bw-slider-container w-full relative {{$class}}">
    <input type="range"
           min="{{$min}}"
           max="{{$max}}"
           value="{{$selected}}"
           step="{{$step}}"
           class="bw-slider min-slider-{{$name}} {{$color}}"/>
    @if($range)
        <input type="range"
               min="{{$min}}"
               max="{{$max}}"
               value="{{$max_selected}}"
               step="{{$step}}"
               class="bw-slider max-slider-{{$name}} {{$color}}"/>
    @endif

    <div class="text-center pt-5 text-sm font-semibold @if(!$show_values) hidden @endif">
        <span class="slider-selection-{{$name}}">{{$selected}}
            @if($range)
                - {{$max_selected}}
            @endif
        </span>
    </div>
    <input type="hidden"
           name="{{$name}}"
           id="{{$name}}"
           class="slider-selection-{{$name}}-input bw-slider-{{$name}}"
           value="{{$selected}}@if($range),{{$max_selected}}@endif"/>
</div>

<script>
    const minSlider_{{$name}} = domEl('.min-slider-{{$name}}');
    const maxSlider_{{$name}} = domEl('.max-slider-{{$name}}');
    const sliderValue_{{$name}} = domEl('.slider-selection-{{$name}}');
    const sliderInput_{{$name}} = domEl('.slider-selection-{{$name}}-input');

    minSlider_{{$name}}.oninput = function () {
        if (parseInt(minSlider_{{$name}}.value) > parseInt(maxSlider_{{$name}}.value) - 1) {
            minSlider_{{$name}}.value = parseInt(maxSlider_{{$name}}.value) - 1;
        }
        @if($range)
            sliderValue_{{$name}}.innerHTML = `${minSlider_{{$name}}.value} - ${maxSlider_{{$name}}.value}`;
        sliderInput_{{$name}}.value = `${minSlider_{{$name}}.value},${maxSlider_{{$name}}.value}`;
        @else
            sliderValue_{{$name}}.innerHTML = `${minSlider_{{$name}}.value}`;
        sliderInput_{{$name}}.value = `${minSlider_{{$name}}.value}`;
        @endif
    };
    @if($range)
        maxSlider_{{$name}}.oninput = function () {
        if (parseInt(maxSlider_{{$name}}.value) < parseInt(minSlider_{{$name}}.value) + 1) {
            maxSlider_{{$name}}.value = parseInt(minSlider_{{$name}}.value) + 1;
        }
        sliderValue_{{$name}}.innerHTML = `${minSlider_{{$name}}.value} - ${maxSlider_{{$name}}.value}`;
        sliderInput_{{$name}}.value = `${minSlider_{{$name}}.value},${maxSlider_{{$name}}.value}`;
    };
    @endif

</script>