@props([
    // error, warning, success, info
    'type' => 'info',
    // shades of the alert faint, dark
    'shade' => 'faint',
    // should the alert type icon be shown
    'show_icon' => true,
    // for backward compatibility with laravel 8
    'showIcon'  => true,
    // should the close icon be shown
    'show_close_icon' => true,
    // for backward compatibility with laravel 8
    'showCloseIcon' => true,
    // additional css classes to add
    'class' => '',
    // additional colors to display
    'color' => null,
    // any Heroicons icon to use
    'icon' => '',
    // additional css to apply to $icon
    'icon_avatar_css' => '',
    // use avatar in place of an icon
    'avatar' => '',
    // size of the avatar
    'size' => 'tiny',
    'show_ring' => false,

    'colors' => [
        'dark' => [
            'error'   => [ 'css' => 'bg-error-500 text-white', 'icon_color' => '!text-error-200' ],
            'success' => [ 'css' => 'bg-success-500 text-white', 'icon_color' => '!text-success-200' ],
            'warning' => [ 'css' => 'bg-warning-500 text-white', 'icon_color' => '!text-warning-100' ],
            'info' => [ 'css' => 'bg-info-500 text-white', 'icon_color' => '!text-info-100' ],
            'red' => [ 'css' => 'bg-red-500', 'icon_color' => 'text-red-100' ],
            'yellow' => [ 'css' => 'bg-yellow-500 text-yellow-100', 'icon_color' => 'text-yellow-100' ],
            'green' => [ 'css' => 'bg-green-500 text-green-100', 'icon_color' => 'text-green-100' ],
            'blue' => [ 'css' => 'bg-blue-500 text-blue-100', 'icon_color' => 'text-blue-100' ],
            'cyan' => [ 'css' => 'bg-cyan-500 text-cyan-100', 'icon_color' => 'text-cyan-100' ],
            'purple' => [ 'css' => 'bg-purple-500 text-purple-100', 'icon_color' => 'text-purple-100' ],
            'gray' => [ 'css' => 'bg-slate-500 text-slate-100', 'icon_color' => 'text-slate-100' ],
            'pink' => [ 'css' => 'bg-pink-500 text-pink-100', 'icon_color' => 'text-pink-100' ],
            'violet' => [ 'css' => 'bg-violet-500 text-violet-100', 'icon_color' => 'text-violet-100' ],
            'indigo' => [ 'css' => 'bg-indigo-500 text-indigo-100', 'icon_color' => 'text-indigo-100' ],
            'fuchsia' => [ 'css' => 'bg-fuchsia-500 text-fuchsia-100', 'icon_color' => 'text-fuchsia-100' ],
            'orange' => [ 'css' => 'bg-orange-500 text-orange-100', 'icon_color' => 'text-orange-100' ],
            'transparent' => [ 'css' => 'bg-transparent border border border-slate-400 text-slate-700', 'icon_color' => 'text-slate-400' ],
        ],
        'faint' => [
            'error'    => [ 'css' => 'bg-error-100/80 text-error-600', 'icon_color' => 'text-error-600' ],
            'success'  => [ 'css' => 'bg-success-100/80 text-success-600', 'icon_color' => 'text-success-600' ],
            'warning'  => [ 'css' => 'bg-warning-100/80 text-warning-700', 'icon_color' => 'text-warning-700' ],
            'info'     => [ 'css' => 'bg-info-100/80 text-info-700', 'icon_color' => 'text-info-700' ],
            'red' => [ 'css' => 'bg-red-200/70 text-red-700', 'icon_color' => 'text-red-700' ],
            'yellow' => [ 'css' => 'bg-yellow-200/70 text-yellow-700', 'icon_color' => 'text-yellow-700' ],
            'green' => [ 'css' => 'bg-green-200/70 text-green-700', 'icon_color' => 'text-green-700' ],
            'blue' => [ 'css' => 'bg-blue-200/70 text-blue-700', 'icon_color' => 'text-blue-700' ],
            'cyan' => [ 'css' => 'bg-cyan-200/70 text-cyan-700', 'icon_color' => 'text-cyan-700' ],
            'purple' => [ 'css' => 'bg-purple-200/70 text-purple-700', 'icon_color' => 'text-purple-700' ],
            'gray' => [ 'css' => 'bg-slate-200/70 text-slate-700', 'icon_color' => 'text-slate-700' ],
            'pink' => [ 'css' => 'bg-pink-200/70 text-pink-700', 'icon_color' => 'text-pink-700' ],
            'violet' => [ 'css' => 'bg-violet-200/70 text-violet-700', 'icon_color' => 'text-violet-700' ],
            'indigo' => [ 'css' => 'bg-indigo-200/70 text-indigo-700', 'icon_color' => 'text-indigo-700' ],
            'fuchsia' => [ 'css' => 'bg-fuchsia-200/70 text-fuchsia-700', 'icon_color' => 'text-fuchsia-700' ],
            'orange' => [ 'css' => 'bg-orange-200/70 text-orange-700', 'icon_color' => 'text-orange-700' ],
            'transparent' => [ 'css' => 'bg-transparent border border border-slate-300/80 text-slate-700', 'icon_color' => 'text-slate-400' ],
        ],
    ]
])

@php
    // reset variables for Laravel 8 support
    $show_icon = filter_var($show_icon, FILTER_VALIDATE_BOOLEAN);
    $showIcon = filter_var($showIcon, FILTER_VALIDATE_BOOLEAN);
    $show_close_icon = filter_var($show_close_icon, FILTER_VALIDATE_BOOLEAN);
    $showCloseIcon = filter_var($showCloseIcon, FILTER_VALIDATE_BOOLEAN);
    if(!$showIcon) $show_icon = $showIcon;
    if(!$showCloseIcon) $show_close_icon = $showCloseIcon;
    $close_icon_css =  ($shade == 'dark') ? (($color =='transparent') ? 'text-gray-400 hover:text-gray-700' : 'text-white hover:text-gray-500')  : 'text-gray-500';
    $type = (!empty($color)) ? $color : $type;
@endphp

{{--<span class="!border-red-400 hidden"></span>--}}
<div class="w-full bw-alert animate__animated animate__fadeIn rounded-md flex p-3  {{$colors[$shade][$type]['css'] }} {{ $class }}">
    @if($show_icon)
        <div class="pt-[1px]">
            @if($icon !== '')
                <x-bladewind::icon :name="$icon" class="-mt-1 {{ $icon_avatar_css}}"/>
            @elseif($avatar !== '')
                <x-bladewind::avatar :image="$avatar" :show_ring="$show_ring" :size="$size"
                                     class="{{ $icon_avatar_css}}"/>
            @else
                <x-bladewind::modal-icon type="{{$type}}"
                                         class="!h-6 !w-6 -mt-1 {{ $colors[$shade][$type]['icon_color'] ??'' }}"/>
            @endif
        </div>
    @endif
    <div class="grow pl-2 pr-5">{{ $slot }}</div>
    @if($show_close_icon)
        <div class="text-right" onclick="this.parentElement.style.display='none'">
            <x-bladewind::icon name="x-mark"
                               class="h-6 w-6 p-1 cursor-pointer {{$close_icon_css}} hover:bg-white hover:rounded-full dark:hover:bg-slate-800 "/>
        </div>
    @endif
</div>
