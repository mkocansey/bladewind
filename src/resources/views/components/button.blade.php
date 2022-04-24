@props([
    'type' => 'primary', // primary, secondary
    'size' => 'regular', // tiny, small, regular, big
    'name' => '', // for use with css and js if you want to manipulate the button
    'has_spinner' => 'false', // will show a spinner
    'show_spinner' => 'false', // will show a spinner
    'can_submit' => 'false', // will make this <button type="submit">
    'onclick' => '', // a function to call onclick on the button
    'disabled' => 'false', // set to true to disable the button
    'css' => '',
    'color' => 'blue', // red, yellow, green, blue, purple, orange, cyan, black
    'coloring' => [
        'bg' => [
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
            'green' => 'bg-emerald-500',
            'blue' => 'bg-blue-500',
            'orange' => 'bg-orange-500',
            'purple' => 'bg-purple-500',
            'cyan' => 'bg-cyan-500',
            'pink' => 'bg-pink-500',
            'black' => 'bg-black',
        ],
        'focus' => [
            'red' => 'focus:ring-red-500',
            'yellow' => 'focus:ring-yellow-500',
            'green' => 'focus:ring-emerald-500',
            'blue' => 'focus:ring-blue-500',
            'orange' => 'focus:ring-orange-500',
            'purple' => 'focus:ring-purple-500',
            'cyan' => 'focus:ring-cyan-500',
            'pink' => 'focus:ring-pink-500',
            'black' => 'focus:ring-black',
        ],
        'hover_active' => [
            'red' => 'hover:bg-red-700 active:bg-red-700',
            'yellow' => 'hover:bg-yellow-700 active:bg-yellow-700',
            'green' => 'hover:bg-emerald-700 active:bg-emerald-700',
            'blue' => 'hover:bg-blue-700 active:bg-blue-700',
            'orange' => 'hover:bg-orange-700 active:bg-orange-700',
            'purple' => 'hover:bg-purple-700 active:bg-purple-700',
            'cyan' => 'hover:bg-cyan-700 active:bg-cyan-700',
            'pink' => 'hover:bg-pink-700 active:bg-pink-700',
            'black' => 'hover:bg-black active:bg-black',
        ],
    ]
])
@php 
    $button_type = ($can_submit == 'false') ? 'button' : 'submit'; 
    $spinner_css = ($show_spinner == 'true') ? '' : 'hidden'; 
@endphp
<button 
    @if ($onclick !== '') onclick="{!! $onclick !!}" @endif 
    @if ($disabled == 'true') disabled="true" @endif
    type="{{$button_type}}"
    class="bw-button {{$size}} {{$type}} {{$name}} {{$css}} @if($type=='primary'){{$coloring['bg'][$color]}} {{$coloring['focus'][$color]}} {{$coloring['hover_active'][$color]}}@endif @if ($disabled == 'true')disabled @endif">
    <span>{{ $slot }}</span> @if ($has_spinner == 'true') <x-bladewind::spinner css="{{$spinner_css}}"></x-bladewind::spinner> @endif
</button>