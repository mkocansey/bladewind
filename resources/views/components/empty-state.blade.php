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
])
@php
    $show_image = parseBladewindVariable($showImage);
    $button_label = $buttonLabel;
    $size = in_array($imageSize, ['small','medium','large','xl','omg']) ? $imageSize : 'medium';
    $sizes = [
        'small' => 'h-28',
        'medium' => 'h-40',
        'large' => 'h-64',
        'xl' => 'h-80',
        'omg' => 'h-96',
];
@endphp
<div class="text-center px-4 pb-6 bw-empty-state {{$class}}">
    @if($show_image == 'true')
        <img src="{{ $image }}" class="{{$sizes[$size]}} mx-auto mb-3 {{$imageCss}}"/>
    @endif
    @if($heading != '')
        <div class="text-slate-700 dark:text-dark-400 text-2xl pt-4 pb-3 px-4 font-light">{!!$heading!!}</div>
    @endif
    @if($message != '')
        <div class="text-slate-600/70 dark:text-dark-500 px-6">{!!$message!!}</div>
    @endif
    <div class="pt-2 dark:text-dark-400">{!! $slot !!}</div>
    @if($button_label != '')
        <x-bladewind::button
                onclick="{!!$onclick!!}" class="block mx-auto my-2"
                size="small">{{$button_label}}</x-bladewind::button>
    @endif
</div>
