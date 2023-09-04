@props([
    // determines which icon to display. Name must match the exact name defined on 
    // https://heroicons.com
    'name' => '',
    // available values are solid and outline. Determines the weight of the icon
    'type' => 'outline',
    // css classes to append to the svg file
    'class' => '',
    // specify directory to load icons from
    'dir' => ''
])
@php 
    $path = 'vendor/bladewind/icons';
    $icons_dir = ($dir !== '') ? $dir : ((! in_array($type, [ 'outline', 'solid' ])) ? "{$path}/outline" : "$path/$type"); 
    $svg_file = file_exists(realpath("$icons_dir/$name.svg")) ? realpath("$icons_dir/$name.svg") : null;
@endphp
@if (!empty($name))
    @if(substr($name, 0,4) === '<svg') {{-- do this for complete svg tags --}}
        {!!$name!!}
    @elseif($svg_file)
        {!! str_replace('<svg', '<svg class="h-6 w-6 inline-block dark:text-dark-500 '.$class.'"', file_get_contents($svg_file)) !!}
    @endif
@endif