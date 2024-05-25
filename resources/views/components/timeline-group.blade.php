@props([
    'stacked' => config('bladewind.timeline.group.stacked', false),
    'completed' => false,
    'color' => config('bladewind.timeline.group.color', 'gray'),
    'anchor' => config('bladewind.timeline.group.anchor', 'small'),
    'anchor_css' => '',
    'icon' => '',
    'icon_css' => '',
    'date_css' => '',
    'position' => 'center',
])
{{$slot}}