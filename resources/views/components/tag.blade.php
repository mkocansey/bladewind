@props([ 
    'label' => '',
    'class' => '',
    'can_close' => config('bladewind.tag.can_close', false),
    'canClose' => config('bladewind.tag.can_close', false),
    'add_clearing' => config('bladewind.tag.add_clearing', true),
    'addClearing' => config('bladewind.tag.add_clearing', true),
    'onclick' => '',
    'id' => uniqid(),
    'add_id_prefix' => true,
    'addIdPrefix' => true,
    'value' => null,
    'selectable' => false,
])
@aware([
    'shade' => config('bladewind.tag.shade', 'faint'),
    'color' => config('bladewind.tag.color', 'primary'),
    'rounded' => config('bladewind.tag.rounded', false),
    'outline' => config('bladewind.tag.outline', false),
    'max' => null,
    'name' => null,
    'required' => false,
    'uppercasing' => config('bladewind.tag.uppercasing', true),
    'tiny' => false,
])
@php
    // reset variables for Laravel 8 support
    $can_close = filter_var($can_close, FILTER_VALIDATE_BOOLEAN);
    $canClose = filter_var($canClose, FILTER_VALIDATE_BOOLEAN);
    $add_id_prefix = filter_var($add_id_prefix, FILTER_VALIDATE_BOOLEAN);
    $addIdPrefix = filter_var($addIdPrefix, FILTER_VALIDATE_BOOLEAN);
    $rounded = filter_var($rounded, FILTER_VALIDATE_BOOLEAN);
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    $outline = filter_var($outline, FILTER_VALIDATE_BOOLEAN);
    $tiny = filter_var($tiny, FILTER_VALIDATE_BOOLEAN);
    $uppercasing = filter_var($uppercasing, FILTER_VALIDATE_BOOLEAN);
    if ($canClose) $can_close = $canClose;
    if (!$addIdPrefix) $add_id_prefix = $addIdPrefix;


    $colour_weight = [
        'faint' => [ 'bg' => '200/80', 'border' => 200 ],
        'dark' => [ 'bg' => 500, 'border' => '500/50' ],
    ];

    $text_colour_weight = [
        'faint' => 600,
        'dark' => 50,
    ];

    $rounded_class = ($rounded) ? 'rounded-full' : 'rounded-md';
    $clearing_css = ($add_clearing) ? 'mb-3' : '';
    $bg_colour_weight = $colour_weight[$shade]['bg'];
    $border_colour_weight = $colour_weight[$shade]['border'];
    $bg_border_colour_css = ($outline) ?
        "border border-$color-$border_colour_weight" :
        "bg-$color-$bg_colour_weight text-$color-$text_colour_weight[$shade]";
    $text_color_css = ($outline) ? "text-$color-600 dark:!text-$color-300" : "text-$color-$text_colour_weight[$shade]";
    if( (!empty($name) && !empty($value)) ) {
        $can_close = false;
        $bg_border_colour_css = "bg-$color-200/80 hover:bg-$color-600 cursor-pointer selectable bw-$name-$value";
        $text_color_css = "text-$color-600 hover:text-$color-50";
        $selectable = true;
    }
@endphp

<label id="@if($add_id_prefix)bw-@endif{{$id}}" @if($selectable) onclick="selectTag('{{$value}}','{{$name}}')" @endif
class="relative  @if($uppercasing) uppercase @endif @if($tiny) text-[9px] px-[8px] leading-5 @else px-[12px] leading-8 text-[10px] @endif tracking-widest whitespace-nowrap inline-block {{$rounded_class}} {{$clearing_css}} {{$bg_border_colour_css}} {{$text_color_css}} {{$class}}">
    {{ $label }}
    @if($can_close)
        <a href="javascript:void(0)" onclick="@if($onclick=='')this.parentElement.remove()@else{!!$onclick!!}@endif">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="-mt-0.5 -mr-1 h-5 w-5 p-1 opacity-70 hover:opacity-100 inline {{$text_color_css}}" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </a>
    @endif
</label>