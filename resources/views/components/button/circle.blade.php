@props([
    // primary, secondary
    'type' => 'primary',
    // tiny, small, regular, big
    'size' => 'regular',
    // for use with css and js if you want to manipulate the button
    'name' => null,
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
    'icon' => '',
    'radius' => 'full',
    'button_text_css' => null,

    // should a ring be shown around the button
    'show_focus_ring' => true,
    'showFocusRing' => true,
    'tooltip' => '',

    // css for the various colours
    'colours'       => [
        'primary'   => '!bg-primary-500 focus:ring-primary-500/40 hover:!bg-primary-700 active:!bg-primary-700 %s',
        'red'       => '!bg-red-500 focus:ring-red-500/40 hover:!bg-red-700 active:!bg-red-700 %s',
        'yellow'    => '!bg-yellow-500 focus:ring-yellow-500/50 hover:!bg-yellow-700 active:!bg-yellow-700 %s',
        'green'     => '!bg-green-500 focus:ring-green-500/50 hover:!bg-green-700 active:!bg-green-700 %s',
        'blue'      => '!bg-blue-500 focus:ring-blue-500/50 hover:!bg-blue-700 active:!bg-blue-700 %s',
        'orange'    => '!bg-orange-500 focus:ring-orange-500/50 hover:!bg-orange-700 active:!bg-orange-700 %s',
        'purple'    => '!bg-purple-500 focus:ring-purple-500/50 hover:!bg-purple-700 active:!bg-purple-700 %s',
        'cyan'      => '!bg-cyan-500 focus:ring-cyan-500/50 hover:!bg-cyan-700 active:!bg-cyan-700 %s',
        'pink'      => '!bg-pink-500 focus:ring-pink-500/50 hover:!bg-pink-700 active:!bg-pink-700 %s',
        'black'     => '!bg-black focus:ring-black/50 hover:!bg-black active:!bg-black %s',
    ],
    'icon_size' => [
        'tiny' => 'h-7 w-7 p-1.5',
        'small' => '!h-[38px] !w-[38px] p-2.5',
        'regular' => '!h-14 !w-14 p-3.5',
        'big' => '!h-[74px] !w-[74px] p-5',
    ],
])
@php
    $can_submit = filter_var($can_submit, FILTER_VALIDATE_BOOLEAN);
    $canSubmit = filter_var($canSubmit, FILTER_VALIDATE_BOOLEAN);
    $show_focus_ring = filter_var($show_focus_ring, FILTER_VALIDATE_BOOLEAN);
    $showFocusRing = filter_var($showFocusRing, FILTER_VALIDATE_BOOLEAN);

    if($canSubmit) $can_submit = $canSubmit;
    if(!$showFocusRing) $show_focus_ring = $showFocusRing;

    $button_type = ($can_submit) ? 'submit' : 'button';
    $focus_ring_css = (!$show_focus_ring) ? 'focus:!ring-0' : 'focus:!ring';
    $primary_colour_css = ($type == 'primary') ? sprintf($colours[$color], $focus_ring_css) : '';
    $radius_css = $roundness[$radius] ?? 'rounded-full';
    $button_text_colour = $button_text_css ?? ($type === 'primary' ? 'text-white hover:text-white' : 'text-black hover:text-black');
    $disabled_css = $disabled ? 'disabled' : ' cursor-pointer ';
    $tag = ($tag !== 'a' && $tag !== 'button') ? 'button' : $tag;
    $merged_attributes = $attributes->merge(['class' => "bw-button-circle $size $type $name $primary_colour_css $disabled_css $radius_css"]);
@endphp
<{{ $tag }} title="{{$tooltip}}" {{ $merged_attributes }} @if($disabled) disabled @endif @if($tag == 'button') type="{{ $button_type }}" @endif>
    @if(!empty($icon))
        <x-bladewind::icon name="{{$icon}}" class="{{$icon_size[$size]}} {{$button_text_colour}} !-m-0" />
    @endif
</{{$tag}}>
