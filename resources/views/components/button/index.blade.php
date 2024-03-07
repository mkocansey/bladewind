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

    // should the button be only an outline
    'outline' => false,

    // thickness of outline border
    'border_width' => 4, //border-2, border-4, border-8

    // determines how rounded the button should be
    'radius' => 'full',

    // is this a circular button
    'circular' => false,

    // display button text as uppercase or as user entered
    'uppercasing' => true,

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
        'violet'    => '!bg-violet-600 focus:ring-violet-500 hover:!bg-violet-800 active:!bg-violet-700 %s',
        'indigo'    => '!bg-indigo-600 focus:ring-indigo-500 hover:!bg-indigo-800 active:!bg-indigo-700 %s',
        'fuchsia'   => '!bg-fuchsia-600 focus:ring-fuchsia-500 hover:!bg-fuchsia-800 active:!bg-fuchsia-700 %s',
        'black'     => '!bg-black focus:ring-black hover:!bg-black active:!bg-black %s',
    ],

    // css for the various colours
    'outlining'       => [
        'primary'   => 'border-primary-500 focus:ring-primary-500/70 hover:!border-primary-700 active:!border-primary-700 !text-primary-700 %s',
        'red'       => '!border-red-500 focus:ring-red-500 hover:!border-red-700 active:!border-red-700 !text-red-700 %s',
        'yellow'    => '!border-yellow-500 focus:ring-yellow-500 hover:!border-yellow-700 active:!border-yellow-700 !text-yellow-700 %s',
        'green'     => '!border-green-500 focus:ring-green-500 hover:!border-green-700 active:!border-green-700 !text-green-700 %s',
        'blue'      => '!border-blue-500 focus:ring-blue-500 hover:!border-blue-700 active:!border-blue-700 !text-blue-700 %s',
        'orange'    => '!border-orange-500 focus:ring-orange-500 hover:!border-orange-700 active:!border-orange-700 !text-orange-700 %s',
        'purple'    => '!border-purple-500 focus:ring-purple-500 hover:!border-purple-700 active:!border-purple-700 !text-purple-700 %s',
        'cyan'      => '!border-cyan-500 focus:ring-cyan-500 hover:!border-cyan-700 active:!border-cyan-700 !text-cyan-700 %s',
        'pink'      => '!border-pink-500 focus:ring-pink-500 hover:!border-pink-700 active:!border-pink-700 !text-pink-700 %s',
        'violet'    => '!border-violet-600 focus:ring-violet-500 hover:!border-violet-700 active:!border-violet-700 !text-violet-700 %s',
        'indigo'    => '!border-indigo-600 focus:ring-indigo-500 hover:!border-indigo-700 active:!border-indigo-700 !text-indigo-700 %s',
        'fuchsia'   => '!border-fuchsia-600 focus:ring-fuchsia-500 hover:!border-fuchsia-700 active:!border-fuchsia-700 !text-fuchsia-700 %s',
        'black'     => '!border-black focus:ring-black hover:!border-black active:!border-black !text-black %s',
    ],

    'icon_size' => [
        'tiny' => 'h-7 w-7 p-1.5',
        'small' => '!h-[38px] !w-[38px] p-2.5',
        'regular' => '!h-14 !w-14 p-3.5',
        'big' => '!h-[74px] !w-[74px] p-5',
    ],
])

@php
    $show_spinner = filter_var($show_spinner, FILTER_VALIDATE_BOOLEAN);
    $showSpinner = filter_var($showSpinner, FILTER_VALIDATE_BOOLEAN);
    $has_spinner = filter_var($has_spinner, FILTER_VALIDATE_BOOLEAN);
    $hasSpinner = filter_var($hasSpinner, FILTER_VALIDATE_BOOLEAN);
    $can_submit = filter_var($can_submit, FILTER_VALIDATE_BOOLEAN);
    $canSubmit = filter_var($canSubmit, FILTER_VALIDATE_BOOLEAN);
    $outline = filter_var($outline, FILTER_VALIDATE_BOOLEAN);
    $uppercasing = filter_var($uppercasing, FILTER_VALIDATE_BOOLEAN);
    $show_focus_ring = filter_var($show_focus_ring, FILTER_VALIDATE_BOOLEAN);
    $showFocusRing = filter_var($showFocusRing, FILTER_VALIDATE_BOOLEAN);

    if($showSpinner) $show_spinner = $showSpinner;
    if($hasSpinner) $has_spinner = $hasSpinner;
    if($canSubmit) $can_submit = $canSubmit;
    if(!$showFocusRing) $show_focus_ring = $showFocusRing;

    $button_type = ($can_submit) ? 'submit' : 'button';
    $spinner_css = (!$show_spinner) ? 'hidden' : '';
    $focus_ring_css = (!$show_focus_ring) ? 'focus:!ring-0' : 'focus:!ring';
    $border_width = ' border-'.$border_width;
    $primary_colour_css = ($type == 'primary') ?
        (($outline) ? sprintf($outlining[$color],$focus_ring_css.$border_width) :
        sprintf($colours[$color],$focus_ring_css))
        : '';
    $radius_css = $roundness[$radius] ?? 'rounded-full';
    $button_text_css = (!empty($buttonTextCss)) ? $buttonTextCss : $button_text_css;
    $button_text_colour = $button_text_css ?? ($type === 'primary' ? 'text-white hover:text-white' : 'text-black hover:text-black');
    $disabled_css = $disabled ? 'disabled' : 'cursor-pointer';
    $outline_css = ($outline && $type == 'secondary') ? 'outlined '.$border_width : '';
    $tag = ($tag !== 'a' && $tag !== 'button') ? 'button' : $tag;
    $base_button_css = ($circular) ? 'bw-button-circle' : 'bw-button '.(($uppercasing) ? 'uppercase ' : '');
    $merged_attributes = $attributes->merge(['class' => "$base_button_css $size $type $name $primary_colour_css $disabled_css $radius_css $outline_css"]);
    $icon_css = ($circular) ? $icon_size[$size] : ((!$icon_right) ? 'h-5 w-5 !-ml-2 rtl:!-mr-2 !mr-2 rtl:!ml-2 dark:text-white/80' : 'h-5 w-5 !-mr-2 rtl:!-ml-2 !ml-2 rtl:!mr-2 dark:text-white/80');
@endphp

<{{ $tag }} {{ $merged_attributes }} @if($disabled) disabled @endif @if($tag == 'button') type="{{ $button_type }}" @endif >
    @if(!empty($icon) && !$icon_right)
        <x-bladewind::icon name="{{$icon}}" class="{{ $icon_css }}" />
    @endif
    <span class="grow {{ $button_text_colour }}">{{ $slot }}</span>
    @if(!empty($icon) && $icon_right && !$has_spinner)
        <x-bladewind::icon :name="$icon" :class="$icon_css" />
    @endif
    @if($has_spinner)
        <x-bladewind::spinner class="h-4 w-4 !-mr-2 rtl:!-ml-2 !ml-2 rtl:!mr-2 {{ $spinner_css }}" />
    @endif
</{{$tag}}>