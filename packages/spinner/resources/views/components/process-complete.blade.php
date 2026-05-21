{{-- format-ignore-start --}}
@props([
    'name' => defaultBladewindName(),
    // available options are passed and failed
    // default is passed and it shows a green thumbsup icon
    // failed process shows a red thumbs down icon
    'processCompletedAs' => 'passed',

    // message to display when process is complete
    'message' => '',

    // text to display on the button when process is complete
    'buttonLabel' => '',
    
    // a javascript function that will be called when the button is clicked on
    'buttonAction' => '',
    'hide' => true,
    'class' => '',
])
@php
    $hide = parseBladewindVariable($hide);
//    $name = parseBladewindName($name);
@endphp
{{-- format-ignore-end --}}

<div class="{{$name}} text-center mt-6 @if($hide) hidden @endif {{$class}}">
    @if($processCompletedAs === 'passed')
        <x-bladewind::icon
                name="hand-thumb-up" type="solid"
                class="h-14 w-14 block mx-auto bg-green-500 text-white rounded-full p-2"/>
    @else
        <x-bladewind::icon
                name="hand-thumb-down" type="solid"
                class="h-14 w-14 block mx-auto bg-red-500 text-white rounded-full p-2"/>
    @endif
    <div class="my-3 text-sm @if($processCompletedAs === 'passed') text-green-600 dark:text-green-700 @else text-red-600 dark:text-red-400 @endif">
        <span class="process-message">{{ $message }}</span>
        <div class="mt-8"></div>
        <x-bladewind::button type="secondary" size="tiny"
                             onclick="{{$buttonAction}}">{{ $buttonLabel }}</x-bladewind::button>
    </div>
</div>