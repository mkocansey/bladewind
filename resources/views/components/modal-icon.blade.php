@props([
    // determines types of icon to display. Available options: info, success, error, warning, empty
    // only the empty type has no icon. useful if you want your modal to contain a form
    'type' => 'info',
    'class' => '',
    'icon' => '',
])
@php
    $class = sprintf( 'modal-icon %s %s', $class, $type);
    $default_icons = [
        'success'   => 'check-circle',
        'error'     => 'hand-raised',
        'warning'   => 'exclamation-triangle',
        'info'      => 'information-circle'
    ];
@endphp
<x-bladewind::icon name="{{$icon ?: ($default_icons[$type]) ?? '' }}" class="{{ $class}}"/>