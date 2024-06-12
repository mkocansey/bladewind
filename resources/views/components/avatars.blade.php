@props([
    /*
    |-------------------------------------------------------------------------
    | AVATAR COMPONENT (https://bladewindui.com/component/avatar)
    |-------------------------------------------------------------------------
    |
    | this component is different from avatar.blade.php
    | this component serves as a container if you wish to have a group of avatars
    | that need to have the same attributes. You declare them once here, and they
    | cascade to all the individual avatars wrapped in x-bladewind::avatars
    |
     * */
     // size of the avatar
     // available sizes are: tiny | small | medium | regular | big | huge | omg
    'size' => config('bladewind.avatars.size', 'regular'),

    // additional css to apply to the avatars group
    'class' => '',

    // should the avatars have a ring around them
    'show_ring' => config('bladewind.avatars.show_ring', true),

    // should each avatar have a dot indicator
    'dotted' => config('bladewind.avatars.dotted', false),

    // where should the dot indicator be placed: bottom | top
    'dot_position' => config('bladewind.avatars.dot_position', 'bottom'),

    // what should be the colour of the dot indicator
    // accepts all available colours in the BladewindUI palette
    // https://bladewindui.com/customize/colours
    'dot_color' => config('bladewind.avatars.dot_color', 'primary'),

    // indicate how many more avatars are there but hidden +23
    'plus' => null,

    // should the avatars be stacked
    'stacked' => config('bladewind.avatars.stacked', true),

    // how many avatars should be displayed of the total available
    // you can have 20 avatars stacked, but you can opt to display only 10
    // the component will automatically append a. +10
    'show_only' => 0,

    // what happens when user clicks on +23? the default action
    // is to expand to show all avatars ONLY if there are more avatars to display
    // accepts a JS function as a string
    'plus_action' => null,
])

<div class="bw-avatars {{$class}}">
    {{$slot}}
    @if(is_numeric($plus) && $plus > 0)
        <x-bladewind::avatar :size="$size" image="+{{$plus}}" plus_action="{!! $plus_action !!}"/>
    @endif
</div>
