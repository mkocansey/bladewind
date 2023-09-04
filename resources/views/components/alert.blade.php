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
    'class' => '', // additional css classes to add
    'color' => [
        'dark' => [
            'error'                 => 'bg-error-500',
            'success'               => 'bg-success-500',
            'warning'               => 'bg-warning-500',
            'info'                  => 'bg-info-500',
            'error_text'            => 'text-white',
            'success_text'          => 'text-white',
            'warning_text'          => 'text-white',
            'info_text'             => 'text-white',
            'error_icon_color'      => '!text-error-200',
            'success_icon_color'    => '!text-success-200',
            'warning_icon_color'    => '!text-warning-100',
            'info_icon_color'       => '!text-info-200'
        ],
        'faint' => [
            'error'             => 'bg-error-100/80',
            'success'           => 'bg-success-100/80',
            'warning'           => 'bg-warning-100/80',
            'info'              => 'bg-info-100/80',
            'error_text'        => 'text-error-600',
            'success_text'      => 'text-success-600',
            'warning_text'      => 'text-warning-700',
            'info_text'         => 'text-info-700'
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
@endphp
{{--<span class="!border-red-400 hidden"></span>--}}
<div class="w-full bw-alert rounded-md flex p-3 {{$color[$shade][$type] }} {{ $color[$shade][$type.'_text'] }} {{ $class }}">
    @if($show_icon)
        <div class="pt-[1px]">
            <x-bladewind::modal-icon type="{{$type}}" class="!h-6 !w-6 {{ $color[$shade][$type.'_icon_color']??'' }}" />
        </div>
    @endif
    <div class="grow pl-2 pr-5">{{ $slot }}</div>
    @if($show_close_icon)
        <div class="text-right">
            <x-bladewind::icon name="x-circle" class="h-5 w-5 inline cursor-pointer ml-3 opacity-60 hover:opacity-100 pt-[1px] dark:text-dark-100" />
        </div>
    @endif
</div>
