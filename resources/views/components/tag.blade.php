@props([ 
    'label' => '',
    'class' => '',
    'can_close' => false,
    'canClose' => false,
    'outline' => false,
    'add_clearing' => true,
    'addClearing' => true,
    'shade' => 'faint',
    'onclick' => '',
    'id' => uniqid(),
    'add_id_prefix' => true,
    'addIdPrefix' => true,
    'value' => null,
    'selectable' => false,
])
@aware([
    'color' => 'blue',
    'rounded' => false,
    'max' => null,
    'name' => null,
    'required' => false,
    'uppercasing' => true,
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


    $color_weight = [
        'faint' => 200,
        'dark' => 500,
    ];

    $text_color_weight = [
        'faint' => 700,
        'dark' => 50,
    ];

    $rounded_class = ($rounded) ? 'rounded-full' : 'rounded-md';
    $clearing_css = ($add_clearing) ? 'mb-3' : '';
    $bg_border_color_css = ($outline) ? "border border-$color-$color_weight[$shade]" : "bg-$color-$color_weight[$shade] text-$color-$text_color_weight[$shade]";
    $text_color_css = ($outline) ? "text-$color-700 dark:!text-$color-300" : "text-$color-$text_color_weight[$shade]";

    if( (!empty($name) && !empty($value)) ) {
        $can_close = false;
        $bg_border_color_css = "bg-$color-200 hover:bg-$color-500 cursor-pointer selectable bw-$name-$value";
        $text_color_css = "text-$color-700 hover:text-$color-50";
        $selectable = true;
    }
@endphp

<label id="@if($add_id_prefix)bw-@endif{{$id}}" @if($selectable) onclick="selectTag('{{$value}}','{{$name}}')" @endif
class="relative  @if($uppercasing) uppercase @endif @if($tiny) text-[9px] px-[8px] leading-5 @else px-[12px] leading-8 text-[10px] @endif tracking-widest whitespace-nowrap inline-block {{$rounded_class}} {{$clearing_css}} {{$bg_border_color_css}} {{$text_color_css}} {{$class}}">
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