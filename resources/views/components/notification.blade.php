@props([
    // where do you want the notification displayed
    // available options are top right, top center, top left, bottom right, bottom center, bottom left
    'position' => 'top right',
    'position_css' => [
        'top_right' => 'right-4 top-10',
        'right_top' => 'right-4 top-10',
        'top_left' => 'left-4 top-10',
        'left_top' => 'left-4 top-10',
        'bottom_right' => 'right-4 bottom-10',
        'right_bottom' => 'right-4 bottom-10',
        'bottom_left' => 'left-4 bottom-10',
        'left_bottom' => 'right-4 bottom-10',
        'top_center' => 'top-10', // FIXME::
        'center_top' => 'top-10',
        'bottom_center' => 'bottom-10', // FIXME::
        'center_bottom' => 'bottom-10',
    ]
])
@php
    // [type] is repalced with the type of notification in notification.js
    $css = "!h-14 !w-14 p-2 rounded-full bg-[type]-100/80 dark:bg-[type]-600 text-[type]-700 dark:text-[type]-100";
@endphp
<div class="fixed flex flex-col-reverse {{ $position_css[str_replace(' ', '_', $position)] }} z-50 bw-notification-container w-11/12 sm:!max-w-[450px]"></div>
{{--sm:w-1/4 sm:w-96 md:w-96  w-11/12--}}
<div class="bw-notification-icons hidden">
    <x-bladewind::modal-icon class="hidden {{$css}}"/>
    <x-bladewind::modal-icon class="hidden {{$css}}" type="error"/>
    <x-bladewind::modal-icon class="hidden {{$css}}" type="warning"/>
    <x-bladewind::modal-icon class="hidden {{$css}}" type="success"/>
</div>

<script>
    @php include_once('vendor/bladewind/js/notification.js'); @endphp
</script>