@props([ 
    'label' => '',
    'color' => 'blue',
    'class' => '',
    'can_close' => false,
    'canClose' => false,
    'rounded' => false,
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
    if ($canClose) $can_close = $canClose;
    if (!$addIdPrefix) $add_id_prefix = $addIdPrefix;
    $rounded_class = ($rounded) ? 'rounded-full' : 'rounded-md';
    $clearing_css = ($add_clearing) ? 'mb-3' : '';
@endphp
<span class="bg-red-200 bg-yellow-200 bg-green-200 bg-pink-200 bg-cyan-200 bg-gray-200 bg-blue-200 bg-purple-200 bg-orange-200"></span>
<span class="bg-red-300 bg-yellow-300 bg-green-300 bg-pink-300 bg-cyan-300 bg-gray-300 bg-blue-300 bg-purple-300 bg-orange-300 bg-red-500 bg-yellow-500 bg-green-500 bg-pink-500 bg-gray-500 bg-cyan-500 bg-blue-500 bg-gray-500 bg-purple-500 bg-orange-500 text-red-500 text-yellow-500 text-green-500 bg-gray-500 text-pink-500 text-cyan-500 text-purple-500 text-orange-500 text-red-50 text-yellow-50 text-green-50 text-pink-50 text-cyan-50 text-purple-50 text-gray-50 text-blue-50 text-orange-50 bg-red-200 bg-yellow-200 bg-green-200 bg-pink-200 bg-cyan-200 bg-gray-200 bg-blue-200 bg-purple-200 bg-orange-200 border-red-500 border-yellow-500 border-green-500 border-pink-500 border-gray-500 border-cyan-500 border-blue-500 border-gray-500 border-purple-500 border-orange-500"></span>
<label id="@if($add_id_prefix)bw-@endif{{$id}}" class="relative text-[10px] uppercase px-[12px] tracking-widest whitespace-nowrap inline-block {{$rounded_class}} {{$clearing_css}} bg-{{$color}}-{{$color_weight[$shade]}} text-{{$color}}-{{$text_color_weight[$shade]}} {{$class}}">
{{ $label }}
@if($can_close)
<a href="javascript:void(0)" onclick="@if($onclick=='')this.parentElement.remove()@else{!!$onclick!!}@endif">
<svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5 -mr-1 h-5 w-5 p-1 opacity-70 hover:opacity-100 inline text-{{$color}}-{{$text_color_weight[$shade]}}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>
</a>
@endif
</label>