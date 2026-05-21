{{-- format-ignore-start --}}
@props([
    'label' => '',
    'percentage' => 0,
    'color' => config('bladewind.horizontal_line_graph.color', 'primary'),
    'shade' => config('bladewind.horizontal_line_graph.shade', 'faint'),
    'percentageLabelOpacity' => config('bladewind.horizontal_line_graph.percentage_label_opacity', 50),
    'class' => '',
])
{{-- format-ignore-end --}}

<x-bladewind::progress-bar
        percentage="{{$percentage}}"
        shade="{{$shade}}"
        color="{{$color}}"
        percentage_prefix="{{$label}}"
        show_percentage_label="true"
        show_percentage_label_inline="false"
        percentage_label_position="top left"
        percentage_label_opacity="{{$percentageLabelOpacity}}"
        class={{$class}} />