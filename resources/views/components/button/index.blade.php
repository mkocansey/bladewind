@props([
    // this has nothing to do HTML's button types
    // this defines if the button is primary or secondary
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
    'color' => 'primary',

    // overwrite the button text color
    'button_text_css' => '',
    'buttonTextCss' => '',

    // icon to display to the left of the button
    'icon' => '',
    'icon_right' => false,
    'iconRight' => false,

    // should a ring be shown around the button
    'show_focus_ring' => true,
    'showFocusRing' => true,

    // determines how rounded the button should be
    'radius' => 'full',

    // css fpr various radii
    'roundness'     => [
        'none'      => 'rounded-none',
        'small'     => 'rounded-md',
        'medium'    => 'rounded-xl',
        'full'      => 'rounded-full',
    ],

    // css for the various colours
    'colours'       => [
        'primary'   => '!bg-primary-500 focus:ring-primary-500/70 hover:!bg-primary-700 active:!bg-primary-700 %s',
        'red'       => '!bg-red-500 focus:ring-red-500 hover:!bg-red-700 active:!bg-red-700 %s',
        'yellow'    => '!bg-yellow-500 focus:ring-yellow-500 hover:!bg-yellow-700 active:!bg-yellow-700 %s',
        'green'     => '!bg-green-500 focus:ring-green-500 hover:!bg-green-700 active:!bg-green-700 %s',
        'blue'      => '!bg-blue-500 focus:ring-blue-500 hover:!bg-blue-700 active:!bg-blue-700 %s',
        'orange'    => '!bg-orange-500 focus:ring-orange-500 hover:!bg-orange-700 active:!bg-orange-700 %s',
        'purple'    => '!bg-purple-500 focus:ring-purple-500 hover:!bg-purple-700 active:!bg-purple-700 %s',
        'cyan'      => '!bg-cyan-500 focus:ring-cyan-500 hover:!bg-cyan-700 active:!bg-cyan-700 %s',
        'pink'      => '!bg-pink-500 focus:ring-pink-500 hover:!bg-pink-700 active:!bg-pink-700 %s',
        'black'     => '!bg-black focus:ring-black hover:!bg-black active:!bg-black %s',
    ],
])

@php
    $show_spinner = filter_var($show_spinner, FILTER_VALIDATE_BOOLEAN);
    $showSpinner = filter_var($showSpinner, FILTER_VALIDATE_BOOLEAN);
    $has_spinner = filter_var($has_spinner, FILTER_VALIDATE_BOOLEAN);
    $hasSpinner = filter_var($hasSpinner, FILTER_VALIDATE_BOOLEAN);
    $can_submit = filter_var($can_submit, FILTER_VALIDATE_BOOLEAN);
    $canSubmit = filter_var($canSubmit, FILTER_VALIDATE_BOOLEAN);
    $show_focus_ring = filter_var($show_focus_ring, FILTER_VALIDATE_BOOLEAN);
    $showFocusRing = filter_var($showFocusRing, FILTER_VALIDATE_BOOLEAN);

    if($showSpinner) $show_spinner = $showSpinner;
    if($hasSpinner) $has_spinner = $hasSpinner;
    if($canSubmit) $can_submit = $canSubmit;
    if(!$showFocusRing) $show_focus_ring = $showFocusRing;

    $button_type = ($can_submit) ? 'submit' : 'button';
    $spinner_css = (!$show_spinner) ? 'hidden' : '';
    $focus_ring_css = (!$show_focus_ring) ? 'focus:!ring-0' : 'focus:!ring';
    $primary_colour_css = ($type == 'primary') ? sprintf($colours[$color],$focus_ring_css) : '';
    $radius_css = $roundness[$radius] ?? 'rounded-full';
    $button_text_css = (!empty($buttonTextCss)) ? $buttonTextCss : $button_text_css;
    $button_text_colour = $button_text_css ?? ($type === 'primary' ? 'text-white hover:text-white' : 'text-black hover:text-black');
    $disabled_css = $disabled ? 'disabled' : 'cursor-pointer';
    $tag = ($tag !== 'a' && $tag !== 'button') ? 'button' : $tag;
    $merged_attributes = $attributes->merge(['class' => "bw-button $size $type $name $primary_colour_css $disabled_css $radius_css"]);
@endphp

<{{ $tag }} {{ $merged_attributes }} @if($disabled) disabled @endif @if($tag == 'button') type="{{ $button_type }}" @endif >
    @if(!empty($icon) && !$icon_right)
        <x-bladewind::icon name="{{$icon}}" class="h-5 w-5 !-ml-2 mr-2 dark:text-white/80" />
    @endif
    <span class="grow {{ $button_text_colour }}">{{ $slot }}</span>
    @if(!empty($icon) && $icon_right && !$has_spinner)
        <x-bladewind::icon name="{{$icon}}" class="h-5 w-5 !-mr-2 ml-2 dark:text-white/80" />
    @endif
    @if($has_spinner)
        <x-bladewind::spinner class="!-mr-2 !ml-2 {{ $spinner_css }}" />
    @endif
</{{$tag}}>