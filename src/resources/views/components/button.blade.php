@props([
    // primary, secondary
    'type' => 'primary',
    // tiny, small, regular, big
    'size' => 'regular',
    // for use with css and js if you want to manipulate the button
    'name' => '', 
    // will show a spinner
    'has_spinner' => 'false', 
    // for backward compatibility with Laravel 8
    'hasSpinner' => 'false',
    // will show a spinner
    'show_spinner' => 'false',
    // for backward compatibility with Laravel 8 
    'showSpinner' => 'false',
    // will make this <button type="submit"> 
    'can_submit' => 'false', 
    // for backward compatibility with Laravel 8 
    'canSubmit' => 'false',
    // set to true to disable the button 
    'disabled' => 'false', 
    // what tag to use for drawing the button <a> or <button>
    // available options are a, button
    'tag' => 'button',
    // red, yellow, green, blue, purple, orange, cyan, black
    'color' => 'blue', 
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
    // reset variables for Laravel 8 support
    $show_spinner = $showSpinner;
    $has_spinner = $hasSpinner;
    $can_submit = $canSubmit;
    //------------------------------------------------------
    
    $button_type = ($can_submit == 'false') ? 'button' : 'submit'; 
    $spinner_css = ($show_spinner == 'true') ? '' : 'hidden'; 
    $primary_color = ($type=='primary') ? $coloring['bg'][$color]. ' '. $coloring['focus'][$color]. ' '. $coloring['hover_active'][$color] : '';
    $button_text_color = ($type=='primary') ? 'text-white hover:text-white' : 'text-black hover:text-black';
    $is_disabled = ($disabled == 'true') ? 'disabled' : '';
    $tag = ($tag != 'a' && $tag != 'button') ? 'button' : $tag;
@endphp
<{{$tag}} 
    {{ $attributes->merge(['class' => "bw-button cursor-pointer $size $type $name $primary_color $is_disabled"]) }}
    @if ($disabled == 'true') disabled="true" @endif
    type="{{$button_type}}">
    <span class="{{$button_text_color}}">{{ $slot }}</span> @if ($has_spinner == 'true') <x-bladewind::spinner css="{{$spinner_css}}"></x-bladewind::spinner> @endif
</{{$tag}}>