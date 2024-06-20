@props([
    'onclick' => '',
    'title' => '',
    'href' => '',
])
@aware([
    'type' => 'primary',
    'color' => '',
    'size' => config('bladewind.button.circle.size', 'regular'),
    'name' => null,
    'can_submit' => false,
    'canSubmit' => false,
    'disabled' => false,
    'tag' => 'button',
    'icon' => '',
    'radius' => 'full',
    'button_text_css' => null,
    'show_focus_ring' => true,
    'outline' => false,
])

@php if($color == 'secondary') $type = 'secondary'; @endphp

<x-bladewind::button
        :color="$color"
        :size="$size"
        :name="$name"
        :can_submit="$can_submit"
        :disabled="$disabled"
        :show_focus_ring="$show_focus_ring"
        :outline="$outline"
        :tag="$tag"
        :icon="$icon"
        radius="full"
        :button_text_css="$button_text_css"
        :title="$title"
        :type="$type"
        circular="true"
        :onclick="$onclick"
        :href="$href"/>