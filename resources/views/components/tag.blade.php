@props([ 
    'label' => '',
//    'color' => 'blue',
    'class' => '',
    'can_close' => false,
    'canClose' => false,
//    'rounded' => false,
    'outline' => false,
    'add_clearing' => true,
    'addClearing' => true,
    'shade' => 'faint',
    'color_weight' => [
        'faint' => 200,
        'dark' => 500,
    ],
    'text_color_weight' => [
        'faint' => 500,
        'dark' => 50,
    ],
    'onclick' => '',
    'id' => uniqid(),
    'add_id_prefix' => true,
    'addIdPrefix' => true,
    'value' => null,
//    'name' => null,
    'selectable' => false,
])
@aware([
    'color' => 'blue',
    'rounded' => false,
    'max' => null,
    'name' => null,
    'required' => false,
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
    if ($canClose) $can_close = $canClose;
    if (!$addIdPrefix) $add_id_prefix = $addIdPrefix;

    $rounded_class = ($rounded) ? 'rounded-full' : 'rounded-md';
    $clearing_css = ($add_clearing) ? 'mb-3' : '';
    $bg_border_color_css = ($outline) ? "border border-$color-$color_weight[$shade] text-$color-500" : "bg-$color-$color_weight[$shade] text-$color-$text_color_weight[$shade]";
    $text_color_css = ($outline) ? "text-$color-500" : "text-$color-$text_color_weight[$shade]";

    if( (!empty($name) && !empty($value)) ) {
        $can_close = false;
        $bg_border_color_css = "bg-$color-200 hover:bg-$color-500 cursor-pointer selectable bw-$name-$value";
        $text_color_css = "text-$color-500 hover:text-$color-50";
        $selectable = true;
    }
@endphp

<label id="@if($add_id_prefix)bw-@endif{{$id}}" @if($selectable) onclick="selectTag('{{$value}}','{{$name}}')"  @endif
       class="relative text-[10px] uppercase px-[12px] leading-8 tracking-widest whitespace-nowrap inline-block {{$rounded_class}} {{$clearing_css}} {{$bg_border_color_css}} {{$text_color_css}} {{$class}}">
    {{ $label }}
    @if($can_close)
    <a href="javascript:void(0)" onclick="@if($onclick=='')this.parentElement.remove()@else{!!$onclick!!}@endif">
        <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5 -mr-1 h-5 w-5 p-1 opacity-70 hover:opacity-100 inline {{$text_color_css}}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </a>
    @endif
</label>
{{--<span class="border-red-200 border-yellow-200 border-green-200 border-pink-200 border-cyan-200 border-gray-200 border-blue-200 border-purple-200 border-orange-200"></span><span class="bg-red-200 hover:bg-red-500 bg-yellow-200 hover:bg-yellow-500 bg-green-200 hover:bg-green-500 bg-pink-200 hover:bg-pink-500 bg-cyan-200 hover:bg-cyan-500 bg-gray-200 hover:bg-gray-500 bg-blue-200 hover:bg-blue-500 bg-purple-200 hover:bg-purple-500 bg-orange-200 hover:bg-orange-500 bg-red-500 bg-yellow-500 bg-green-500 bg-pink-500 bg-gray-500 bg-cyan-500 bg-blue-500 bg-gray-500 bg-purple-500 bg-orange-500 text-red-500 text-yellow-500 text-green-500 bg-gray-500 text-pink-500 text-cyan-500 text-purple-500 text-orange-500 text-red-50 text-yellow-50 text-green-50 text-pink-50 text-cyan-50 text-purple-50 text-gray-50 text-blue-50 text-orange-50 hover:text-red-50 hover:text-yellow-50 hover:text-green-50 hover:text-pink-50 hover:text-cyan-50 hover:text-purple-50 hover:text-gray-50 hover:text-blue-50 hover:text-orange-50 bg-red-200 bg-yellow-200 bg-green-200 bg-pink-200 bg-cyan-200 bg-gray-200 bg-blue-200 bg-purple-200 bg-orange-200 border-red-500 border-yellow-500 border-green-500 border-pink-500 border-gray-500 border-cyan-500 border-blue-500 border-gray-500 border-purple-500 border-orange-500"></span>--}}