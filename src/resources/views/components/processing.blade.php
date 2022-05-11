@props([ 
    'name' => 'processing',

    // the process indicator is rendered within the page and so by default
    // its hidden until a process needs to be started
    // you can set this to false to unhide the process indicator on page load
    'hide' => 'true',
    
    // message to display when the process is running
    'message' => '',
])
@php $name = preg_replace('/[\s]/', '-', $name); @endphp
<div class="{{ $name }} text-center text-sm @if($hide == 'true') hidden @endif mt-6">
    <x-bladewind::spinner />
    <div class="my-3 text-gray-400">{{ $message }}</div>
</div>