@php use Illuminate\Support\Str; @endphp
@props([
    'transparent' => false,
    'percentage' => 0,
    'color' => 'blue',
    'show_percentage_label' => false,
    'showPercentageLabel' => false,
    'show_percentage_label_inline' => true,
    'showPercentageLabelInline' => true,
    'percentage_label_position' => 'top left',
    'percentageLabelPosition' => 'top left',
    'shade' => 'faint',
    'color_weight' => [
        'faint' => 300,
        'dark' => 500,
    ],
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
    //-----------------------------------------------------------------------

    if ($color == 'gray' && $shade == 'faint') $css_override = '!bg-slate-300';
    if(! is_numeric($percentage_label_opacity*1)) $percentage_label_opacity = '100';
@endphp

<!-- https://nikitahl.github.io/svg-circle-progress-generator/ -->
<!-- small // rounded --->
  <svg width="68" height="68" viewBox="-8.5 -8.5 85 85" version="1.1" xmlns="http://www.w3.org/2000/svg" style="transform:rotate(-90deg)">
    <circle r="24" cx="34" cy="34" fill="transparent" stroke="#ebebeb" stroke-width="5" stroke-dasharray="150.72px" stroke-dashoffset="0"></circle>
    <circle r="24" cx="34" cy="34" stroke="#b18cfe" stroke-width="6" stroke-linecap="round" stroke-dashoffset="32px" fill="transparent" stroke-dasharray="150.72px"></circle>
    <text x="27px" y="37px" fill="#874efe" font-size="11px" font-weight="bold" style="transform:rotate(90deg) translate(0px, -64px)">79</text>
  </svg>
    
<!-- big // square -->
  <svg width="184" height="184" viewBox="-23 -23 230 230" version="1.1" xmlns="http://www.w3.org/2000/svg" style="transform:rotate(-90deg)">
    <circle r="82" cx="92" cy="92" fill="transparent" stroke="#ebebeb" stroke-width="21" stroke-dasharray="514.96px" stroke-dashoffset="0"></circle>
    <circle r="82" cx="92" cy="92" stroke="#b18cfe" stroke-width="21" stroke-linecap="butt" stroke-dashoffset="448px" fill="transparent" stroke-dasharray="514.96px"></circle>
    <text x="86px" y="95px" fill="#874efe" font-size="11px" font-weight="bold" style="transform:rotate(90deg) translate(0px, -180px)">13</text>
  </svg>
<!-- big // rounded -->
  <svg width="184" height="184" viewBox="-23 -23 230 230" version="1.1" xmlns="http://www.w3.org/2000/svg" style="transform:rotate(-90deg)">
    <circle r="82" cx="92" cy="92" fill="transparent" stroke="#ebebeb" stroke-width="21" stroke-dasharray="514.96px" stroke-dashoffset="0"></circle>
    <circle r="82" cx="92" cy="92" stroke="#b18cfe" stroke-width="21" stroke-linecap="round" stroke-dashoffset="448px" fill="transparent" stroke-dasharray="514.96px"></circle>
    <text x="86px" y="95px" fill="#874efe" font-size="11px" font-weight="bold" style="transform:rotate(90deg) translate(0px, -180px)">13</text>
  </svg>
    


















<div class="bw-progress-bar {{$class}}">
    @if($show_percentage_label &&
        !$show_percentage_label_inline &&
        Str::contains($percentage_label_position, 'top'))
    <div class="text-xs tracking-wider {{str_replace('top ','text-', $percentage_label_position)}}">
        {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
    </div>
    @endif
    <div class="@if(!$transparent) bg-slate-200/70 dark:bg-slate-800 w-full @endif mt-1 my-2 rounded-full">
        <div style="width: {{$percentage}}%" class="text-center py-1 bg-{{$color}}-{{$color_weight[$shade]}} {{$css_override}} rounded-full bar-width animate__animated animate__fadeIn {{$bar_class}}">
            @if($show_percentage_label && $show_percentage_label_inline)<span class="text-{{$color}}-{{$text_color_weight[$shade]}} px-2 text-xs">
            {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
            </span>@endif
        </div>
    </div>
    @if($show_percentage_label &&
        !$show_percentage_label_inline &&
        Str::contains($percentage_label_position, 'bottom'))
    <div class="text-xs tracking-wider {{str_replace('bottom ','text-', $percentage_label_position)}}">
        {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
    </div>
    @endif
</div>