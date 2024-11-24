@php use Illuminate\Support\Str; @endphp
@props([
    'transparent' => false,
    'percentage' => 0,
    'color' => 'primary',
    'show_percentage_label' => config('bladewind.progress_bar.show_percentage_label', false),
    'showPercentageLabel' => config('bladewind.progress_bar.show_percentage_label', false),
    'show_percentage_label_inline' => config('bladewind.progress_bar.show_percentage_label_inline', true),
    'showPercentageLabelInline' => config('bladewind.progress_bar.show_percentage_label_inline', true),
    'percentage_label_position' => 'top-left',
    'percentageLabelPosition' => 'top-left',
    'shade' => config('bladewind.progress_bar.shade', 'faint'),
    'percentage_prefix' => '',
    'percentagePrefix' => '',
    'percentage_suffix' => '',
    'percentageSuffix' => '',
    'class' => '',
    'css_override' => '',
    'bar_class' => '',
    'barClass' => '',
    'cssOverride' => '',
    'percentage_label_opacity' => config('bladewind.progress_bar.percentage_label_opacity', 100),
    'percentageLabelOpacity' => config('bladewind.progress_bar.percentage_label_opacity', 100),
    'striped' => false,
    'animated' => false,
])

@php
    // reset variables for Laravel 8 support
    $show_percentage_label = parseBladewindVariable($show_percentage_label);
    $striped = parseBladewindVariable($striped);
    $animated = parseBladewindVariable($animated);
    $showPercentageLabel = parseBladewindVariable($showPercentageLabel);
    $show_percentage_label_inline = parseBladewindVariable($show_percentage_label_inline);
    $showPercentageLabelInline = parseBladewindVariable($showPercentageLabelInline);
    $transparent = parseBladewindVariable($transparent);
    if ($showPercentageLabel) $show_percentage_label = $showPercentageLabel;
    if (!$showPercentageLabelInline) $show_percentage_label_inline = $showPercentageLabelInline;
    if ($percentageLabelPosition !== $percentage_label_position) $percentage_label_position = $percentageLabelPosition;
    if ($percentageLabelOpacity !== $percentage_label_opacity) $percentage_label_opacity = $percentageLabelOpacity;
    if ($percentagePrefix !== $percentage_prefix) $percentage_prefix = $percentagePrefix;
    if ($percentageSuffix !== $percentage_suffix) $percentage_suffix = $percentageSuffix;
    if ($cssOverride !== $css_override) $css_override = $cssOverride;
    if ($barClass !== $bar_class) $bar_class = $barClass;
    if(! is_numeric($percentage_label_opacity*1)) $percentage_label_opacity = '100';

    $colour = defaultBladewindColour($color);
    $bar_colour = ($shade == 'dark') ? "bg-$colour-500" : "bg-$colour-300";
    $percentage_label_position = str_replace(' ', '_', $percentage_label_position);

    $text_colour_weight = [
        'faint' => 600,
        'dark' => 50,
    ];
@endphp

<div class="bw-progress-bar {{$class}}">
    @if($show_percentage_label &&
        !$show_percentage_label_inline &&
        Str::contains($percentage_label_position, 'top'))
        <div class="text-xs tracking-wider {{str_replace('top-','text-', $percentage_label_position)}}">
            {{$percentage_prefix}} <span
                    class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
        </div>
    @endif
    <div class="@if(!$transparent) bg-slate-200/70 dark:bg-dark-800/70 w-full @endif mt-1 my-2 rounded-full">
        <div style="width: {{$percentage}}%"
             class="text-center py-1 {{$bar_colour}} {{$css_override}} relative overflow-hidden h-full rounded-full bar-width animate__animated animate__fadeIn {{$bar_class}}">
            @if($show_percentage_label && $show_percentage_label_inline)
                <span class="text-{{$colour}}-{{$text_colour_weight[$shade]}} dark:text-dark-600 px-2 text-xs">
            {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
            </span>
            @endif
            @if($striped)
                <div class="striped @if($animated) animated @endif absolute inset-0"></div>
            @endif
        </div>
    </div>
    @if($show_percentage_label &&
        !$show_percentage_label_inline &&
        Str::contains($percentage_label_position, 'bottom'))
        <div class="text-xs tracking-wider {{str_replace('bottom-','text-', $percentage_label_position)}}">
            {{$percentage_prefix}} <span
                    class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
        </div>
    @endif
</div>