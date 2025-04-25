{{-- format-ignore-start --}}
@props([
     // size of the avatar
     // available sizes are: tiny | small | medium | regular | big | huge | omg
    'size' => config('bladewind.avatars.size', 'regular'),

    // additional css to apply to the avatars group
    'class' => '',

    // should the avatars have a ring around them
    'showRing' => config('bladewind.avatars.show_ring', true),

    // should each avatar have a dot indicator
    'dotted' => config('bladewind.avatars.dotted', false),

    // where should the dot indicator be placed: bottom | top
    'dotPosition' => config('bladewind.avatars.dot_position', 'bottom'),

    // what should be the colour of the dot indicator
    // accepts all available colours in the BladewindUI palette
    // https://bladewindui.com/customize/colours
    'dotColor' => config('bladewind.avatars.dot_color', 'primary'),

    // indicate how many more avatars are there but hidden +23
    'plus' => null,

    // should the avatars be stacked
    'stacked' => config('bladewind.avatars.stacked', true),

    // what happens when user clicks on +23? the default action
    // is to expand to show all avatars ONLY if there are more avatars to display
    // accepts a JS function as a string
    'plusAction' => null,
])
{{-- format-ignore-end --}}

<div class="bw-avatars {{$class}}">
    {{$slot}}
    @if(is_numeric($plus) && $plus > 0)
        <x-bladewind::avatar :size="$size" image="+{{$plus}}" plus_action="{!! $plusAction !!}"/>
    @endif
</div>
