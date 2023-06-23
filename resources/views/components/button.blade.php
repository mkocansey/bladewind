@props([
    // primary, secondary
    'type' => 'primary',
    // tiny, small, regular, big
    'size' => 'regular',
    // for use with css and js if you want to manipulate the button
    'name' => null,
    // will show a spinner
    'has_spinner' => false,
    // for backward compatibility with Laravel 8
    'hasSpinner' => false,
    // will show a spinner
    'show_spinner' => false,
    // for backward compatibility with Laravel 8
    'showSpinner' => false,
    // will make this <button type="submit">
    'can_submit' => false,
    // for backward compatibility with Laravel 8
    'canSubmit' => false,
    // set to true to disable the button
    'disabled' => false,
    // what tags to use for drawing the button <a> or <button>
    // available options are a, button
    'tag' => 'button',
    // red, yellow, green, blue, purple, orange, cyan, black
    'color' => 'blue',
    // overwrite the button text color
    'button_text_css' => '',
    'buttonTextCss' => '',
    'icon' => '',
    'icon_right' => false,
    'iconRight' => false,

    'colouring' => [
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
    $show_spinner = filter_var($show_spinner, FILTER_VALIDATE_BOOLEAN);
    $showSpinner = filter_var($showSpinner, FILTER_VALIDATE_BOOLEAN);
    $has_spinner = filter_var($has_spinner, FILTER_VALIDATE_BOOLEAN);
    $hasSpinner = filter_var($hasSpinner, FILTER_VALIDATE_BOOLEAN);
    $can_submit = filter_var($can_submit, FILTER_VALIDATE_BOOLEAN);
    $canSubmit = filter_var($canSubmit, FILTER_VALIDATE_BOOLEAN);

    if($showSpinner) $show_spinner = $showSpinner;
    if($hasSpinner) $has_spinner = $hasSpinner;
    if($canSubmit) $can_submit = $canSubmit;

    $button_type = $can_submit ? 'submit' : 'button';
    $spinner_css = !$show_spinner ? 'hidden' : '!-mr-2 ml-2';
    $primary_colour = $type === 'primary' ? $colouring['bg'][$color]. ' '. $colouring['focus'][$color]. ' '. $colouring['hover_active'][$color] : '';
    $button_text_css = (!empty($buttonTextCss)) ? $buttonTextCss : $button_text_css;
    $button_text_colour = $button_text_css ?? ($type === 'primary' ? 'text-white hover:text-white' : 'text-black hover:text-black');
    $is_disabled = $disabled ? 'disabled' : '';
    $tag = ($tag !== 'a' && $tag !== 'button') ? 'button' : $tag;
@endphp
<{{ $tag }}
    {{ $attributes->merge(['class' => "bw-button cursor-pointer $size $type $name $primary_colour $is_disabled"]) }}
    @if($disabled)
        disabled
    @endif
    @if($tag == 'button')
        type="{{ $button_type }}"
    @endif
>
    @if(!empty($icon) && !$icon_right)
        <x-bladewind::icon name="{{$icon}}" class="h-5 w-5 !-ml-2 mr-2 dark:text-white/80" />
    @endif
    <span class="grow {{ $button_text_colour }}">{{ $slot }}</span>
    @if(!empty($icon) && $icon_right && !$has_spinner)
        <x-bladewind::icon name="{{$icon}}" class="h-5 w-5 !-mr-2 ml-2 dark:text-white/80" />
    @endif
    @if($has_spinner)
        <x-bladewind::spinner class="{{ $spinner_css }}"></x-bladewind::spinner>
    @endif
</{{$tag}}>
