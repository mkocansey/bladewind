@php use Illuminate\Support\Str; @endphp
@props([
    'label' => '',
    'percentage' => 0,
    'color' => config('bladewind.horizontal_line_graph.color', 'primary'),
    'shade' => config('bladewind.horizontal_line_graph.shade', 'faint'),
    'percentage_label_opacity' => config('bladewind.horizontal_line_graph.percentage_label_opacity', 50),
    'percentageLabelOpacity' => config('bladewind.horizontal_line_graph.percentage_label_opacity', 50),
    'class' => '',
])
@php
    // reset variables for Laravel 8 support
    if( $percentageLabelOpacity !== $percentage_label_opacity) $percentage_label_opacity = $percentageLabelOpacity;
@endphp
<x-bladewind::progress-bar
        percentage="{{$percentage}}"
        shade="{{$shade}}"
        color="{{$color}}"
        percentage_prefix="{{$label}}"
        show_percentage_label="true"
        show_percentage_label_inline="false"
        percentage_label_position="top left"
        percentage_label_opacity="{{$percentage_label_opacity}}"
        class={{$class}} />