@php use Illuminate\Support\Str; @endphp
@props([
    'transparent' => false,
    'percentage' => 0,
    'color' => 'primary',
    'show_percentage_label' => false,
    'showPercentageLabel' => false,
    'show_percentage_label_inline' => true,
    'showPercentageLabelInline' => true,
    'percentage_label_position' => 'top left',
    'percentageLabelPosition' => 'top left',
    'shade' => 'faint',
    'text_color_weight' => [
        'faint' => 600,
        'dark' => 50,
    ],
    'percentage_prefix' => '',
    'percentagePrefix' => '',
    'percentage_suffix' => '',
    'percentageSuffix' => '',
    'class' => '',
    'css_override' => '',
    'bar_class' => '',
    'barClass' => '',
    'cssOverride' => '',
    'percentage_label_opacity' => '100',
    'percentageLabelOpacity' => '100'
])

@php
    // reset variables for Laravel 8 support
    $show_percentage_label = filter_var($show_percentage_label, FILTER_VALIDATE_BOOLEAN);
    $showPercentageLabel = filter_var($showPercentageLabel, FILTER_VALIDATE_BOOLEAN);
    $show_percentage_label_inline = filter_var($show_percentage_label_inline, FILTER_VALIDATE_BOOLEAN);
    $showPercentageLabelInline = filter_var($showPercentageLabelInline, FILTER_VALIDATE_BOOLEAN);
    $transparent = filter_var($transparent, FILTER_VALIDATE_BOOLEAN);
    if ($showPercentageLabel) $show_percentage_label = $showPercentageLabel;
    if (!$showPercentageLabelInline) $show_percentage_label_inline = $showPercentageLabelInline;
    if ($percentageLabelPosition !== $percentage_label_position) $percentage_label_position = $percentageLabelPosition;
    if ($percentageLabelOpacity !== $percentage_label_opacity) $percentage_label_opacity = $percentageLabelOpacity;
    if ($percentagePrefix !== $percentage_prefix) $percentage_prefix = $percentagePrefix;
    if ($percentageSuffix !== $percentage_suffix) $percentage_suffix = $percentageSuffix;
    if ($cssOverride !== $css_override) $css_override = $cssOverride;
    if ($barClass !== $bar_class) $bar_class = $barClass;
    $bar_color = ($shade == 'dark') ? "bg-$color-500" : "bg-$color-300";
    //-----------------------------------------------------------------------

    if(! is_numeric($percentage_label_opacity*1)) $percentage_label_opacity = '100';
    $color = (!in_array($color, ['red', 'yellow', 'green', 'blue', 'pink', 'cyan', 'gray', 'purple', 'orange', 'violet', 'fuchsia', 'indigo'])) ? 'primary' : $color;
@endphp

<div class="bw-progress-bar {{$class}}">
    @if($show_percentage_label &&
        !$show_percentage_label_inline &&
        Str::contains($percentage_label_position, 'top'))
        <div class="text-xs tracking-wider {{str_replace('top ','text-', $percentage_label_position)}}">
            {{$percentage_prefix}} <span
                    class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
        </div>
    @endif
    <div class="@if(!$transparent) bg-slate-200/70 dark:bg-dark-800 w-full @endif mt-1 my-2 rounded-full">
        <div style="width: {{$percentage}}%"
             class="text-center py-1 {{$bar_color}} {{$css_override}} rounded-full bar-width animate__animated animate__fadeIn {{$bar_class}}">
            @if($show_percentage_label && $show_percentage_label_inline)
                <span class="text-{{$color}}-{{$text_color_weight[$shade]}} dark:text-dark-600 px-2 text-xs">
            {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
            </span>
            @endif
        </div>
    </div>
    @if($show_percentage_label &&
        !$show_percentage_label_inline &&
        Str::contains($percentage_label_position, 'bottom'))
        <div class="text-xs tracking-wider {{str_replace('bottom ','text-', $percentage_label_position)}}">
            {{$percentage_prefix}} <span
                    class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
        </div>
    @endif
</div>