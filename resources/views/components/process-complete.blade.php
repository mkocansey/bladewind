@props([ 
    'name' => 'process-complete',
    // available options are passed and failed
    // default is passed and it shows a green thumbsup icon
    // failed process shows a red thumbs down icon
    'process_completed_as' => 'passed',
    'processCompletedAs' => 'passed',

    // message to display when process is complete
    'message' => '',

    // text to display on the button when process is complete
    'button_label' => '',
    'buttonLabel' => '',
    
    // a javascript function that will be called when the button is clicked on
    'button_action' => '',
    'buttonAction' => '',
    'hide' => true,
    'class' => '',
])
@php
    // reset variables for Laravel 8 support
    if ($processCompletedAs !== $process_completed_as) $process_completed_as = $processCompletedAs;
    if ($buttonLabel !== $button_label) $button_label = $buttonLabel;
    if ($buttonAction !== $button_action) $button_action = $buttonAction;
    $hide = filter_var($hide, FILTER_VALIDATE_BOOLEAN);
    //------------------------------------------------------
    $name = preg_replace('/[\s]/', '-', $name);
@endphp
<div class="{{$name}} text-center mt-6 @if($hide) hidden @endif {{$class}}">
    @if($process_completed_as === 'passed')
        <x-bladewind::icon
                name="hand-thumb-up" type="solid"
                class="h-14 w-14 block mx-auto bg-green-500 text-white rounded-full p-2"/>
    @else
        <x-bladewind::icon
                name="hand-thumb-down" type="solid"
                class="h-14 w-14 block mx-auto bg-red-500 text-white rounded-full p-2"/>
    @endif
    <div class="my-3 text-sm @if($process_completed_as === 'passed') text-green-600 dark:text-green-700 @else text-red-600 dark:text-red-400 @endif">
        <span class="process-message">{{ $message }}</span>
        <div class="mt-8"></div>
        <x-bladewind::button type="secondary" size="tiny"
                             onclick="{{$button_action}}">{{ $button_label }}</x-bladewind::button>
    </div>
</div>