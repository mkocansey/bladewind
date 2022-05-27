@props([
    // error, warning, success, info
    'type' => 'info', 
    // shades of the alert faint, dark
    'shade' => 'faint', 
    // should the alert type icon be shown
    'show_icon' => 'true',
    // for backward compatibility with laravel 8 
    'showIcon' => 'true', 
    // should the close icon be shown
    'show_close_icon' => 'true', 
    // for backward compatibility with laravel 8 
    'showCloseIcon' => 'true', 
    'class' => '', // additional css classes to add
    'color' => [
        'dark' => [
            'error' => 'bg-red-500',
            'success' => 'bg-green-500',
            'warning' => 'bg-yellow-500',
            'info' => 'bg-blue-500',
            'error_text' => 'text-white',
            'success_text' => 'text-white',
            'warning_text' => 'text-white',
            'info_text' => 'text-white'
        ],
        'faint' => [
            'error' => 'bg-red-100/80',
            'success' => 'bg-green-100/80',
            'warning' => 'bg-yellow-100/80',
            'info' => 'bg-blue-100/80',
            'error_text' => 'text-red-600',
            'success_text' => 'text-green-600',
            'warning_text' => 'text-yellow-700',
            'info_text' => 'text-blue-700'
        ],
    ]
])
@php 
    // reset variables for Laravel 8 support
    $show_icon = $showIcon;
    $show_close_icon = $showCloseIcon;
@endphp
<span class="!border-red-400 hidden"></span>
<div class="w-full bw-alert flex p-3 {{$color[$shade][$type]}} {{$color[$shade][$type.'_text']}} {{$class}}">
    @if($show_icon == 'true')
        <div>
            @if($type == 'error')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @elseif($type == 'info')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @elseif($type == 'warning')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        </div>
    @endif
    <div class="grow pl-2 pr-5">{{ $slot }}</div>
    @if($show_close_icon == 'true')
        <div class="text-right">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline cursor-pointer ml-3" viewBox="0 0 20 20" fill="currentColor" onclick="this.parentElement.parentElement.style.display='none'">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
        </div>
    @endif
</div>