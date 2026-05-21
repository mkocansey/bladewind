{{-- format-ignore-start --}}
@props([
    'stacked' => config('bladewind.timeline.group.stacked', false),
    'completed' => false,
    'color' => config('bladewind.timeline.group.color', 'gray'),
    'anchor' => config('bladewind.timeline.group.anchor', 'small'),
    'anchorCss' => '',
    'icon' => '',
    'iconCss' => '',
    'dateCss' => '',
    'position' => 'center',
])
{{-- format-ignore-end --}}
{{$slot}}