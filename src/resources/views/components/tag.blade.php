@props([ 
    'label' => '',
    'color' => 'blue',
    'class' => '',
    'can_close' => 'false',
    'canClose' => 'false',
    'shade' => 'faint',
    'color_weight' => [
        'faint' => 100,
        'dark' => 500,
    ],
    'text_color_weight' => [
        'faint' => 500,
        'dark' => 50,
    ],
    'onclick' => '',
    'id' => uniqid(),
    'add_id_prefix' => 'true',
    'addIdPrefix' => 'true',
])
@php 
    // reset variables for Laravel 8 support
    $can_close = $canClose;
    $add_id_prefix = $addIdPrefix;
@endphp

<span class="bg-red-100/80 bg-yellow-100/80 bg-green-100/80 bg-pink-100/80 bg-cyan-100/80 bg-gray-100/80 bg-blue-100/80 bg-purple-100/80 bg-orange-100/80 bg-red-500/80 bg-yellow-500/80 bg-green-500/80 bg-pink-500/80 bg-gray-500/80 bg-cyan-500/80 bg-blue-500/80 bg-gray-500/80 bg-purple-500/80 bg-orange-500/80 text-red-500 text-yellow-500 text-green-500 bg-gray-500 text-pink-500 text-cyan-500 text-purple-500 text-orange-500 text-red-50 text-yellow-50 text-green-50 text-pink-50 text-cyan-50 text-purple-50 text-gray-50 text-blue-50 text-orange-50 bg-red-200/80 bg-yellow-200/80 bg-green-200/80 bg-pink-200/80 bg-cyan-200/80 bg-gray-200/80 bg-blue-200/80 bg-purple-200/80 bg-orange-200/80 border-red-500 border-yellow-500 border-green-500 border-pink-500 border-gray-500 border-cyan-500 border-blue-500 border-gray-500 border-purple-500 border-orange-500"></span>
<label style="zoom:95%" id="@if($add_id_prefix=='true')bw-@endif{{$id}}" class="text-xs uppercase px-[10px] py-[5px] tracking-widest whitespace-nowrap inline-block bg-{{$color}}-{{$color_weight[$shade]}}/80 text-{{$color}}-{{$text_color_weight[$shade]}} {{$class}}">
{{ $label }}
@if($can_close == 'true')
<a href="javascript:void(0)" onclick="@if($onclick=='')this.parentElement.remove()@else{!!$onclick!!}@endif">
<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 p-1 opacity-70 hover:opacity-100 !-mr-2 inline text-{{$color}}-{{$text_color_weight[$shade]}}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>
</a>
@endif
</label>