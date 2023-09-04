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

<div class="fixed flex flex-col-reverse {{ $position_css[str_replace(' ', '_', $position)] }} z-50 bw-notification-container w-11/12 sm:w-1/4"></div>
<div class="hidden bw-notification-icons"><x-bladewind::modal-icon /></div>

<script>
    @php include_once('vendor/bladewind/js/notification.js'); @endphp
    showNotification = (title, message, type, dismiss_in) => {
        new BladewindNotification(title, message, type, dismiss_in).show();
    }
</script>