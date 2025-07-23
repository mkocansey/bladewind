{{-- format-ignore-start --}}
@props([
    'image' => config('bladewind.empty_state.image', '/vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'buttonLabel' => '',
    'message' => '',   // message to display
    // true or false. set to false if you want to fully control the content
    'showImage' => config('bladewind.empty_state.show_image', true),
    'onclick' => '',
    'class' => '',
    'imageCss' => '',
    'imageSize' => 'medium',
    'name' => defaultBladewindName(),
    'forSelect' => false,
    'buttonRadius' => config('bladewind.button.radius'),
])
@php
    $name = parseBladewindName($name);
    $showImage = parseBladewindVariable($showImage);
    $forSelect = parseBladewindVariable($forSelect);
    $size = in_array($imageSize, ['small','medium','large','xl','omg']) ? $imageSize : 'medium';
    $size = ($forSelect) ? 'small' : $size;
    $sizes = [
        'small' => 'h-24',
        'medium' => 'h-36',
        'large' => 'h-64',
        'xl' => 'h-80',
        'omg' => 'h-96',
];
@endphp
{{-- format-ignore-end --}}

<div @class([
  "text-center px-4 pb-6 bw-empty-state $name $class",
  "hidden" => $forSelect
])>
    @if($showImage == 'true')
        <img src="{{ $image }}" class="{{$sizes[$size]}} mx-auto mb-3 {{$imageCss}}"/>
    @endif
    @if($heading != '')
        <div class="text-slate-700 dark:text-dark-300/70 text-2xl pt-4 pb-2 px-4 font-light">{!!$heading!!}</div>
    @endif
    @if($message != '')
        <div class="text-slate-600/70 dark:text-dark-400 px-6">{!!$message!!}</div>
    @endif
    <div class="pt-2 dark:text-dark-400">{!! $slot !!}</div>
    @if($buttonLabel != '')
        <x-bladewind::button
                onclick="{!!$onclick!!}"
                class="block mx-auto my-2"
                radius="{{$buttonRadius}}"
                size="small">{{$buttonLabel}}</x-bladewind::button>
    @endif
</div>
