@props([
    // determines types of icon to display. Available options: info, success, error, warning, empty
    // only the empty type has no icon. useful if you want your modal to contain a form
    'type' => 'info',
    'class' => '',
])
@php
    $success_css = ($type !== 'success') ? 'hidden' : '';
    $error_css = ($type !== 'error') ? 'hidden' : '';
    $info_css = ($type !== 'info') ? 'hidden' : '';
    $warning_css = ($type !== 'warning') ? 'hidden' : '';
    $class = sprintf( 'h-14 w-14 rounded-full modal-icon %s', $class);
@endphp
<x-bladewind::icon name="check-circle" class="success text-green-600 dark:!text-green-600 {{$class}} {{$success_css}}" />
<x-bladewind::icon name="hand-raised" class="error text-red-600 dark:!text-red-600 {{$class}} {{$error_css}}" />
<x-bladewind::icon name="exclamation-triangle" class="warning text-amber-600 dark:!text-amber-600 {{$class}} {{$warning_css}}" />
<x-bladewind::icon name="information-circle" class="info text-blue-600 dark:!text-blue-600 {{$class}} {{$info_css}}" />