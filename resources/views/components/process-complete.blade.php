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
        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 block mx-auto bg-green-400 text-white rounded-full p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
        </svg>
    @else
        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 block mx-auto bg-red-400 text-white rounded-full p-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
        </svg>
    @endif
    <div class="my-3 text-sm @if($process_completed_as === 'passed') text-green-600 @else text-red-600 @endif">
        <span class="process-message">{{ $message }}</span>
        <div class="mt-8"></div>
        <x-bladewind::button type="secondary" size="tiny" onclick="{{$button_action}}">{{ $button_label }}</x-bladewind::button>
    </div>
</div>