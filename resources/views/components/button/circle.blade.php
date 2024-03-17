@props([
    'onclick' => '',
    'title' => '',
    'href' => '',
])
@aware([
    'type' => 'primary',
    'color' => 'primary',
    'size' => 'regular',
    'name' => null,
    'can_submit' => false,
    'canSubmit' => false,
    'disabled' => false,
    'circular' => true,
    'tag' => 'button',
    'icon' => '',
    'radius' => 'full',
    'button_text_css' => null,
    'show_focus_ring' => true,
    'outline' => false,
])
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
        :button_text_css="$button_text_css"
        :title="$title"
        circular="true"
        :onclick="$onclick"
        :href="$href"/>