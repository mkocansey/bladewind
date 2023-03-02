@php use Illuminate\Support\Str; @endphp
@props([
    'label' => '',
    'percentage' => 0,
    'color' => 'blue',
    'shade' => 'faint',
    'percentage_label_opacity' => '50',
    'percentageLabelOpacity' => '50',
    'class' => '',
])
@php 
    // reset variables for Laravel 8 support
    if( $percentageLabelOpacity !== $percentage_label_opacity) $percentage_label_opacity = $percentageLabelOpacity;
@endphp
<span class="opacity-0 opacity-5 opacity-10 opacity-20 opacity-25 opacity-30 opacity-40 opacity-50 opacity-60 opacity-70 opacity-75 opacity-80 opacity-90 opacity-95 opacity-100"></span>
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