@php use Illuminate\Support\Str; @endphp
@props([
    'percentage' => 0,
    'color' => 'blue',
    'show_percentage_label' => 'false',
    'showPercentageLabel' => 'false',
    'show_percentage_label_inline' => 'true',
    'showPercentageLabelInline' => 'true',
    'percentage_label_position' => 'top left',
    'percentageLabelPosition' => 'top left',
    'shade' => 'faint',
    'color_weight' => [
        'faint' => 200,
        'dark' => 500,
    ],
    'text_color_weight' => [
        'faint' => 500,
        'dark' => 50,
    ],
    'percentage_prefix' => '',
    'percentagePrefix' => '',
    'percentage_suffix' => '',
    'percentageSuffix' => '',
    'class' => '',
    'css_override' => '',
    'cssOverride' => '',
    'percentage_label_opacity' => '100',
    'percentageLabelOpacity' => '100'
])

@php  
    // reset variables for Laravel 8 support
    $show_percentage_label = $showPercentageLabel;
    $show_percentage_label_inline = $showPercentageLabelInline;
    $percentage_label_position = $percentageLabelPosition;
    $percentage_label_opacity = $percentageLabelOpacity;
    $percentage_prefix = $percentagePrefix;
    $percentage_suffix = $percentageSuffix;
    $css_override = $cssOverride;
    //-----------------------------------------------------------------------

    if ($color == 'gray' && $shade == 'faint') $css_override = '!bg-slate-300';
    if(! is_numeric($percentage_label_opacity*1)) $percentage_label_opacity = '100';
@endphp
<div class="w-[0%] w-[1%] w-[2%] w-[3%] w-[4%] w-[5%] w-[6%] w-[7%] w-[8%] w-[9%] w-[10%] w-[11%] w-[12%] w-[13%] w-[14%] w-[15%] w-[16%] w-[17%] w-[18%] w-[19%] w-[20%] w-[21%] w-[22%] w-[23%] w-[24%] w-[25%] w-[26%] w-[27%] w-[28%] w-[29%] w-[30%] w-[31%] w-[32%] w-[33%] w-[34%] w-[35%] w-[36%] w-[37%] w-[38%] w-[39%] w-[40%] w-[41%] w-[42%] w-[43%] w-[44%] w-[45%] w-[46%] w-[47%] w-[48%] w-[49%] w-[50%] w-[51%] w-[52%] w-[53%] w-[54%] w-[55%] w-[56%] w-[57%] w-[58%] w-[59%] w-[60%] w-[61%] w-[62%] w-[63%] w-[64%] w-[65%] w-[66%] w-[67%] w-[68%] w-[69%] w-[70%] w-[71%] w-[72%] w-[73%] w-[74%] w-[75%] w-[76%] w-[77%] w-[78%] w-[79%] w-[80%] w-[81%] w-[82%] w-[83%] w-[84%] w-[85%] w-[86%] w-[87%] w-[88%] w-[89%] w-[90%] w-[91%] w-[92%] w-[93%] w-[94%] w-[95%] w-[96%] w-[97%] w-[98%] w-[99%] w-[100%]"></div>
<div class="bw-progress-bar {{$class}}">
    @if($show_percentage_label == 'true' && 
        $show_percentage_label_inline == 'false' && 
        Str::contains($percentage_label_position, 'top'))
    <div class="text-xs tracking-wider {{str_replace('top ','text-', $percentage_label_position)}}">
        {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
    </div>
    @endif
    <div class="bg-slate-200/70 w-full mt-1 my-2 rounded-full">
        <div class="w-[{{$percentage}}%] text-center py-1 bg-{{$color}}-{{$color_weight[$shade]}}/80 {{$css_override}} text-{{$color}} rounded-full bar-width animate__animated animate__fadeIn">
            @if($show_percentage_label=='true' && $show_percentage_label_inline=='true')<span class="text-{{$color}}-{{$text_color_weight[$shade]}} px-2 text-xs">{{ $percentage}}%</span>@endif
        </div>
    </div>
    @if($show_percentage_label == 'true' && 
        $show_percentage_label_inline == 'false' && 
        Str::contains($percentage_label_position, 'bottom'))
    <div class="text-xs tracking-wider {{str_replace('bottom ','text-', $percentage_label_position)}}">
        {{$percentage_prefix}} <span class="opacity-{{$percentage_label_opacity}}">{{ $percentage}}%</span> {{$percentage_suffix}}
    </div>
    @endif
</div>