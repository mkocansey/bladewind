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

    // primary, secondary, red, yellow, green, blue, purple, orange, cyan, black
    'color' => '',

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
    'border_width' => 2, //border-2, border-4, border-8

    // thickness of the ring shown on focus
    'ring_width' => '', // ring, ring-1, ring-2, ring-4, ring-8

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

	$color = (!empty($color)) ? $color : $type;
    $outline_colour = "border-$color-500 focus:ring-$color-500 hover:border-$color-600 active:!border-$color-700 text-$color-500 hover:text-$color-700 %s";
    $button_colour = "!bg-$color-500 focus:ring-$color-500 hover:!bg-$color-700 active:!bg-$color-700 %s";
    if($color == 'black') {
        $outline_colour = preg_replace('/-\d+/', '', $outline_colour);
        $button_colour = preg_replace('/-\d+/', '', $button_colour);
    }
    $button_type = ($can_submit) ? 'submit' : 'button';
    $spinner_css =  sprintf(($outline ? 'text-gray-600 dark:text-white %s' : 'text-white %s'), (!$show_spinner) ?  'hidden' : '');
    $focus_ring_width = ($ring_width !== '' && in_array((int)$ring_width, [1,2,4,8])) ? '-'.$ring_width : '';
    $focus_ring_css = (!$show_focus_ring) ? 'focus:ring-0 focus:outline-' : 'focus:ring'.$focus_ring_width;
    $border_width = ' border-'.$border_width;
    $primary_colour_css = (($outline) ?
        sprintf($outline_colour,$focus_ring_css.$border_width) :
        sprintf($button_colour,$focus_ring_css));
    $radius_css = $roundness[$radius] ?? 'rounded-full';
    $button_text_css = (!empty($buttonTextCss)) ? $buttonTextCss : $button_text_css;
    $button_text_colour = (!empty($button_text_css)) ? $button_text_css : 'text-white hover:text-white';
    $disabled_css = $disabled ? 'disabled' : 'cursor-pointer';
    $outline_css = ($outline) ? 'outlined '.$border_width : '';
    $tag = ($tag !== 'a' && $tag !== 'button') ? 'button' : $tag;
    $base_button_css = ($circular) ? 'bw-button-circle' : 'bw-button '.(($uppercasing) ? 'uppercase ' : '');
    $merged_attributes = $attributes->merge(['class' => "$base_button_css $size $type $name $primary_colour_css $disabled_css $radius_css $outline_css"]);
    $icon_css = ($circular) ? $icon_size[$size] : 'h-5 w-5 dark:text-white/80 ' . ((!$icon_right) ? '!-ml-2 rtl:!-mr-2 !mr-2 rtl:!ml-2' : '!-mr-2 rtl:!-ml-2 !ml-2 rtl:!mr-2');
@endphp

<{{ $tag }} {{ $merged_attributes }} @if($disabled) disabled @endif @if($tag == 'button') type="{{ $button_type }}" @endif >
    @if(!empty($icon) && !$icon_right)
        <x-bladewind::icon :name="$icon" :class="$icon_css" />
    @endif
    <span class="grow {{ $button_text_css }}">{{ $slot }}</span>
    @if(!empty($icon) && $icon_right && !$has_spinner)
        <x-bladewind::icon :name="$icon" :class="$icon_css" />
    @endif
    @if($has_spinner)
        <x-bladewind::spinner class="h-4 w-4 !-mr-2 rtl:!-ml-2 !ml-2 rtl:!mr-2 {{ $spinner_css }}" />
    @endif
</{{$tag}}>
