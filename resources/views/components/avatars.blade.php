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
    'size' => 'regular',

    // additional css to apply to the avatars group
    'class' => '',

    // should the avatars be stacked
    'stacked' => true,

    // should the avatars have a ring around them
    'show_ring' => true,

    // should each avatar have a dot indicator
    'show_dot' => false,

    // where should the dot indicator be placed: bottom | top
    'dot_placement' => 'bottom',

    // what should be the colour of the dot indicator
    // accepts all available colours in the BladewindUI palette
    // https://bladewindui.com/customize/colours
    'dot_color' => 'green',

    // indicate how many more avatars are there but hidden +23
    'plus' => '',

    // how many avatars should be displayed of the total available
    // you can have 20 avatars stacked, but you can opt to display only 10
    // the component will automatically append a. +10
    'show_only' => 0,

    // what happens when user clicks on +23? the default action
    // is to expand to show all avatars ONLY if there are more avatars to display
    // accepts a JS function as a string
    'plus_action' => 'expand'
])
@php
    $stacked = filter_var($stacked, FILTER_VALIDATE_BOOLEAN);;
    $show_dot = filter_var($show_dot, FILTER_VALIDATE_BOOLEAN);;
    $show_ring = filter_var($show_ring, FILTER_VALIDATE_BOOLEAN);;
    $dot_placement = (in_array($dot_placement, ['top','bottom'])) ? $dot_placement : 'bottom';
@endphp
<div class="bw-avatars {{$class}}">
    {{$slot}}
</div>
