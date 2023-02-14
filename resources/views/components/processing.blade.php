@props([ 
    'name' => 'processing',

    // the process indicator is rendered within the page and so by default
    // its hidden until a process needs to be started
    // you can set this to false to unhide the process indicator on page load
    'hide' => true,
    
    // message to display when the process is running
    'message' => '',
    'class' => '',
])
@php
    $name = preg_replace('/[\s]/', '-', $name);
    $hide = filter_var($hide, FILTER_VALIDATE_BOOLEAN);
@endphp
<div class="{{ $name }} text-center text-sm @if($hide) hidden @endif mt-6 {{$class}}">
    <x-bladewind::spinner />
    <div class="my-3 text-gray-400 process-message">{{ $message }}</div>
</div>