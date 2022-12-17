@props([
    'image' => asset('bladewind/images/empty-state.svg'), 
    'heading' => '',
    'button_label' => '', // button will not be displayed if no text is passed
    'buttonLabel' => '',
    'message' => '',   // message to display
    'show_image' => 'true', // true or false. set to false if you want to fully control the content
    'showImage' => 'true',
    'onclick' => '',
    'class' => '',
])
@php 
    // reset variables for Laravel 8 support
    $show_image = $showImage;
    $button_label = $buttonLabel;
@endphp
<div class="text-center px-4 pb-10 bw-empty-state {{$class}}">
    @if($show_image == 'true')<img src="{{ $image }}" class="h-52 mx-auto mb-6" />@endif
    @if($heading != '')<div class="text-slate-700 text-2xl pt-4 pb-3 px-4 font-light">{!!$heading!!}</div>@endif
    @if($message != '')<div class="text-slate-600/70 px-6">{!!$message!!}</div>@endif
    <div class="pt-2">{!! $slot !!}</div>
    @if($button_label != '')
        <x-bladewind::button 
            onclick="{!!$onclick!!}" class="block mx-auto my-4"
            size="small">{{$button_label}}</x-bladewind::button>
    @endif
</div>