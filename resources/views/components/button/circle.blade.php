@props([
    'tooltip' => '',

])
@aware([
    'type' => 'primary',
    'size' => 'regular',
    'name' => null,
    'can_submit' => false,
    'canSubmit' => false,
    'disabled' => false,
    'circular' => true,
    'tag' => 'button',
    'color' => 'primary',
    'icon' => '',
    'radius' => 'full',
    'button_text_css' => null,
    'show_focus_ring' => true,
    'tooltip' => '',
])
<x-bladewind::button :type="$type" :color="$color" :size="$size" :name="$name" :can_submit="$can_submit"
                     :disabled="$disabled" :show_focus_ring="$show_focus_ring" :tag="$tag" :icon="$icon"
                     :button_text_css="$button_text_css" circular/>